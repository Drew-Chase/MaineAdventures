<?php
require_once realpath(getcwd() . "/../assets/php/connection.inc.php");
$price = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $connection = new Connection();
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
            $price = $data["price"];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Maine Adventures</title>

    <link rel="shortcut icon" href="/assets/images/icon.svg" type="image/x-icon">

    <!-- Pages Styling -->
    <link rel="stylesheet" href="/assets/css/min/main.min.css">
    <link rel="stylesheet" href="/assets/css/min/nav.min.css">
    <link rel="stylesheet" href="/assets/css/min/links.min.css">
    <link rel="stylesheet" href="/assets/css/min/scrollbar.min.css">
    <link rel="stylesheet" href="/assets/css/min/footer.min.css">
    <link rel="stylesheet" href="/assets/css/min/inputs.min.css">
    <link rel="stylesheet" href="/assets/css/min/panel.min.css">

    <!-- Responsive Styling -->
    <link rel="stylesheet" href="/assets/css/min/responsive.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/libraries/fontawesome/css/all.min.css">
    <!-- JQuery -->
    <script src="/assets/libraries/jquery.js"></script>
</head>

<body>
    <script>
        <?php
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            echo "const id = $id;";
        }
        ?>
    </script>

    <nav fixed=true static>
        <span id="brand">
            <a href="/" title="Go Home">
                <img src="/assets/images/icon.svg" alt="Maine Adventures Logo">
                <span class="title"> Maine Adventures </span>
            </a>
        </span>
        <div id="nav-items">
            <a href="/" class="nav-item" title="Goto Home Page">Home</a>
            <a href="/services" class="nav-item" title="Goto Services Page">Services</a>
            <a href="/booking" class="nav-item btn primary" title="Goto Booking Page">Schedule Trip</a>
        </div>
    </nav>
    <main>
        <div id="payment-form" class="form col">
            <header class="col">
                <h1>Payment</h1>
            </header>
            <div class="col">
                <input type="text" name="fullname" id="fullname" placeholder="Full Name" autocomplete="cc-name">
                <input type="text" name="ccnumber" id="ccnumber" placeholder="Card Number" autocomplete="cc-number">
                <div class="row">
                    <input type="text" name="cvv2" id="cvv2" placeholder="CVV2" autocomplete="cc-csc">
                    <input type="text" name="exp" id="exp" placeholder="01/28" autocomplete="cc-exp">
                </div>
                <h4>Balance: <span class="balance"><?php echo "$" . number_format($price, 2) ?></span></h4>
                <p class="error" style="opacity: 0;">Unknown error has occurred!</p>
                <div class="row center">
                    <div class="btn primary" id="pay-btn">Pay</div>
                    <div class="btn dark" onclick="Print(<?php echo $id; ?>)">Print Recept</div>
                </div>
            </div>
        </div>
    </main>

    <footer id="footer" class="center col">
        <img id="footer-logo" src="/assets/images/large-logo.svg" alt="">
        <p id="copyright">&copy; Copyright 2011-2023 Allagash Gateway Campsites & Cabins. All rights reserved.</p>
    </footer>

    <!-- Page Scripts -->
    <script src="/assets/js/min/payment.min.js"></script>
    <script src="/assets/js/min/lf.min.js"></script>
</body>

</html>