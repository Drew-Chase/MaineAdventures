<!-- A LFInteractive Project -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Coming Soon - Main Adventures</title>
    <link rel="shortcut icon" href="/assets/images/icon.svg" type="image/x-icon">

    <!-- Pages Styling -->
    <link rel="stylesheet" href="/assets/css/min/main.min.css">
    <link rel="stylesheet" href="/assets/css/min/social-media.min.css">
    <link rel="stylesheet" href="/assets/css/min/links.min.css">
    <link rel="stylesheet" href="/assets/css/min/nav.min.css">
    <link rel="stylesheet" href="/assets/css/min/scrollbar.min.css">
    <link rel="stylesheet" href="/assets/css/min/home.min.css">
    <link rel="stylesheet" href="/assets/css/min/footer.min.css">
    <link rel="stylesheet" href="/assets/css/min/order-complete.min.css">

    <style>
        @media (max-width: 1044px) {
            #order-complete-landing h1 {
                font-size: 4rem;
            }

            #order-complete-landing h3 {
                font-size: 2rem;
            }
        }

        @media (max-width: 484px) {
            #order-complete-landing h1 {
                font-size: 2rem;
            }

            #order-complete-landing h3 {
                font-size: 1.5rem;
                font-weight: 400;
            }

            #order-complete-landing p {
                width: 80%;
            }
        }
    </style>


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
        <h1>Coming Soon!</h1>
        <h3>Online booking is not yet available!</h3>
        <p>Please feel free to schedule bookings via <a href="javascript:void();" onclick="Phone()">phone</a> or <a href="javascript:void();" onclick="Book()">email</a>.</p>
    </div>
    <section id="contact" class="row">
		<div class="col">
			<div id="phone-card" class="contact-card row" onclick="Call()" title="Call Us">
				<i class="fa-solid fa-phone"></i>
				<div class="col">
					<p class="name">Book via Phone</p>
					<a href="javascript:void();" class="value">+1 (207) 723-9215</a>
				</div>
			</div>
			<div id="email-card" class="contact-card row" onclick="Book()" title="Email Us">
				<i class="fa-solid fa-envelope"></i>
				<div class="col">
					<p class="name">Book via Email</p>
					<a href="javascript:void();" class="value">bscanlin1@yahoo.com</a>
				</div>
			</div>
		</div>
		<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d5554.9241316447815!2d-69.222342!3d45.882071!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x81e08b7556a8c8e3!2sAllagash%20Gateway!5e0!3m2!1sen!2sus!4v1674368904758!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
	</section>
	<script src="/assets/js/min/contact-us.min.js"></script>
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