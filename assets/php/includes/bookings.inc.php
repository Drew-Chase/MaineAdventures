<?php
header("Content-Type: application/json");
require_once "connection.inc.php";
require_once "hashids.inc.php";

if (isset($_GET["c"])) {
    $bookings = new Bookings();
    switch ($_GET["c"]) {
        case "create":
            if (
                isset($_POST["first_name"]) &&
                isset($_POST["last_name"]) &&
                isset($_POST["email"]) &&
                isset($_POST["phone"]) &&
                isset($_POST["adults"]) &&
                isset($_POST["children"]) &&
                isset($_POST["pets"]) &&
                isset($_POST["cabin"]) &&
                isset($_POST["arrival"]) &&
                isset($_POST["departure"]) &&
                isset($_POST["seasonal"]) &&
                isset($_POST["credits"])
            ) {
                $bookings->Create(
                    $_POST["first_name"],
                    $_POST["last_name"],
                    $_POST["email"],
                    $_POST["phone"],
                    $_POST["adults"],
                    $_POST["children"],
                    $_POST["pets"],
                    $_POST["cabin"],
                    $_POST["arrival"],
                    $_POST["departure"],
                    $_POST["seasonal"],
                    $_POST["credits"]
                );
            } else {
                http_response_code(401);
                die(json_encode(array("error" => "Missing required fields!")));
            }
            break;
        case "today":
            break;
        case "calendar":
            break;
        case "search":
            break;
        default:
            break;
    }
}

class Bookings
{
    function GetArrivingToday()
    {
    }
    function GetDepartingToday()
    {
    }
    function Create($fname, $lname, $email, $phone, $adults, $children, $pets, $cabin, $arrival, $departure,  $seasonal,  $credits)
    {
        $connection = new Connection();
        $sql = "INSERT INTO `bookings`( `fname`, `lname`, `email`, `phone`, `adults`, `children`, `pets`, `cabin`, `arrival`, `departure`, `seasonal`, `credits`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $connection->conn->prepare($sql);
        if (!$stmt) {
            http_response_code(500);
            die(json_encode(array("error" => "Unable to prepare SQL Statement")));
        }
        $stmt->bind_param("ssssssssssss", $fname, $lname, $email, $phone, $adults, $children, $pets, $cabin, $arrival, $departure,  $seasonal,  $credits);
        if ($stmt->execute()) {
            http_response_code(200);
            $id = $connection->conn->insert_id;
            global $hashids;
            $id = $hashids->encode($id);
            die(json_encode(["id" => $id]));
        } else {
            http_response_code(500);
            die(json_encode(array("error" => "Unable to create booking!")));
        }
    }
}
