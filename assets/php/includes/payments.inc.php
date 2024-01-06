<?php
header("Content-Type: application/json");
require_once "values.inc.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/libraries/stripe/init.php";
require_once "itemized.inc.php";

$stripe = new Stripe\StripeClient($stripe_skey);

if (isset($_POST["card"]) && isset($_POST["card_exp"]) && isset($_POST["card_cvc"]) && isset($_GET["id"])) {
    $stripe_account = "acct_1NK7lZJFDwLjJMKa";
    $lf_stripe_account = "acct_1NEPi0HwTmvgUvwo";

    $card_token = $_POST["card"]; // Assuming you pass the test token here
    $card_exp = explode("/", $_POST["card_exp"]);
    $card_exp_m = $card_exp[0];
    $card_exp_y = $card_exp[1];
    $card_cvc = $_POST["card_cvc"];
    $customer = $stripe->customers->create();

    try {
        // Replace creating the card token with retrieving the test token
        $card_token = 'tok_visa'; // Replace with the appropriate test token for your desired card

        $stripe->customers->createSource(
            $customer['id'],
            ['source' => $card_token]
        );

        $price = 100; // Replace with your desired price in dollars

        $stripe_amount = $price * 95 / 100; // 95% to $stripe_account
        $lf_amount = $price * 5 / 100; // 5% to $lf_stripe_account

        $response = $stripe->charges->create([
            "amount" => $stripe_amount * 100,
            "currency" => "usd",
            "customer" => $customer['id'],
            "application_fee_amount" => $lf_amount * 100,
            "destination" => [
                "account" => $stripe_account,
                "amount" => $stripe_amount * 100,
            ],
        ]);

        die(json_encode(["message" => "Payment processed successfully!"]));
    } catch (Stripe\Exception\ApiErrorException $error) {
        http_response_code(401);
        die(json_encode(["error" => $error->getMessage()]));
    }
} else if (isset($_GET['update']) && isset($_POST['ssn']) && isset($_POST['bank-account']) && isset($_POST['bank-routing'])) {
    $accountNumber = 'acct_1NK7lZJFDwLjJMKa';

    try {
        $account = \Stripe\Account::update(
            $accountNumber,
            [
                'individual' => [
                    'ssn_last_4' => $_POST['ssn'],
                ],
                'external_account' => [
                    'object' => 'bank_account',
                    'country' => 'US',
                    'currency' => 'usd',
                    'account_number' => $_POST['bank-account'],
                    'routing_number' => $_POST['bank-routing']
                ],
            ]
        );

        echo 'Updated account details successfully!';
    } catch (\Stripe\Exception\ApiErrorException $e) {
        echo 'Error updating account details: ' . $e->getMessage();
    }
} else {
    die(json_encode(["error" => "Missing parameters!"]));
}
