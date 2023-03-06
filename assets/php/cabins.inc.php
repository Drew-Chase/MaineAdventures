<?php
header("Content-Type: application/json");
require "connection.inc.php";
$cabins = new Cabins();
if (isset($_GET["c"])) {
    switch ($_GET["c"]) {
        case "get":
            $cabins->GetCabins();
            break;
        default:
            http_response_code(500);
            die(json_encode(["error" => "No such category was found: " . $_GET["c"]]));
            break;
    }
} else {
    http_response_code(404);
    die(json_encode(["error" => "No category was specified!"]));
}

class Cabins
{
    var $connection;
    function __construct()
    {
        $this->connection = new Connection();
    }

    function GetCabins()
    {
        $conn = $this->connection->conn;
        $sql = "SELECT * FROM `cabins`";
        $query = $conn->query($sql);
        if ($query && $query->num_rows > 0) {
            $cabins = array();
            while ($result = $query->fetch_assoc()) {
                array_push($cabins, $result);
            }
            http_response_code(200);
            die(json_encode($cabins));
        }
    }
}
