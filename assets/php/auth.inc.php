<?php
header("Content-Type: application/json");
require "connection.inc.php";

if (isset($_GET["c"])) {
    $category = $_GET["c"];
    $auth = new Auth();
    switch ($category) {
        case "login":
            if (isset($_POST["username"]) && isset($_POST["password"])) {
                $auth->Login($_POST["username"], crypt($_POST["password"],  $salt));
            }
            break;
        case "register":
            if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["admin"])) {
                $auth->Register($_POST["username"], $_POST["password"], $_POST["admin"]);
            }
            break;
        default:
            http_response_code(401);
            die(json_encode(array("error" => "No such category: $category")));
            break;
    }
} else {
    http_response_code(401);
    die(json_encode(array("error" => "No category was specified!")));
}

class Auth
{
    var $connection;
    var $salt;
    function __construct()
    {
        $this->connection = new Connection();
    }

    function Login($username, $password)
    {
        $sql = "SELECT * from staff WHERE `username`=? AND `password`=? LIMIT 1; ";
        $stmt = $this->connection->conn->prepare($sql);
        if (!$stmt) {
            http_response_code(500);
            die(json_encode(array("error" => $this->connection->conn->error)));
        }
        if (!$stmt->bind_param("ss", $username, $password)) {
            http_response_code(500);
            die(json_encode(array("error" => $stmt->error)));
        }

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $data = $result->fetch_assoc();
                $id = $data["id"];
                $admin = $data["admin"];
                die(json_encode(array("id" => $id, "username" => $username, "password" => $password, "admin" => $admin)));
            } else {
                http_response_code(401);
                die(json_encode(array("error" => "Invalid username and/or password")));
            }
        }
    }
    function Register($username, $password, $admin)
    {
        $sql = "INSERT INTO `staff`( `username`, `password`, `admin`) VALUES (?,?,?)";
        $stmt = $this->connection->conn->prepare($sql);
        if (!$stmt) {
            http_response_code(500);
            die(json_encode(array("error" => "Unable to prepare SQL Statement")));
        }
        $stmt->bind_param("sss", $username, $password, $admin);
        if ($stmt->execute()) {
            http_response_code(200);
            die();
        } else {
            http_response_code(500);
            die(json_encode(array("error" => "Unable to register user!")));
        }
    }
}
