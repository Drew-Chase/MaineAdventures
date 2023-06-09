<?php
require_once "hashids.inc.php";
require_once "connection.inc.php";
$adults = "";
$children = "";
$pets = "";
$cabin = "";
$price = "";
$arrival = "";
$departure = "";
$pricePerNight = "";
$paid = false;
$pricePerAdult = 0;
$pricePerChild = 0;
$pricePerPet = 0;
$nights = 0;
$credit = 0;

$connection = new Connection();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $id = $hashids->decode($id)[0];
    $sql = "SELECT * FROM `bookings` WHERE `id`=? LIMIT 1;";
    $stmt = $connection->conn->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
    }
    if (!$stmt->bind_param("s", $id)) {
        http_response_code(500);
    }
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $name = $data["name"];
            $adults = $data["adults"];
            $children = $data["children"];
            $pets = $data["pets"];
            $cabin = $data["cabin"];
            $credit = floatval($data["credits"]);
            $arrival = date_create($data["arrival"]);
            $departure = date_create($data["departure"]);
            $paid = $data["paid"] == 1;
            $nights = round((strtotime($data["departure"]) - strtotime($data["arrival"])) / (24 * 60 * 60));
        }
    }
} else if (
    isset($_POST["adults"]) &&
    isset($_POST["children"]) &&
    isset($_POST["pets"]) &&
    isset($_POST["cabin"]) &&
    isset($_POST["arrival"]) &&
    isset($_POST["departure"]) &&
    isset($_POST["seasonal"])
) {

    $adults = $_POST["adults"];
    $children = $_POST["children"];
    $pets = $_POST["pets"];
    $cabin = $_POST["cabin"];
    $price = $_POST["seasonal"];
    $arrival = $_POST["arrival"];
    $departure = $_POST["departure"];
    $nights = round((strtotime($departure) - strtotime($arrival)) / (24 * 60 * 60));
    $arrival = date_create($arrival);
    $departure = date_create($departure);
} else {
    echo $_POST["adults"];
    echo $_POST["children"];
    echo $_POST["pets"];
    echo $_POST["cabin"];
    echo $_POST["seasonal"];
    echo $_POST["arrival"];
    echo $_POST["departure"];
    die;
}


$sql = "SELECT * FROM `cabins` WHERE `name`=? LIMIT 1;";
$stmt = $connection->conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
}
if (!$stmt->bind_param("s", $cabin)) {
    http_response_code(500);
}
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $cabin = $data["name"];
        $pricePerNight = $data["price"];
    }
}
$sql = "SELECT * FROM `pricing`;";
$stmt = $connection->conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
}
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while (($data = $result->fetch_assoc()) != null) {
            $name = $data["name"];
            if ($name == "adults") {
                $pricePerAdult = $data["price"];
            } else if ($name == "children") {
                $pricePerChild = $data["price"];
            } else if ($name == "pets") {
                $pricePerPet = $data["price"];
            }
        }
    }
}
$price = 0;
$price += $nights * $pricePerNight;
$price += $adults * $pricePerAdult * $nights;
$price += $children * $pricePerChild * $nights;
$price += $pets * $pricePerPet * $nights;
$subtotal = $price;
$price -= $credit;
