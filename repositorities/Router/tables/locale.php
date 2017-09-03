<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 02.09.2017
 * Time: 22:41
 */

namespace gserver\repositorities\router\tables;


class locale
{
    /**
     * @var int
     */
    private $id = 0;

    /**
     * Enum no/yes
     *
     * @var string
     */
    private $main = 'no';

    /**
     * @var string
     */
    private $iso2 = '';

    /**
     * @param int $id
     */
    protected function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param string $iso2
     */
    protected function setIso2(string $iso2): void {
        $this->iso2 = $iso2;
    }

    /**
     * @return string
     */
    public function getIso2(): string {
        return $this->iso2;
    }

    /**
     * @param string $main
     */
    protected function setMain(string $main): void {
        $this->main = $main;
    }

    /**
     * @return string
     */
    public function getMain(): string {
        return $this->main;
    }

    /**
     * Returns the latest Dataset
     *
     * @return array
     */
    public function getDataset(): array {

        $vars = get_class_vars(__CLASS__);

        foreach ($vars as $key => &$value) {
            $function = 'get' . ucfirst($key);
            $value = $this->$function();
        }

        return $vars;

    }

    /**
     * Set all class properties from a Db result
     *
     * @param array $params
     */
    public function setDataset(array $params = []): void {

        $Reflection = new \ReflectionClass($this);
        $table = $Reflection->getShortName();

        if (empty($params)) {
            $row = Gserver()->Db()->fetchRow("SELECT * FROM " . $table . " ORDER BY id DESC");
        } else {

            if (count($params) !== 2) {
                // Failure
            }

            $key = array_shift($params);
            $value = array_shift($params);

            $row = Gserver()->Db()->fetchRow("SELECT * FROM " . $table . " WHERE " . $key . " = " . $value);

        }

        if (!empty($row)) {

            $vars = get_class_vars(__CLASS__);

            foreach ($row as $key => $value) {
                $function = 'set' . ucfirst(array_shift($vars));
                $this->$function($value);
            }

        } else {
            $this->setId(0);
        }

    }
}