<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 28.07.2017
 * Time: 23:23
 */

declare(strict_types=1);

namespace gserver\core;


final class Db
{

    /**
     * Contains the Instance
     *
     * @var Db|null
     */
    private static $Instance = NULL;

    /**
     * Contains a Mysqli Instance
     *
     * @var \mysqli
     */
    private $Mysqli;

    /**
     * Contains the table prefix
     *
     * @var string
     */
    private $prefix = '';

    /**
     * Db constructor.
     */
    private function __construct(string $module) {

        switch($module) {

            case "frontend":
                $config = DB_FRONTEND_CONFIG;
                break;
            case "backend":
                $config = DB_FRONTEND_CONFIG;
                break;

        }

        $this->Mysqli = new \mysqli(
            $config['host'],
            $config['user'],
            $config['password'],
            $config['dbname'],
            $config['port'],
            $config['socket']
        );

        $this->Mysqli->set_charset("utf8");

        $this->prefix = $config['prefix'];
    }

    /**
     * Singleton pattern don't allow clone
     */
    private function __clone() {}

    /**
     * Initiate the Instance and return it
     *
     * @param string $module
     *
     * @return Db
     */
    public static function getInstance(string $module = ""): Db {

        if (self::$Instance === NULL) {
            self::$Instance = new Db($module);
        }

        return self::$Instance;

    }

    /**
     * Sends the query to the database after preparing
     *
     * @param string $sql
     * @param null|string|array $params
     *
     * @return void
     */
    public function query(string $sql, $params = NULL): void {
        $this->Mysqli->query($this->prepareSql($sql, $params));
    }

    /**
     * Prepare the sql string and replace placeholder
     *
     * @param string $sql
     * @param null|string|array $params
     *
     * @throws \Exception
     *
     * @return string
     */
    public function prepareSql(string $sql, $params = NULL): string {

        $backtrace = debug_backtrace()[2]['file'].":".debug_backtrace()[2]['line'];

        $countNeedle = substr_count($sql, '?');

        $info = 'unequal needles : expect '.$countNeedle.', ';

        if ($params[0] === NO_PREFIX) {
            array_shift($params);
        } else {
            $sql = str_replace('FROM ', 'FROM ' . $this->prefix, $sql);
        }

        if ($countNeedle === 0 && $params === NULL) {
            return $sql;
        }

        if (is_array($params)) {

            $count = count($params);

            if ($count === $countNeedle) {
                $parts = explode('?', trim($sql));

                $sql = '';

                foreach ($params as $key => $val) {
                    $sql .= $parts[$key] . '"' . $val . '"';
                }
                if (($lastElement = end($parts)) !== false) {
                    $sql .= $lastElement;
                }
            } else {
                throw new \Exception($info.$count. ' is given.' . $backtrace);
            }
        } else {
            if ($countNeedle > 1) {
                throw new \Exception($info. 'params must be given as array.' . $backtrace);
            } else {
                $sql = str_replace("?", "'" . $params . "'", $sql);
            }
        }

        return $sql;

    }

    /**
     * Helper function for all fetch functions
     *
     * @param string $sql
     * @param null|string|array $params
     *
     * @throws \Exception
     *
     * @return bool|\mysqli_result
     */
    private function sendQuery(string $sql, $params = NULL) {

        $prepared_sql = $this->prepareSql($sql, $params);

        $results = $this->Mysqli->query($prepared_sql);

        $info = debug_backtrace()[1];

        if (!empty($this->Mysqli->error)) {
            throw new \Exception($sql . ' ' . $info['file'] . ":" . $info['line']);
        }

        if ($results->num_rows === 0) {
            return $this->getZeroResultByFunction($info['function']);
        }

        return $results;

    }

    /**
     * Get the correct return type for zero result
     *
     * @param string $name
     *
     * @throws \Exception
     *
     * @return string|array
     */
    private function getZeroResultByFunction(string $name) {

        $Reflection = new \ReflectionClass($this);

        $docComment = $Reflection->getMethod($name)->getDocComment();

        $dataType = trim(explode('|', explode('@return ',$docComment)[1])[0]);

        switch($dataType) {
            case 'string':
                return '';
            case 'array':
                return [];
            default:
                throw new \Exception('unknown return type '.$dataType.' from function '.$name);
        }

    }

    /**
     * Returns the first cell
     *
     * @param string $sql
     * @param null|string|array $params
     *
     * @return string|bool|\mysqli_result
     */
    public function fetchOne(string $sql, $params = NULL) {

        $mysqliResult = $this->sendQuery($sql, $params);

        if (is_object($mysqliResult)) {
            return $mysqliResult->fetch_array()[0];
        }
        else {
            return $mysqliResult;
        }

    }

    /**
     * Returns the first row
     *
     * @param string $sql
     * @param null|string|array $params
     *
     * @return array|bool|\mysqli_result
     */
    public function fetchRow($sql, $params = NULL) {

        $mysqliResult = $this->sendQuery($sql, $params);

        if (is_object($mysqliResult)) {
            return $mysqliResult->fetch_array(MYSQLI_ASSOC);
        }
        else {
            return $mysqliResult;
        }

    }

    /**
     * Returns all founded rows in a collection
     *
     * @param string $sql
     * @param null|string|array $params
     *
     * @return array|bool|\mysqli_result
     */
    public function fetchAll($sql, $params = NULL) {

        $mysqliResult = $this->sendQuery($sql, $params);

        if (is_object($mysqliResult)) {

            $result = [];
            while ($row = $mysqliResult->fetch_array(MYSQLI_ASSOC)) {
                $result[] = $row;
            }

            return $result;

        } else {
            return $mysqliResult;
        }

    }

    /**
     * Returns array with the first parameter as key and the second as value
     *
     * @param string $sql
     * @param null|string|array $params
     *
     * @dataType string
     *
     * @return array|bool|\mysqli_result
     */
    public function fetchPairs($sql, $params = NULL): array {

        $mysqliResult = $this->sendQuery($sql, $params);

        if (is_object($mysqliResult)) {

            $result = [];
            while ($row = $mysqliResult->fetch_array(MYSQLI_NUM)) {
                $result[$row[0]] = $row[1];
            }

            return $result;

        } else {
            return $mysqliResult;
        }

    }

    /**
     * Returns an two dimensional numeric array with the first parameter as key and the second in a numeric collection
     *
     * @param string $sql
     * @param null|string|array $params
     *
     * @return array|bool|\mysqli_result
     */
    public function fetchKeyPairCollection($sql, $params = NULL): array {

        $mysqliResult = $this->sendQuery($sql, $params);

        if (is_object($mysqliResult)) {

            $result = [];
            while ($row = $mysqliResult->fetch_array(MYSQLI_NUM)) {
                $result[$row[0]][] = $row[1];
            }

            return $result;

        } else {
            return $mysqliResult;
        }

    }

    /**
     * Returns an two dimensional array with the first parameter as key and the rest in a array collection
     *
     * @param string $sql
     * @param null|string|array $params
     *
     * @return array|bool|\mysqli_result
     */
    public function fetchKeyCollection($sql, $params = NULL): array {

        $mysqliResult = $this->sendQuery($sql, $params);

        if (is_object($mysqliResult)) {

            $result = [];
            while ($row = $mysqliResult->fetch_array(MYSQLI_NUM)) {
                $result[array_shift($row)][] = $row;
            }

            return $result;

        } else {
            return $mysqliResult;
        }

    }

}