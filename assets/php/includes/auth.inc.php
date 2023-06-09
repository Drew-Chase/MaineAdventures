<?php
require "connection.inc.php";

if (isset($_GET["c"])) {
    header("Content-Type: application/json");
    $category = $_GET["c"];
    $auth = new Auth();
    switch ($category) {
        case "login":
            if (isset($_POST["username"]) && isset($_POST["password"])) {
                die($auth->Login($_POST["username"], $_POST["password"]));
            }
            break;
        case "register":
            if (isset($_POST["username"]) && isset($_POST["password"])) {
                die($auth->Register($_POST["username"], $_POST["password"]));
            }
            break;
        default:
            http_response_code(401);
            die(json_encode(array("error" => "No such category: $category")));
            break;
    }
}

class Auth
{
    var $connection;
    var $salt;

    function __construct()
    {
        $this->connection = new Connection();
    }

    function LoginWithCookies()
    {
        $username = $_COOKIE["username"];
        $password = $_COOKIE["password"];
        return $this->Login($username, $password);
    }



    function Login($username, $password): string
    {
        global $salt;
        $password = crypt($_POST["password"], $salt);
        return $this->LoginWithToken($username, $password);
    }

    function LoginWithToken($username, $password)
    {
        $sql = "SELECT * from staff WHERE `username`=? AND `password`=? LIMIT 1; ";
        $stmt = $this->connection->conn->prepare($sql);
        if (!$stmt) {
            http_response_code(500);
            return json_encode(array("error" => $this->connection->conn->error));
        }
        if (!$stmt->bind_param("ss", $username, $password)) {
            http_response_code(500);
            return json_encode(array("error" => $stmt->error));
        }

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $data = $result->fetch_assoc();
                $id = $data["id"];
                return json_encode(array("id" => $id, "username" => $username, "password" => $password));
            } else {
                http_response_code(401);
                return json_encode(array("error" => "Invalid username and/or password"));
            }
        }
        return json_encode(array("error" => "Unknown issue"));
    }

    function Register($username, $password)
    {
        global $salt;
        $password = crypt($_POST["password"], $salt);
        $sql = "INSERT INTO `staff`( `username`, `password`) VALUES (?,?)";
        $stmt = $this->connection->conn->prepare($sql);
        if (!$stmt) {
            http_response_code(500);
            die(json_encode(array("error" => "Unable to prepare SQL Statement")));
        }
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            http_response_code(200);
            die();
        } else {
            http_response_code(500);
            return json_encode(array("error" => "Unable to register user!"));
        }
    }
}
