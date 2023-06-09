<?php
require_once "values.inc.php";
class Connection
{
    var $conn;
    function __construct()
    {
        global $servername;
        global $username;
        global $password;
        global $db;
        $this->conn = new mysqli($servername, $username, $password, $db);
        if ($this->conn->connect_error) {
            http_response_code(500);
            die(json_encode(array("error" => $this->conn->error)));
        }
    }
    function __destruct()
    {
        $this->conn->close();
    }
}
