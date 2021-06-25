<?php

namespace App\Models\Common;

use PDO;

class DBWrapper {

    private $db;
    public static $dbNullResult = "w23samsaijo";
    public static $dbnqOk = "1qw23samsaijo";

    function __construct(PDO $sqlConnection) {
        $this->db = $sqlConnection;
    }

    public function dbnq(string $sql, array $variableArray = array(''), string $specialCommands = '0'): string {
        /* 1=lastInsertId,2=rowCount */


        $stmt = $this->db->prepare($sql);
        $stmt->execute($variableArray);
        if ($specialCommands == '2') {
            return $stmt->rowCount();
        } elseif ($specialCommands == '1') {
            return $this->db->lastInsertId();
        } elseif ($specialCommands == '0') {
            return static::$dbnqOk;
        }
    }

    public function dbsq(string $sql, array $variableArray = array(''), string $option = '0'): string {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($variableArray);
        if ($option == '0') {
            if ($result = $stmt->fetchColumn()) {
                return $result;
            } else {
                return static::$dbNullResult;
            }
        } elseif ($option == '1') {
            $result = $stmt->fetchColumn();
            return $result;
        }
    }

    public function dbrq(string $sql, array $variableArray = array('')) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($variableArray);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function dbq(string $sql, array $variableArray = array('')) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($variableArray);
        return $stmt->fetchAll();
    }

    private function dbqClassRows(string $tableClassName, string $sql, array $variableArray = array('')) {


        $stmt = $this->db->prepare($sql);
        $stmt->execute($variableArray);
        return $stmt->fetchALL(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $tableClassName);
    }

    private function dbqIntoObject($classObject, string $sql, array $variableArray = array('')) {

        $stmt = $this->db->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_INTO, $classObject);
        $stmt->execute($variableArray);
        return $stmt->fetch();
    }

    private function dbReport($sql, $variableArray = array('')): string {

        $stmt = $this->db->prepare($sql);
        $stmt->execute($variableArray);
        $result = $stmt->fetchAll();
        $rowCount = $stmt->rowCount();
        $columnCount = $stmt->columnCount();
        if ($rowCount > 0) {
            $firstIncrementor = 0;
            while ($firstIncrementor < $columnCount) {
                $meta = $stmt->getColumnMeta($firstIncrementor);
                $myarray[$firstIncrementor] = $meta['name'];
                $firstIncrementor = $firstIncrementor + 1;
            }
            $limit = $firstIncrementor - 1;
            $reusltTable = "";
            $reusltTable = '<table id="tbl" style="width:100%" class="display cell-border"><thead><tr><th>Slno</th>';
            for ($secondIncrementor = 0; $secondIncrementor <= $limit; $secondIncrementor++) {
                $reusltTable = $reusltTable . '<th>' . $myarray[$secondIncrementor] . '</th>';
            }
            $reusltTable = $reusltTable . '</tr></thead><tbody>';
            $slno = 1;
            foreach ($result as $rs) {
                $reusltTable = $reusltTable . '<tr><td>' . $slno . '</td>';
                for ($secondIncrementor = 0; $secondIncrementor <= $limit; $secondIncrementor++) {
                    $reusltTable = $reusltTable . '<td>' . $rs[$myarray[$secondIncrementor]] .
                            '</td>';
                }
                $reusltTable = $reusltTable . '</tr>';
                $slno++;
            }
            $reusltTable = $reusltTable . '</tbody></table></div>';
            return $reusltTable;
        } else {
            $reusltTable = '<center><div style="color:#f00;font-size:14px;">No results found</div></center>';
            return $reusltTable;
        }
    }

    public function insert(string $tableClassName, $classObject, $specialCommands = '0'): string {
        $colCollection = "";
        $qmarks = "";
        $values = array();
        foreach ($classObject as $key => $value) {
            if ($value != Values::$nullStringForTableClass) {
                $colname = 'c_' . $key;
                if ($colCollection == "") {
                    $colCollection = $tableClassName::${$colname};
                    $qmarks = '?';
                    $values[] = $value;
                } else {
                    $colCollection = $colCollection . ', ' . $tableClassName::${$colname};
                    $qmarks = $qmarks . ', ?';
                    $values[] = $value;
                }
            }
        }

        $tableName = $tableClassName::$t_name;
        $sql = "INSERT INTO $tableName ($colCollection) VALUES ($qmarks);";
        return $this->dbnq($sql, $values, $specialCommands);
        //return $sql.'<br/>'.print_r($values,true);
    }

    public function update(string $tableClassName, $classObject, string $condition, array $variableArray, $specialCommands = '0'): string {
        $colCollection = "";
        $values = array();
        foreach ($classObject as $key => $value) {
            if ($value != Values::$nullStringForTableClass) {
                $colname = 'c_' . $key;

                if ($colCollection == "") {
                    $colCollection = $tableClassName::${$colname} . '=?';
                    $values[] = $value;
                } else {
                    $colCollection = $colCollection . ', ' . $tableClassName::${$colname} . '=?';
                    $values[] = $value;
                }
            } elseif ($value === 0) {
                $colname = 'c_' . $key;

                if ($colCollection == "") {
                    $colCollection = $tableClassName::${$colname} . '=?';
                    $values[] = $value;
                } else {
                    $colCollection = $colCollection . ', ' . $tableClassName::${$colname} . '=?';
                    $values[] = $value;
                }
            }
        }
        $combined = array_merge($values, $variableArray);
        $sql = "UPDATE " . $tableClassName::$t_name . " SET $colCollection $condition ;";
        $result = $this->dbnq($sql, $combined, $specialCommands);
        return $result;
        //return $sql.'<br/>'.print_r($values,true);
    }

    public function selectRow(string $tableClassName, $classobject, string $condition, array $variableArray) {
        $sql = "SELECT * FROM " . $tableClassName::$t_name . ' ' . $condition;
        return $this->dbqIntoObject($classobject, $sql, $variableArray);
    }

    public function selectSingleValue(string $tableClassName, string $column, string $condition, array $variableArray, string $extra = '0') {
        $sql = "SELECT $column FROM " . $tableClassName::$t_name . ' ' . $condition;
        return $this->dbsq($sql, $variableArray, $extra);
    }

    public function selectMultipleValues(string $tableClassName, string $columns, string $condition, array $variableArray, string $extra = '0') {
        $sql = "SELECT $columns FROM " . $tableClassName::$t_name . ' ' . $condition;
        return $this->dbrq($sql, $variableArray, $extra);
    }

    public function selectMultipleColumnRow(string $tableClassName, $classobject, string $columns, string $condition, array $variableArray) {
        $sql = "SELECT $columns FROM " . $tableClassName::$t_name . ' ' . $condition;
        return $this->dbqIntoObject($classobject, $sql, $variableArray);
    }

    public function selectRows(string $tableClassName, $columns, $condition, array $variableArray) {
        $sql = "SELECT $columns FROM " . $tableClassName::$t_name . ' ' . $condition;
        return $this->dbqClassRows($tableClassName, $sql, $variableArray);
    }

}
