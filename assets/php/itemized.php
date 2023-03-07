<?php
require_once "connection.inc.php";
$fname = "";
$lname = "";
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

$connection = new Connection();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
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
            $fname = $data["fname"];
            $lname = $data["lname"];
            $adults = $data["adults"];
            $children = $data["children"];
            $pets = $data["pets"];
            $cabin = $data["cabin"];
            $price = $data["price"];
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

    $adults =  $_POST["adults"];
    $children =  $_POST["children"];
    $pets =  $_POST["pets"];
    $cabin =  $_POST["cabin"];
    $price =  $_POST["seasonal"];
    $arrival =  $_POST["arrival"];
    $departure =  $_POST["departure"];
    $nights = round((strtotime($departure) - strtotime($arrival)) / (24 * 60 * 60));
    $arrival = date_create($arrival);
    $departure = date_create($departure);
} else {
    echo $_POST["adults"];
    echo $_POST["children"];
    echo $_POST["pets"];
    echo  $_POST["cabin"];
    echo  $_POST["seasonal"];
    echo  $_POST["arrival"];
    echo  $_POST["departure"];
    die;
}


$sql = "SELECT * FROM `cabins` WHERE `id`=? LIMIT 1;";
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
                $pricePerAdult =  $data["price"];
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

?>


<html>

<head>
    <link rel="stylesheet" href="/assets/css/min/main.min.css">
    <link rel="stylesheet" href="/assets/css/min/social-media.min.css">
    <link rel="stylesheet" href="/assets/css/min/inputs.min.css">
    <link rel="stylesheet" href="/assets/css/min/links.min.css">
    <link rel="stylesheet" href="/assets/css/min/nav.min.css">
    <link rel="stylesheet" href="/assets/css/min/scrollbar.min.css">
    <link rel="stylesheet" href="/assets/css/min/booking.min.css">
    <link rel="stylesheet" href="/assets/css/min/footer.min.css">
</head>

<body>
    <div id="itemized">
        <section id="itemized">
            <h2>Your Order</h2>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Price per Night</th>
                </tr>
                <tr>
                    <td id="itemized-cabin-name"><?php echo $cabin; ?></td>
                    <td id="itemized-nights"><?php echo $nights; ?> Nights</td>
                    <td id="itemized-cabin-price"><?php echo "$" . number_format($nights * $pricePerNight, 0); ?></td>
                    <td id="itemized-cabin-price-per"><?php echo "$" . number_format($pricePerNight, 0); ?></td>
                </tr>
                <tr>
                    <td id="itemized-adults-name">Adults</td>
                    <td id="itemized-adults-count"><?php echo $adults; ?></td>
                    <td id="itemized-adults-price"><?php echo "$" . number_format($adults * $pricePerAdult, 0); ?>/night</td>
                    <td id="itemized-adults-price-per"><?php echo "$" . number_format($pricePerAdult, 0); ?></td>
                </tr>
                <tr>
                    <td id="itemized-children-name">Children</td>
                    <td id="itemized-children-count"><?php echo $children; ?></td>
                    <td id="itemized-children-price"><?php echo "$" . number_format($children * $pricePerChild, 0); ?>/night</td>
                    <td id="itemized-children-price-per"><?php echo "$" . number_format($pricePerChild, 0); ?></td>
                </tr>
                <tr>
                    <td id="itemized-pets-name">Pets</td>
                    <td id="itemized-pets-count"><?php echo $pets; ?></td>
                    <td id="itemized-pets-price"><?php echo "$" . number_format($pets * $pricePerPet, 0); ?>/night</td>
                    <td id="itemized-pets-price-per"><?php echo "$" . number_format($pricePerPet, 0); ?></td>
                </tr>
            </table>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
                <tr>
                    <td>Arrival</td>
                    <td id="itemized-arrival-date"><?php echo date_format($arrival, "D, F jS, Y"); ?></td>
                    <td id="itemized-arrival-time"><?php echo date_format($arrival, "g:i A"); ?></td>
                </tr>
                <tr>
                    <td>Departure</td>
                    <td id="itemized-departure-date"><?php echo date_format($departure, "D, F jS, Y"); ?></td>
                    <td id="itemized-departure-time"><?php echo date_format($departure, "g:i A"); ?></td>
                </tr>
            </table>
            <hr>
            <?php
            if ($paid) {
                echo "
                <div id=\"itemized-paid\">
                    <p><strong>Paid with Visa ending in <span id=\"card-suffix\"></span></strong></p>
                </div>";
            }
            ?>
            <p id="balance-line">Total Balance: <strong id="total-balance"><?php echo "$ " . number_format($price, 2); ?></strong>
            </p>
        </section>
    </div>
</body>

</html>