<?php

header("Content-Type: application/json");
require_once "connection.inc.php";
require_once "hashids.inc.php";

if (isset($_GET["c"])) {
    $bookings = new Bookings();
    switch ($_GET["c"]) {
        case "create":
            if (
                isset($_POST["name"]) &&
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
                    $_POST["name"],
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
        case "checkin":
            if (isset($_GET['id'])) {
                echo json_encode(["message" => $booking->CheckIn($_GET['id'])]);
            }
            break;
        case "pay":
            if (isset($_GET['id'])) {
                echo json_encode(["message" => $booking->MarkAsPaid($_GET['id'])]);
            }
            break;
        case "arriving":
            echo json_encode($bookings->GetArrivingToday());
            break;
        case "departing":
            echo json_encode($bookings->GetDepartingToday());
            break;
        case "calendar":
            echo json_encode($bookings->GetAllBookingsOrderedByArrival());
            break;
        case "search":
            if (isset($_POST["query"])) {
                echo json_encode($bookings->Search($_POST['query']));
            }
            break;
        case "unavailable":
            if (isset($_GET['cabin'])) {
                die(json_encode($bookings->GetUnavailableDates($_GET['cabin'])));
            }
            break;
        default:
            break;
    }
}

class Bookings
{

    function GetUnavailableDates(string $cabin): array
    {
        $conn = new Connection();
        $connection = $conn->conn;
        $unavailableDates = array();
        
        // Retrieve unavailable dates from the bookings table
        $query = "SELECT arrival, departure FROM bookings WHERE cabin = ? ORDER BY arrival";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $cabin);
        $stmt->execute();
        $result = $stmt->get_result();
        $bookings = $result->fetch_all(MYSQLI_ASSOC);
        
        // Process each booking to find unavailable dates
        foreach ($bookings as $booking) {
            $arrival = new DateTime($booking['arrival']);
            $departure = new DateTime($booking['departure']);
            
            // Add each date within the span to the unavailable dates array
            $currentDate = clone $arrival;
            $currentDate->modify('-1 day');
            $departure->modify('+1 day');
            while ($currentDate <= $departure) {
                $unavailableDates[] = $currentDate->format('Y-m-d');
                $currentDate->modify('+1 day');
            }
        }

        $stmt->close();

        return $unavailableDates;
    }


    function CheckIn(string $id)
    {
        $connection = new Connection();
        $conn = $connection->conn; // This is the mysqli connection object

        global $hashids;
        $decodedId = $hashids->decode($id)[0];

        // SQL query to update the 'processed' column
        $sql = "UPDATE bookings SET processed = 1 WHERE id = '$decodedId' LIMIT 1";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo "Check-in successful for customer with ID: $id";
        } else {
            echo "Error updating check-in status: " . $conn->error;
        }
    }
    function MarkAsPaid(string $id)
    {
        $connection = new Connection();
        $conn = $connection->conn; // This is the mysqli connection object

        global $hashids;
        $decodedId = $hashids->decode($id)[0];

        // SQL query to update the 'processed' column
        $sql = "UPDATE bookings SET paid = 1 WHERE id = '$decodedId' LIMIT 1";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo "Successfully processed payment for ID: $id";
        } else {
            echo "Error updating payment status: " . $conn->error;
        }
    }

    function GetAllBookingsOrderedByArrival(): array
    {
        $connection = new Connection();
        $conn = $connection->conn; // This is the mysqli connection object

        // SQL query to retrieve all bookings ordered by arrival date
        $sql = "SELECT * FROM bookings ORDER BY arrival ASC";

        // Execute the query
        $result = $conn->query($sql);

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            $rows = array();
            global $hashids;
            // Iterate through each row
            while ($row = $result->fetch_assoc()) {
                // Add each row to the array
                $row['id'] = $hashids->encode($row['id']);
                $rows[] = $row;
            }
            // Return the rows as JSON
            return $rows;
        } else {
            return ["message" => "No bookings found."];
        }
    }

    function GetArrivingToday(): array
    {
        $connection = new Connection();
        $conn = $connection->conn; // This is the mysqli connection object
        // Get the current date
        $currentDate = date('Y-m-d');

        // SQL query to retrieve customers arriving today
        $sql = "SELECT * FROM bookings WHERE DATE(arrival) = '$currentDate'";

        // Execute the query
        $result = $conn->query($sql);

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            $rows = array();
            global $hashids;
            // Iterate through each row
            while ($row = $result->fetch_assoc()) {
                // Add each row to the array
                $row['id'] = $hashids->encode($row['id']);
                $rows[] = $row;
            }
            // Return the rows as JSON
            return $rows;
        } else {
            return ["message" => "No customers arriving today."];
        }
    }

    function GetDepartingToday(): array
    {
        $connection = new Connection();
        $conn = $connection->conn; // This is the mysqli connection object
        // Get the current date
        $currentDate = date('Y-m-d');

        // SQL query to retrieve customers departing today
        $sql = "SELECT * FROM bookings WHERE DATE(departure) = '$currentDate'";

        // Execute the query
        $result = $conn->query($sql);

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            $rows = array();
            global $hashids;
            // Iterate through each row
            while ($row = $result->fetch_assoc()) {
                // Add each row to the array
                $row['id'] = $hashids->encode($row['id']);
                $rows[] = $row;
            }
            // Return the rows as JSON
            return $rows;
        } else {
            return ["message" => "No customers departing today."];
        }
    }

    function Search($query): array
    {
        if ($query == "") {
            return [];
        }
        $connection = new Connection();
        $sql = "SELECT *
        FROM `bookings`
        WHERE 
            (SOUNDEX(name) = SOUNDEX('$query')
            OR name LIKE '%$query%')
            OR (SOUNDEX(email) = SOUNDEX('$query')
            OR email LIKE '%$query%')
            OR (SOUNDEX(phone) = SOUNDEX('$query')
            OR phone LIKE '%$query%');
        ";
        $result = $connection->conn->query($sql);

        if (!$result) {
            echo "Error executing query: " . $connection->conn->error;
            exit();
        }

        $rows = [];
        global $hashids;
        while ($row = $result->fetch_assoc()) {
            $row['id'] = $hashids->encode($row['id']);
            $rows[] = $row;
        }

        $result->free();

        return $rows;
    }

    function Create($name, $email, $phone, $adults, $children, $pets, $cabin, $arrival, $departure, $seasonal, $credits)
    {
        $connection = new Connection();
        $sql = "INSERT INTO `bookings`( `name`, `email`, `phone`, `adults`, `children`, `pets`, `cabin`, `arrival`, `departure`, `seasonal`, `credits`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $connection->conn->prepare($sql);
        if (!$stmt) {
            http_response_code(500);
            die(json_encode(array("error" => "Unable to prepare SQL Statement")));
        }
        $stmt->bind_param("sssssssssss", $name, $email, $phone, $adults, $children, $pets, $cabin, $arrival, $departure, $seasonal, $credits);
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
