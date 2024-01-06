<!-- A LFInteractive Project -->
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/php/includes/gallery-images.inc.php"
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gallery - Main Adventures</title>
	<link rel="shortcut icon" href="/assets/images/icon.svg" type="image/x-icon">

	<!-- Pages Styling -->
	<link rel="stylesheet" href="/assets/css/min/main.min.css">
	<link rel="stylesheet" href="/assets/css/min/social-media.min.css">
	<link rel="stylesheet" href="/assets/css/min/links.min.css">
	<link rel="stylesheet" href="/assets/css/min/nav.min.css">
	<link rel="stylesheet" href="/assets/css/min/scrollbar.min.css">
	<link rel="stylesheet" href="/assets/css/min/home.min.css">
	<link rel="stylesheet" href="/assets/css/min/footer.min.css">
	<link rel="stylesheet" href="/assets/css/min/services.min.css">
	<link rel="stylesheet" href="/assets/css/min/gallery.min.css">


	<!-- Responsive Styling -->
	<link rel="stylesheet" href="/assets/css/min/responsive.min.css">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="/assets/libraries/fontawesome/css/all.min.css">
	<!-- JQuery -->
	<script src="/assets/libraries/jquery.js"></script>
</head>

<body id="gallery">
	<?php
	$page = 2;
	$noanim = true;
	include_once $_SERVER["DOCUMENT_ROOT"] . "/assets/php/nav.php";
	?>

	<section>
		<h1>Gallery</h1>
		<div id="gallery" class="grid">
			<?php
			foreach (GetGalleryImages() as $image) {
				echo '
				<div class="gallery-image" style="background-image: url(\'/assets/images/gallery/sm/' . $image . '\')">
				<p class="title">' . basename($image, '.' . pathinfo($image, PATHINFO_EXTENSION)) . '</p>
					<img src="/assets/images/gallery/' . $image . '" alt="" loading="lazy">
					</div>';
			}
			?>
		</div>
	</section>

	<footer id="footer" class="center col">
		<img id="footer-logo" src="/assets/images/large-logo.svg" alt="">
		<a href="https://www.facebook.com/allagashgateway/" target="_blank">
			<i class="fa fa-brands fa-facebook-f social-icon center" title="Check us out on Facebook"></i>
		</a>
		<p id="copyright">&copy; Copyright 2011-2023 Allagash Gateway Campsites & Cabins. All rights reserved.</p>
	</footer>

	<!-- JS Scripts -->
	<script src="/assets/js/min/nav.min.js"></script>
	<script src="/assets/js/min/gallery.min.js"></script>

</body>

</html>