<!-- A LFInteractive Project -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Complete - Main Adventures</title>
    <link rel="shortcut icon" href="/assets/images/icon.svg" type="image/x-icon">

    <!-- Pages Styling -->
    <link rel="stylesheet" href="/assets/css/min/main.min.css">
    <link rel="stylesheet" href="/assets/css/min/links.min.css">
    <link rel="stylesheet" href="/assets/css/min/nav.min.css">
    <link rel="stylesheet" href="/assets/css/min/scrollbar.min.css">
    <link rel="stylesheet" href="/assets/css/min/footer.min.css">
    <link rel="stylesheet" href="/assets/css/min/order-complete.min.css">


    <!-- Responsive Styling -->
    <link rel="stylesheet" href="/assets/css/min/responsive.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/libraries/fontawesome/css/all.min.css">
    <!-- JQuery -->
    <script src="/assets/libraries/jquery.js"></script>
</head>

<body>
    <?php
    include_once $_SERVER["DOCUMENT_ROOT"] . "/assets/php/nav.php";
    ?>
    <div id="order-complete-landing" class="col center">
        <h1>Thank You!</h1>
        <h3>Your adventure has been booked!</h3>
        <p>If you have any questions please feel free to contact us via our <a href="/#contact">contact page</a></p>
    </div>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/panel/itemized.php"; ?>

    <footer id="footer" class="center col">
        <img id="footer-logo" src="/assets/images/large-logo.svg" alt="">
        <a href="https://www.facebook.com/allagashgateway/" target="_blank">
            <i class="fa fa-brands fa-facebook-f social-icon center" title="Check us out on Facebook"></i>
        </a>
        <p id="copyright">&copy; Copyright 2011-2023 Allagash Gateway Campsites & Cabins. All rights reserved.</p>
    </footer>

    <!-- JS Scripts -->
    <script src="/assets/js/min/nav.min.js"></script>

</body>

</html>