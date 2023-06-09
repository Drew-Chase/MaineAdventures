<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/php/includes/itemized.inc.php";

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
    <link rel="stylesheet" href="/assets/css/min/quickview.min.css">
    

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
            echo "const id = '$id';";
        }
        ?>
    </script>

    <nav fixed="true" noanim=true>
        <span id="brand">
            <a href="/panel" title="Go Home">
                <img src="/assets/images/icon.svg" alt="Maine Adventures Logo">
                <span class="title"> Admin Panel </span>
            </a>
        </span>
        <div id="nav-items">
            <a href="/panel" class="nav-item" title="Goto Home Page">Home</a>
            <a href="/panel/calendar" class="nav-item" title="Goto Calendar">Calendar</a>
            <div class="nav-item btn primary" id="search-button" title="Search">
                <i class="fa fa-search right"></i>
                Search
            </div>
            <a href="/" class="nav-item btn secondary" title="Goto Booking Page">Main Site</a>
        </div>
    </nav>
    <main>
        <?php
            if($paid)
            {
                echo "<h1>Customer has Been Checked in</h1>";
            }
        ?>
    </main>

    <footer id="footer" class="center col">
        <img id="footer-logo" src="/assets/images/large-logo.svg" alt="">
        <p id="copyright">&copy; Copyright 2011-<span class="year"></span> Allagash Gateway Campsites & Cabins. All rights
            reserved.</p>
    </footer>

    <div class="search-modal center row">
        <div class="search-box center">
            <input type="text" name="search-input" id="search-input" placeholder="Search...">
        </div>
        <div class="search-results col">
        </div>
    </div>

    <!-- Page Scripts -->
    <script src="/assets/js/min/payment.min.js"></script>
    <script src="/assets/js/min/nav.min.js"></script>
    <script src="/assets/js/min/auth.min.js"></script>
    <script src="/assets/js/min/lf.min.js"></script>
    <script src="/assets/js/min/quickview.min.js"></script>
</body>

</html>