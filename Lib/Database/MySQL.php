<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib\Database;

use Exception;

class MySQL implements Constraint
{
    private $conn;
    private $result;

    public function __construct($host, $user, $password, $name, $long=false){
        $this->conn = $long?mysql_pconnect($host,$user,$password):mysql_connect($host,$user,$password);

        if(mysql_error()){
            throw new Exception('An MySQLi connection error is thrown: '.$this->getError());
        }

        if (mysql_get_server_info() > '4.1') {
            mysql_query("SET NAMES 'utf8'");
        }

        if(!mysql_select_db($name, $this->conn)) {
            throw new Exception('An error incurred when selecting DB');
        }
        return $this->conn;
    }

    public function close(){
        return mysql_close($this->conn);
    }

    public function query($sql){
        $this->result = @mysql_query($sql);
        if(!$this->result){
            throw new Exception('An MySQLi query error is thrown: '.$this->getError());
        }else{
            return $this->result;
        }
    }

    public function fetch_array($result, $type = MYSQLI_ASSOC) {
        return mysql_fetch_array($result, $type);
    }

    public function xQuery($query){
        $this->result = $this->query($query);
        return $this->fetch_array($this->result);
    }

    public function numRows($result){
        return mysql_num_rows($result);
    }

    public function insertId(){
        return mysql_insert_id();
    }

    private function getError() {
        return '#' . $this->getErrno() . ' - ' . mysql_error();
    }

    //Get error number
    private function getErrno() {
        return mysql_errno();
    }
}