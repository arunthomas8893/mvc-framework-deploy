<?php

namespace App\Models\Common;

use PDO;

Class TableClass {

    private $connectionObject;
    private $childClassName;
    private $childClassObject;
    private $DBWrapperObject;

    public function setConnection($connectionObject) {
        $this->connectionObject = $connectionObject;
        $this->DBWrapperObject = new DBWrapper($this->connectionObject);
    }

    protected function initialize($childClassName, $childClassObject) {

        $this->childClassName = $childClassName;
        $this->childClassObject = $childClassObject;
    }

    /**
     *
     * Returns static::$dbnqOk if OK
     * @return string
     */
    public function insert(): string {
        return $this->DBWrapperObject->insert($this->childClassName, $this->childClassObject);
    }

    /**
     *
     * Returns lastInsertID
     * @return string
     */
    public function insertAndGetLastInsertID(): string {
        return $this->DBWrapperObject->insert($this->childClassName, $this->childClassObject, '1');
    }

    /**
     *
     * @param string $condition
     * @return string
     * Returns static::$dbnqOk if OK
     */
    public function update(string $condition, array $variableArray): string {

        return $this->DBWrapperObject->update($this->childClassName, $this->childClassObject, $condition, $variableArray);
    }

    /**
     *
     * @param string $condition
     * @return string
     * Returns affected row count
     */
    public function updateAndGetRowCount(string $condition, array $variableArray): string {
        return $this->DBWrapperObject->update($this->childClassName, $this->childClassObject, $condition, $variableArray, '2');
    }

    /**
     * Select all columns row and update present table object
     * @param type $classobject
     * @param string $condition
     * @param array $variableArray
     * Use with a wrapper in child table class
     */
    public function selectRow(string $condition, array $variableArray) {
        return $this->DBWrapperObject->selectRow($this->childClassName, $this->childClassObject, $condition, $variableArray);
    }

    /**
     * Select chosen columns row and update present table object
     * @param type $classobject
     * @param string $condition
     * @param array $variableArray
     * Use with a wrapper in child table class
     */
    public function selectMultipleColumnRow($classobject, string $columns, string $condition, array $variableArray) {
        return $this->DBWrapperObject->selectMultipleColumnRow($this->childClassName, $classobject, $columns, $condition, $variableArray);
    }

    /**
     * Returns DB_Wrapper::$dbNullResult for zero if extra is not set as '1'
     * @param string $column
     * @param string $condition
     * @param array $variableArray
     * @param string $extra
     * @return type
     */
    public function selectMultipleValues(string $columns, string $condition, array $variableArray, string $extra = '0') {
        return $this->DBWrapperObject->selectMultipleValues($this->childClassName, $columns, $condition, $variableArray, $extra);
    }

    public function selectSingleValue(string $column, string $condition, array $variableArray, string $extra = '0') {
        return $this->DBWrapperObject->selectSingleValue($this->childClassName, $column, $condition, $variableArray, $extra);
    }

    /**
     * Returns DB_Wrapper::$dbNullResult for zero if extra is not set as '1'
     * @param string $column
     * @param string $condition
     * @param array $variableArray
     * @param string $extra
     * @return type
     */
    public function MAX(string $column, string $condition = '', array $variableArray = array(''), string $extra = '0') {
        $column = " MAX($column) ";
        return $this->selectSingleValue($column, $condition, $variableArray);
    }

    /**
     * Returns DB_Wrapper::$dbNullResult for zero if extra is not set as '1'
     * @param string $column
     * @param string $condition
     * @param array $variableArray
     * @param string $extra
     * @return type
     */
    public function SUM(string $column, string $condition = '', array $variableArray = array(''), string $extra = '0') {
        $column = " SUM($column) ";
        return $this->selectSingleValue($column, $condition, $variableArray);
    }

    /**
     * Count rows based on a column
     *
     * @param string $column
     * @param string $condition
     * @param array $variableArray
     * @return type
     */
    public function COUNT(string $column, string $condition = '', array $variableArray = array('')) {
        $column = " (COUNT($column)+0) ";
        return $this->selectSingleValue($column, $condition, $variableArray, '1');
    }

    /**
     * Selects multiple columns and use for each to assign each row to table object
     * @param string $columns
     * @param string $condition
     * @param array $variableArray
     * @return type
     * Example:-
     * $t=new table class($connectionObject)
     * $rows = $t->selctRows($columns, $condition, $variableArray);
     * foreach ($rows as $t) { $t-> }
     */
    public function selectRows(string $columns, string $condition, array $variableArray) {
        return $this->DBWrapperObject->selectRows($this->childClassName, $columns, $condition, $variableArray);
    }

    /**
     * Resets a table object
     */
    public function reset() {
        $clean = new self;
        foreach ($this as $key => $val) {
            if (isset($clean->$key)) {
                $this->$key = $clean->$key;
            }
        }
    }

}
