<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/php/includes/itemized.inc.php";
?>


<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
			<?php 
			if(!isset($_GET['print'])){
				echo '<h2>Your Order</h2>';
				echo '<style>
				#itemized{
					padding: 0;
					margin: 0;
				}
				</style>';
			}
			?>
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
					<td id="itemized-adults-price"><?php echo "$" . number_format($adults * $pricePerAdult, 0); ?>/night
					</td>
					<td id="itemized-adults-price-per"><?php echo "$" . number_format($pricePerAdult, 0); ?></td>
				</tr>
				<tr>
					<td id="itemized-children-name">Children</td>
					<td id="itemized-children-count"><?php echo $children; ?></td>
					<td id="itemized-children-price"><?php echo "$" . number_format($children * $pricePerChild, 0); ?>
						/night
					</td>
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
					<td id="itemized-arrival-time">8:00 AM</td>
				</tr>
				<tr>
					<td>Departure</td>
					<td id="itemized-departure-date"><?php echo date_format($departure, "D, F jS, Y"); ?></td>
					<td id="itemized-departure-time">6:00 PM</td>
				</tr>
			</table>
			<hr>
			<?php
			if ($paid) {
				echo "
                <div id=\"itemized-paid\">
                    <p><strong>Paid with Card ending in <span id=\"card-suffix\"></span></strong></p>
                </div>";
			}
			?>
			<div class="row">
				<p id="balance-line">Total Balance: <strong id="total-balance"><?php echo "$" . number_format($price, 2); ?></strong>
				</p>
				<?php
				if (isset($_GET['id'])) {
					if (isset($_GET['show-pay'])) {
						echo '<a href="/booking/pay.php?id=' . $_GET['id'] . '" class="btn primary" style="width: 200px;margin: auto 1rem;margin-left: auto;">Pay</a>';
					} else if (isset($_GET['show-print'])) {
						echo '<a class="btn primary" style="width: 200px;margin: auto 1rem;margin-left: auto;" onclick="Print(\'' . $_GET["id"] . '\')">Print</a>';
						echo '<script src="/assets/js/min/payment.min.js"></script>';
					}
				}

				?>

			</div>
		</section>
	</div>
</body>

</html>