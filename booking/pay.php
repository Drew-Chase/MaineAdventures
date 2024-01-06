<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/php/includes/itemized.inc.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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

	<?php
	$fixed = true;
	$noanim = true;
	include_once $_SERVER["DOCUMENT_ROOT"] . "/assets/php/nav.php";
	?>
	<main>
		<?php
		include_once $_SERVER["DOCUMENT_ROOT"] . "/assets/php/payment-form.php";
		?>
	</main>

	<footer id="footer" class="center col">
		<img id="footer-logo" src="/assets/images/large-logo.svg" alt="">
		<p id="copyright">&copy; Copyright 2011-<span class="year"></span> Allagash Gateway Campsites & Cabins. All rights reserved.</p>
	</footer>

	<!-- Page Scripts -->
	<script src="/assets/js/min/nav.min.js"></script>
</body>

</html>