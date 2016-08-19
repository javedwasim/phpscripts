<?php

//==================================================================
//
//  Author: Javed  Wasim
//  email: javedafaq@gmail.com
//  Name: A Simple MySQL Class
//  Description: This class is written to make it easy to use mysql
//  with array variables. This is exceptionally useful when dealing
//  with HTML Post variables.
//
//===================================================================
//
// USER VARIABLES (Change these only!)

define('SIMPLE_DB_SERVER', 'localhost');
define('SIMPLE_DB_NAME', 'myapp');
define('SIMPLE_DB_USERNAME', 'root');
define('SIMPLE_DB_PASSWORD', '');

// END USER VARIABLES
//
//===================================================================


class ASimpleMySQLDB {

    var $db, $conn;

    public function __construct($server, $database, $username, $password){

        $this->conn = mysql_connect($server, $username, $password);
        $this->db = mysql_select_db($database,$this->conn);

    }

    public function insert_array($table, $insert_values) {

        foreach($insert_values as $key=>$value) {
            $keys[] = $key;
            $insertvalues[] = '\''.$value.'\'';
        }

        $keys = implode(',', $keys);
        $insertvalues = implode(',', $insertvalues);

        $sql = "INSERT INTO $table ($keys) VALUES ($insertvalues)";

         $this->sqlordie($sql);

    }

    public function update_array($table, $keyColumnName, $id, $update_values) {


        foreach($update_values as $key=>$value) {

            $sets[] = $key.'=\''.$value.'\'';

        }
        $sets = implode(',', $sets);

        $sql = "UPDATE $table SET $sets WHERE $keyColumnName = '$id'";

        $this->sqlordie($sql);
    }

    public function get_record_by_ID($table, $keyColumnName, $id, $fields = "*"){

        $sql = "SELECT $fields FROM $table WHERE $keyColumnName = '$id'";

        $result = $this->sqlordie($sql);
        
        return mysql_fetch_assoc($result);

    }

    public function get_records_by_group($table, $groupKeyName, $groupID, $orderKeyName = '', $order = 'ASC', $fields = '*'){

        $orderSql = '';
        if($orderKeyName != '') $orderSql = " ORDER BY $orderKeyName $order";
        $sql = "SELECT * FROM $table WHERE $groupKeyName = '$groupID'" . $orderSql;

        $result = $this->sqlordie($sql);

        while($row = mysql_fetch_assoc($result)) {

            $records[] = $row;

        }

        return $records;

    }

    private function sqlordie($sql) {
        
        $return_result = mysql_query($sql, $this->conn);
        if($return_result) {
            return $return_result;
        } else {
            $this->sql_error($sql);
        }
    }

    private function sql_error($sql) {
        echo mysql_error($this->conn).'<br>';
        die('error: '. $sql);
    }

}

?>