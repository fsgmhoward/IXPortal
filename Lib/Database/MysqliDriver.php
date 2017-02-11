<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib\Database;

use mysqli;

class MysqliDriver implements DatabaseContract
{
    private $conn;
    private $result;

    public function __construct($host, $user, $password, $name, $long = false)
    {
        $hostX = explode(':', $host);
        if ($hostX[0] == $host) {
            @$this->conn = new mysqli(($long ? 'p:' : '') . $host, $user, $password, $name);
        } else {
            @$this->conn = new mysqli(($long ? 'p:' : '') . $hostX[0], $user, $password, $name, $hostX[1]);
        }

        if ($this->conn->connect_error) {
            throwException('ERR_DB_CONN', $this->getConnectError());
        }

        $this->conn->set_charset('utf8');
        return $this->conn;
    }

    public function close()
    {
        $this->conn->close();
    }

    //Query
    public function query($query)
    {
        $this->result = $this->conn->query($query);
        if (!$this->result) {
            throwException('ERR_DB_QUERY', $this->getError());
        } else {
            return $this->result;
        }
    }

    public function fetch_array($result = null, $type = MYSQLI_ASSOC)
    {
        return ($result ?: $this->result)->fetch_array($type);
    }

    public function hasResult($query)
    {
        $this->result = $this->query($query);
        return $this->numRows($this->result) ? true : false;
    }

    public function xQuery($query)
    {
        $this->result = $this->query($query);
        return $this->fetch_array($this->result);
    }

    public function numRows($result)
    {
        return $result->num_rows;
    }

    public function insertId()
    {
        return $this->conn->insert_id;
    }

    //Get connection error information
    private function getConnectError()
    {
        return '#' . $this->conn->connect_errno . ' - ' . $this->conn->connect_error;
    }

    //Get error information
    private function getError()
    {
        return '#' . $this->getErrno() . ' - ' . $this->conn->error;
    }

    //Get error number
    private function getErrno()
    {
        return $this->conn->errno;
    }
}
