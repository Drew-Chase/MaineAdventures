<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/php/includes/itemized.inc.php";
?>

<script>
    <?php
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        echo "const id = '$id';";
    }
    ?>
</script>
<div id="payment-form" class="form col">
    <header class="col">
        <h1>Payment</h1>
    </header>
    <div class="col">
        <input type="text" name="fullname" id="fullname" placeholder="Full Name" autocomplete="cc-name">
        <input type="text" name="ccnumber" id="ccnumber" placeholder="Card Number" autocomplete="cc-number">
        <div id="cvdate" class="row">
            <input type="text" name="cvv2" id="cvv2" placeholder="CVV2" autocomplete="cc-csc">
            <input type="text" name="exp" id="exp" placeholder="01/28" autocomplete="cc-exp">
        </div>
        <h4>Balance: <span class="balance">$<?php echo number_format($price, 2); ?></span></h4>
        <p class="error" style="opacity: 0;">Unknown error has occurred!</p>
        <div class="row center">
            <div class="btn primary" id="pay-btn">Pay</div>
            <div class="btn dark" onclick="Print('<?php echo $id; ?>')">Print Recept</div>
        </div>
    </div>
</div>

<script src="/assets/js/min/payment.min.js"></script>