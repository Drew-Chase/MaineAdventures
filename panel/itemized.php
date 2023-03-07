<?php
require_once realpath(getcwd() . "/../assets/php/itemized.inc.php");
?>


<html>

<head>
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
            <h2>Your Order</h2>
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
                    <td id="itemized-adults-price"><?php echo "$" . number_format($adults * $pricePerAdult, 0); ?>/night</td>
                    <td id="itemized-adults-price-per"><?php echo "$" . number_format($pricePerAdult, 0); ?></td>
                </tr>
                <tr>
                    <td id="itemized-children-name">Children</td>
                    <td id="itemized-children-count"><?php echo $children; ?></td>
                    <td id="itemized-children-price"><?php echo "$" . number_format($children * $pricePerChild, 0); ?>/night</td>
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
                    <td id="itemized-arrival-time"><?php echo date_format($arrival, "g:i A"); ?></td>
                </tr>
                <tr>
                    <td>Departure</td>
                    <td id="itemized-departure-date"><?php echo date_format($departure, "D, F jS, Y"); ?></td>
                    <td id="itemized-departure-time"><?php echo date_format($departure, "g:i A"); ?></td>
                </tr>
            </table>
            <hr>
            <?php
            if ($paid) {
                echo "
                <div id=\"itemized-paid\">
                    <p><strong>Paid with Visa ending in <span id=\"card-suffix\"></span></strong></p>
                </div>";
            }
            ?>
            <p id="balance-line">Total Balance: <strong id="total-balance"><?php echo "$ " . number_format($price, 2); ?></strong>
            </p>
        </section>
    </div>
</body>

</html>