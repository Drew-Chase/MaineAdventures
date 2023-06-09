<?php
require_once "connection.inc.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/php/includes/hashids.inc.php";
$cabins = new Cabins();
if (isset($_GET["c"])) {
    switch ($_GET["c"]) {
        case "get":
            http_response_code(200);
            die(json_encode($cabins->GetCabins()));
            break;
        case "upload":
            if (isset($_FILES) && isset($_GET['id'])) {
                die(json_encode(["success" => $cabins->UploadImage($_GET['id'])]));
            }
            break;
        case "update":
            die(json_encode(["success" => $cabins->UpdateCabin(file_get_contents('php://input'))]));
            break;
        case "delete":
            if (isset($_GET['id'])) {
                die(json_encode(["success" => $cabins->DeleteCabin($_GET["id"])]));
            }

            break;
        default:
            http_response_code(500);
            die(json_encode(["error" => "No such category was found: " . $_GET["c"]]));
            break;
    }
}

class Cabins
{
    var $connection;
    function __construct()
    {
        $this->connection = new Connection();
    }
    function UploadImage($id)
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/cabins/$id.webp";
        $image = "image";
        $tempFile = $_FILES[$image]['tmp_name'];

        $ffmpegCommand = "ffmpeg -y -i $tempFile $path";
        exec($ffmpegCommand, $output, $returnCode);

        if ($returnCode === 0) {
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }
            return true;
        } else {
            return false;
        }
    }

    function DeleteCabin($id)
    {
        $conn = $this->connection->conn;
        global $hashids;
        $image = $_SERVER["DOCUMENT_ROOT"] . "/assets/images/cabins/$id.webp";
        $id = $hashids->decode($id)[0];

        // Prepare and execute the SQL statement
        $stmt = $conn->prepare("DELETE FROM `cabins` WHERE `id` = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();


        if ($result) {
            // Cabin deleted successfully
            if (file_exists($image)) {
                unlink($image);
            }
            return true;
        } else {
            // Error occurred while deleting the cabin
            return false;
        }
    }

    function UpdateCabin($json)
    {
        $data = json_decode($json, true);
        if (!$data) {
            // Invalid JSON format
            return false;
        }
        global $hashids;
        $conn = $this->connection->conn;
        $id = $hashids->decode($data['id'])[0];
        $name = $data['name'];
        $people = $data['people'];
        $price = $data['price'];
        $seasonal = $data['seasonal'];

        // Check if cabin exists
        $stmt = $conn->prepare("SELECT * FROM `cabins` WHERE `id` = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Cabin exists, perform update
            $stmt = $conn->prepare("UPDATE `cabins` SET `name` = ?, `people` = ?, `price` = ?, `seasonal` = ? WHERE `id` = ?");
            $stmt->bind_param("siiii", $name, $people, $price, $seasonal, $id);
            $result = $stmt->execute();

            if ($result) {
                // Cabin row updated successfully
                return true;
            } else {
                // Error occurred while updating the cabin row
                return false;
            }
        } else {
            // Cabin does not exist, perform insertion
            $stmt = $conn->prepare("INSERT INTO `cabins` (`name`, `people`, `price`, `seasonal`) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("siii", $name, $people, $price, $seasonal);
            $result = $stmt->execute();

            if ($result) {
                // Cabin inserted successfully
                return true;
            } else {
                // Error occurred while inserting the cabin
                return false;
            }
        }
    }




    function GetCabins()
    {
        global $hashids;
        $cabins = array();
        $conn = $this->connection->conn;
        $sql = "SELECT * FROM `cabins`";
        $query = $conn->query($sql);
        if ($query && $query->num_rows > 0) {
            while ($result = $query->fetch_assoc()) {
                $result['id'] = $hashids->encode($result['id']);
                array_push($cabins, $result);
            }
        }
        return $cabins;
    }
}
