<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib\Database;

interface Constraint
{
    /**
     * Construction function; long means long connection
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $name
     * @param bool $long
     */
    function __construct($host, $user, $password, $name, $long=false);

    /**
     * Close the connection
     */
    function close();

    /**
     * Query Database
     * @param string $query
     * @return \mysqli_result|resource
     */
    function query($query);

    /**
     * Fetch Array
     * @param \mysqli_result|resource $result
     * @param int $type
     * @return array
     */
    function fetch_array($result, $type = MYSQLI_ASSOC);

    /**
     * Query and Fetch Array
     * @param string $query
     * @return array
     */
    function xQuery($query);

    /**
     * Return number of rows
     * @param \mysqli_result|resource $result
     * @return int
     */
    function numRows($result);

    /**
     * Get auto increment number
     * @return int
     */
    function insertId();
}