
/**
 * It opens a new window, writes the HTML to it, and then prints it.
 */
async function Print(id) {
    let print_window = window.open(`/panel/itemized.php?id=${id}`, "PRINT", 'width=1280,height=720')
    print_window.document.close();
    print_window.onload = () => {
        print_window.focus();
        print_window.print();
        print_window.close();
    }
}

/**
 * It takes in a card number, expiration date, and cvv2, and sends it to a php file that processes the
 * payment.
 * @param id - The ID of the user who is paying.
 * @param cc - Credit Card Number
 * @param cvv2 - The 3 digit code on the back of the card.
 * @param exp - "12/20"
 * @returns The response from the server.
 */
async function Pay(id, cc, cvv2, exp) {
    let data =
    {
        card: cc,
        card_exp: exp,
        card_cvc: cvv2
    }
    let response = await $.post(`/assets/php/includes/payments.inc.php?id=${id}`, data).then();
    try {
        let json = JSON.parse(response);
        return json
    } catch {
        return { error: "Unable to parse output as json!", output: response }
    }

}