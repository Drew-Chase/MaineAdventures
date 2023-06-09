<!-- A LFInteractive Project -->
<?php
define("SERVER_ROOT", __DIR__);
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Main Adventures - Ditch the city for a taste of nature</title>
	<link rel="shortcut icon" href="/assets/images/icon.svg" type="image/x-icon">

	<!-- Pages Styling -->
	<link rel="stylesheet" href="/assets/css/min/main.min.css">
	<link rel="stylesheet" href="/assets/css/min/social-media.min.css">
	<link rel="stylesheet" href="/assets/css/min/links.min.css">
	<link rel="stylesheet" href="/assets/css/min/nav.min.css">
	<link rel="stylesheet" href="/assets/css/min/scrollbar.min.css">
	<link rel="stylesheet" href="/assets/css/min/home.min.css">
	<link rel="stylesheet" href="/assets/css/min/footer.min.css">

	<!-- Responsive Styling -->
	<link rel="stylesheet" href="/assets/css/min/responsive.min.css">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="/assets/libraries/fontawesome/css/all.min.css">
	<!-- JQuery -->
	<script src="/assets/libraries/jquery.js"></script>
</head>

<body>
	<?php
	$page = 0;
	include_once $_SERVER["DOCUMENT_ROOT"] . "/assets/php/nav.php";
	?>

	<div id="landing" class="center col">
		<img src="/assets/images/large-logo.svg" alt="">
		<div id="landing-buttons">
			<a href="/booking" class="btn primary">Schedule Trip</a>
			<a href="/gallery" class="btn secondary">Gallery</a>
		</div>
	</div>
	<section id="about-us" class="col">
		<h2>About US</h2>
		<div class="row">
			<div class="col">
				<p class="1">
					<b>Howdy Campers!</b><br><br>
					We thought we would take a moment to introduce ourselves to those who do not know us yet. We are into
					our 6th year as owners of Allagash Gateway Campground and Cabins.<br><br>

					We are the Scanlins, Steve, BeLinda, Kayte, Keenan and Maddi Mae. We left the "city" behind, as an
					independent contractor and a nurse, to grow a new life in the great outdoors.<br><br>

					We hope to provide an experience that will give families lasting memories of camping, <b>hunting</b>,
					<b>hiking</b>, <b>waterway</b>, <b>snow activities</b>, and so much more of enjoying all that Maine has
					to offer.<br><br>

					If you have an idea of what you might like to do, please let us know and we will do our best to prepare
					an experience to your expectations.<br><br><br>


					<b>SO LET THE CAMPFIRES BEGIN!!!</b>
				</p>
				<a href="/booking" class="btn primary">Lets Go!</a>
			</div>
			<img src="/assets/images/campfire.webp" alt="">
		</div>
	</section>

	<section id="hunt-banner" class="col center">
		<h4>Hunting?</h4>
		<h2>Looking to Hunt</h2>
		<p class="1">Check out our premium hunting experience with Black Hat Hunting </p>
		<div id="hunting-banner-buttons" class="row center">
			<a href="http://blackhathunting.com/" class="btn primary">Schedule Trip</a>
			<a href="http://blackhathunting.com/" class="btn secondary">Learn More...</a>
		</div>
	</section>

	<section id="share-page-cta" class="col center">
		<h3>Share this Page!</h3>
		<div class="row">
			<i class="fa fa-brands fa-facebook-f social-icon center" title="Share on Facebook" onclick="Share('facebook')"></i>
			<i class="fa fa-brands fa-twitter social-icon center" title="Share on Twitter" onclick="Share('twitter')"></i>
			<i class="fa fa-solid fa-envelope social-icon center" title="Share with Email" onclick="Share('email')"></i>
		</div>
	</section>

	<section id="contact" class="row">
		<div class="col">
			<div id="phone-card" class="contact-card row" onclick="Call()" title="Call Us">
				<i class="fa-solid fa-phone"></i>
				<div class="col">
					<p class="name">Phone</p>
					<a href="tel:+1 (207) 723-9215" class="value">+1 (207) 723-9215</a>
				</div>
			</div>
			<div id="email-card" class="contact-card row" onclick="Email()" title="Email Us">
				<i class="fa-solid fa-envelope"></i>
				<div class="col">
					<p class="name">Email</p>
					<a href="mailto:contact-us@maineadventures.org?subject=Contact US" class="value">contact-us@maineadventures.org</a>
				</div>
			</div>
		</div>
		<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d5554.9241316447815!2d-69.222342!3d45.882071!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x81e08b7556a8c8e3!2sAllagash%20Gateway!5e0!3m2!1sen!2sus!4v1674368904758!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
	</section>

	<footer id="footer" class="center col">
		<img id="footer-logo" src="/assets/images/large-logo.svg" alt="">
		<a href="https://www.facebook.com/allagashgateway/" target="_blank">
			<i class="fa fa-brands fa-facebook-f social-icon center" title="Check us out on Facebook"></i>
		</a>
		<p id="copyright">&copy; Copyright 2011-2023 Allagash Gateway Campsites & Cabins. All rights reserved.</p>
	</footer>

	<!-- Fixed Items -->
	<div id="page-arrow"><i class="fa-solid fa-chevron-down"></i></div>

	<!-- JS Scripts -->
	<script src="/assets/js/min/contact-us.min.js"></script>
	<script src="/assets/js/min/social-media.min.js"></script>
	<script src="/assets/js/min/nav.min.js"></script>

</body>

</html>