<!-- A LFInteractive Project -->

<?php
header("location: /booking/coming-soon.php")
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Booking - Main Adventures</title>
	<link rel="shortcut icon" href="/assets/images/icon.svg" type="image/x-icon">

	<!-- Pages Styling -->
	<link rel="stylesheet" href="/assets/css/min/main.min.css">
	<link rel="stylesheet" href="/assets/css/min/social-media.min.css">
	<link rel="stylesheet" href="/assets/css/min/inputs.min.css">
	<link rel="stylesheet" href="/assets/css/min/links.min.css">
	<link rel="stylesheet" href="/assets/css/min/nav.min.css">
	<link rel="stylesheet" href="/assets/css/min/scrollbar.min.css">
	<link rel="stylesheet" href="/assets/css/min/booking.min.css">
	<link rel="stylesheet" href="/assets/css/min/footer.min.css">
	<link rel="stylesheet" href="/assets/css/min/calendar.min.css">

	<!-- Responsive Styling -->
	<link rel="stylesheet" href="/assets/css/min/responsive.min.css">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="/assets/libraries/fontawesome/css/all.min.css">
	<!-- JQuery -->
	<script src="/assets/libraries/jquery.js"></script>
</head>

<body>

	<?php
	$static = true;
	include_once $_SERVER["DOCUMENT_ROOT"] . "/assets/php/nav.php";
	?>
	<div id="landing" class="center col booking-landing">
		<h1>Booking</h1>
	</div>
	<div id="sections">
		<section id="time-span" class="row center footless" next="cabin">
			<div id="timespan-information" class="col">
				<h2>Stay Options</h2>
				<p>
					We offer two ways to camp.
				</p>
				<p>
					<strong>1. Nightly: </strong>
					This is the most common option. Nightly is where you pay for every night individually, typically $40-$60
					per night!
				</p>
				<p>
					<strong>2. Seasonal: </strong>
					This is for the person that really needs a summer getaway! A typical season goes from the first week of
					May <i>(or when the roads allow)</i> to the third week of November.
					<br> Included in the seasonal option is permission to hunt on our private property. <i>(call for more
						details)</i>
				</p>
				<p>
					<strong>Utility Notice:</strong> Power and Water are only available from 7-9 A.M. and 5-9 P.M.
				</p>
				<p>
					Cabins include a heater, four cook top burners, a refrigerator and lights. Heater and burners are
					powered by propane. All the cabins have cookware, dishes, utensils, and bedding. Privy's are close by
					and showers are available from 5 P.M. to 7:30 P.M. for $4.00 per person at the main lodge.
				</p>
				<p>
					We now offer winter showers as well!<br>
					Water is portaged to you daily from our water-well.
				</p>
				<p>
					<strong><u>Please select one of the two options on your right to continue!</u></strong>
				</p>
			</div>
			<div id="buttons" class="row center">
				<div class="card center col" id="daily">
					<p class="name">Nightly</p>
					<p class="description">With this option you'll be paying for every night individually, usually between
						$40 - $60 a night
					</p>
					<div class="btn">Select</div>
				</div>

				<div class="card center col" id="seasonal">
					<p class="name">Seasonal</p>
					<p class="description">With this option you will be paying for the entire season, usually between $1,000
						- $4,000</p>
					<div class="btn">Select</div>
				</div>
			</div>
		</section>

		<section id="cabin" class="col" next="start-time" style="display: none;" previous="time-span">
			<h2>Cabin</h2>
			<p>We have 4 small cabins that house up to 5 people and 1 large cabin that can house up to 10+ people.</p>
			<div class="row">
				<div id="cabin-names" class="col">
				</div>
				<div id="cabin-image" alt=""></div>
			</div>

		</section>

		<section id="start-time" class="col" style="display:none" next="end-time" previous="cabin">
			<h2>Arrival Date?</h2>
			<p>We need at least <strong>5 days</strong> notice before booking</p>
			<div id="calendar-start" date="2023-06-21"></div>
		</section>

		<section id="end-time" class="col" style="display:none" next="adults" previous="start-time">
			<h2>Departure Date?</h2>
			<p>We need at least <strong>5 days</strong> notice before booking</p>
			<div id="calendar-end"></div>
		</section>

		<section id="adults" style="display: none;" next="children" previous="end-time">
			<h2>Adults</h2>
			<p>Adults are <b>$15.00</b> per person per night</p>
			<div class="items">
				<span class="count">1</span>
				<span class="count">2</span>
				<span class="count">3</span>
				<span class="count">4</span>
				<span class="count">5</span>
				<span class="count">6</span>
			</div>
		</section>

		<section id="children" style="display: none;" next="pets" previous="adults">
			<h2>Children</h2>
			<p>Children under the age of 5 are free, others are <b>$10.00</b> per person per night</p>
			<div class="items">
				<span class="count">0</span>
				<span class="count">1</span>
				<span class="count">2</span>
				<span class="count">3</span>
				<span class="count">4</span>
				<span class="count">5</span>
				<span class="count">6</span>
			</div>
		</section>

		<section id="pets" style="display: none;" next="contact-information" previous="children">
			<h2>Pets</h2>
			<p>Pets are <b>$10.00</b> per pet per night</p>
			<div class="items">
				<span class="count">0</span>
				<span class="count">1</span>
				<span class="count">2</span>
				<span class="count">3</span>
				<span class="count">4</span>
				<span class="count">5</span>
				<span class="count">6</span>
			</div>
		</section>

		<section id="contact-information" style="display: none;" next="payment-method" previous="pets">
			<h2>Your Information</h2>
			<div class="center">
				<div class="col">
					<label for="name">Full Name</label>
					<input type="text" name="name" id="name" placeholder="John M. Smith" autocomplete="name">

					<label for="email">Email</label>
					<input type="email" name="email" id="email" placeholder="email@example.com" autocomplete="email">
					<label for="telephone-number">Phone Number</label>
					<input type="tel" name="telephone-number" id="telephone-number" placeholder="(123) 456-7890" autocomplete="mobile">
				</div>
			</div>
		</section>

		<section id="payment-method" class="row center" style="display: none;" previous="contact-information">
			<div id="payment-information" class="col">
				<h2>How to Pay</h2>
				<p>
					We accept many forms of payment. How ever you choose to pay, we can help accommodate. We want you to
					spend less time worrying about city problems, and start enjoying the great outdoors as soon as possible!
				</p>
				<p>We offer two ways to pay</p>
				<p><strong>1. In Person: </strong>You will make your payment when you check in.</p>
				<p><strong>2. Online: </strong>This is the easiest method, while booking your trip you will prepay for your
					time.
					Please select one of the two options on your right to continue!</p>
				<div id="cards" class="row">
					<i class="fa fa-brands fa-cc-visa"></i>
					<i class="fa fa-brands fa-cc-mastercard"></i>
					<i class="fa fa-brands fa-cc-discover"></i>
					<i class="fa fa-brands fa-cc-amex"></i>
					<i class="fa fa-brands fa-cc-stripe"></i>
					<i class="fa fa-brands fa-cc-apple-pay"></i>
				</div>
			</div>
			<div id="buttons" class="row center">
				<div class="card center col" id="inperson-payment-card">
					<p class="name">In Person</p>
					<p class="description">We'll take your payment as soon as you get here</p>
					<div class="btn">Select</div>
				</div>
				<div class="card center col" id="online-payment-card">
					<p class="name">Online</p>
					<p class="description">Quick and Easy</p>
					<div class="btn">Select</div>
				</div>
			</div>
		</section>

	</div>
	<div id="section-navigation" class="row center no-select" style="opacity: 0;">
		<div id="previous" class="section-nav-item row" disabled><i class="fa fa-chevron-left"></i> Prev.</div>
		<div id="next" class="section-nav-item row">Next <i class="fa fa-chevron-right"></i></div>
	</div>


	<section id="itemized" class="col" style="display: none;">
		<div id="itemized-content"></div>
		<div class="row center">
			<div class="btn primary" id="submit-booking-btn">Continue</div>
			<div class="btn dark" id="cancel-booking-btn">Change</div>
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

	<script src="/assets/js/min/calendar.min.js"></script>
	<script src="/assets/js/min/nav.min.js"></script>


	<script src="/assets/js/min/booking-utility.min.js"></script>
	<script src="/assets/js/min/booking-navigation.min.js"></script>
	<script src="/assets/js/min/booking-events.min.js"></script>
	<script src="/assets/js/min/booking-count.min.js"></script>
	<script src="/assets/js/min/booking-cabins.min.js"></script>
	<script src="/assets/js/min/booking-time-selectors.min.js"></script>
	<script src="/assets/js/min/booking.min.js"></script>
	<script src="https://lfinteractive.net/assets/js/min/lf.min.js"></script>

	<!-- Facebook SDK -->
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
</body>

</html>