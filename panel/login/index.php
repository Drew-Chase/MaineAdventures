<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login - Maine Adventures</title>

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

    <?php
    $page = 1;
    $noanim = true;
    include_once $_SERVER["DOCUMENT_ROOT"] . "/assets/php/nav.php";
    ?>
    <div id="login-form" class="col form">
        <header class="col">
            <h1>Staff Login</h1>
            <p>If you're not sure what this is, your in the wrong place</p>
        </header>
        <input type="text" name="username" id="username" placeholder="Username" autocomplete="username" required>
        <input type="password" name="password" id="password" placeholder="Password" autocomplete="current-password" required>
        <p class="error" style="display:none">Unknown error has occurred!</p>
        <toggle class="password">
            <option value="show-password">Show Password</option>
            <option value="hide-password" selected>Hide Password</option>
        </toggle>

        <div id="button-panel" class="row center">
            <div class="btn">Login</div>
            <a href="/panel/register" class="btn secondary dark">Register</a>
        </div>
    </div>

    <footer id="footer" class="center col">
        <img id="footer-logo" src="/assets/images/large-logo.svg" alt="">
        <p id="copyright">&copy; Copyright 2011-2023 Allagash Gateway Campsites & Cabins. All rights reserved.</p>
    </footer>

    <!-- Page Scripts -->
    <script src="/assets/js/min/nav.min.js"></script>
    <script src="/assets/js/auth.js"></script>
    <!-- <script src="/assets/js/min/auth.min.js"></script> -->
    <script src="/assets/js/min/lf.min.js"></script>
    <script src="/assets/js/min/input.min.js"></script>
</body>

</html>