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
    private function __construct() {}

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
    public static function getInstance(string $module): Db {

        if (self::$Instance === NULL) {

            $Db = new Db();
            $Db->connect($module);
            self::$Instance = $Db;

        }

        return self::$Instance;

    }

    /**
     * Establish the connection with the database
     *
     * @return void
     */
    private function connect(string $module): void {

        switch($module) {

            case "frontend":
                $config = DB_FRONTEND_CONFIG;
                break;
            case "backend":
                $config = DB_BACKEND_CONFIG;
                break;
            default:
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

        $this->prefix = $config['prefix'];

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
     * @return string
     */
    public function prepareSql(string $sql, $params = NULL): string {

        $countNeedle = substr_count($sql, '?');

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
                // Failure
            }
        } else {
            if ($countNeedle > 1) {
                // Failure
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
     * @return bool|\mysqli_result
     */
    private function sendQuery(string $sql, $params = NULL) {

        $prepared_sql = $this->prepareSql($sql, $params);

        $results = $this->Mysqli->query($prepared_sql);

        if (!empty($this->Mysqli->error)) {
            // Failure
        }

        if ($results->num_rows === 0) {
            return getZeroResultByFunction(debug_backtrace()[1]['function']);
        }

        return $results;

    }

    /**
     * Get the correct return type for zero result
     *
     * @param string $name
     *
     * @return array|string
     */
    private function getZeroResultByFunction(string $name) {

        // TODO: verify over ReflectionClass
        switch($name) {
            case "fetchOne":
                $type = '';
                break;
            case "fetchRow":
            case "fetchAll":
            case "fetchPairs":
            case "fetchKeyCollection":
                $type = [];
                break;
            default:
                // Failure
        }

        return $type;

    }

    /**
     * Returns the first cell
     *
     * @param string $sql
     * @param null|string|array $params
     *
     * @return bool|\mysqli_result
     */
    public function fetchOne(string $sql, $params = NULL) {

        $mysqliResult = $this->sendQuery($sql, $params);

        if (is_object($mysqliResult)) {
            while ($row = $mysqliResult->fetch_array()) {
                return $row[0];
            }
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
     * @return array
     */
    public function fetchRow($sql, $params = NULL): array {

        $mysqliResult = $this->sendQuery($sql, $params);

        if (is_object($mysqliResult)) {
            while ($row = $mysqliResult->fetch_array()) {
                return $row;
            }
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
     * @return array
     */
    public function fetchAll($sql, $params = NULL): array {
        $mysqliResult = $this->sendQuery($sql, $params);

        if (is_object($mysqliResult)) {

            $result = [];

            while ($row = $mysqliResult->fetch_array(MYSQLI_ASSOC)) {
                $result[] = $row;
            }
        } else {
            return $mysqliResult;
        }

        return $result;

    }

    /**
     * Returns array with the first parameter as key and the second as value
     *
     * @param string $sql
     * @param null|string|array $params
     *
     * @return array
     */
    public function fetchPairs($sql, $params = NULL): array {
        $mysqliResult = $this->sendQuery($sql, $params);

        if (is_object($mysqliResult)) {

            $result = [];

            while ($row = $mysqliResult->fetch_array(MYSQLI_NUM)) {
                $result[$row[0]] = $row[1];
            }
        } else {
            return $mysqliResult;
        }

        return $result;

    }

    /**
     * Returns an two dimensional numeric array with the first parameter as key and the second in a numeric collection
     *
     * @param string $sql
     * @param null|string|array $params
     *
     * @return array
     */
    public function fetchKeyPairCollection($sql, $params = NULL): array {

        $mysqliResult = $this->sendQuery($sql, $params);

        if (is_object($mysqliResult)) {

            $result = [];

            while ($row = $mysqliResult->fetch_array(MYSQLI_NUM)) {
                $result[$row[0]][] = $row[1];
            }
        } else {
            return $mysqliResult;
        }

        return $result;

    }

    /**
     * Returns an two dimensional array with the first parameter as key and the rest in a array collection
     *
     * @param string $sql
     * @param null|string|array $params
     *
     * @return array
     */
    public function fetchKeyCollection($sql, $params = NULL): array {

        $mysqliResult = $this->sendQuery($sql, $params);

        if (is_object($mysqliResult)) {

            $result = [];

            while ($row = $mysqliResult->fetch_array(MYSQLI_NUM)) {
                $result[array_shift($row)][] = $row;
            }
        } else {
            return $mysqliResult;
        }

        return $result;

    }

}