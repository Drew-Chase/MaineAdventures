const error = $("p.error")
$("#pay-btn").on('click', () => {
    error.css('opacity', "0")
    const card = $("input#ccnumber").val();
    const cvv = $("input#cvv2").val();
    const exp = $("input#exp").val();
    Pay(id, card, cvv, exp).then(response => {
        if (admin) {
            window.location.href = "/panel"
        }
        else {
            window.location.href = `/order-complete.php?id=${id}&show-print`
        }
    })
        .catch(msg => {
            error.css('opacity', "1")
            error.html('Unable to process payment information. Please check your payment information and try again.')
            console.error(msg);
        });
})


/**
 * It opens a new window, writes the HTML to it, and then prints it.
 */
async function Print(id) {
    let print_window = window.open(`/panel/itemized.php?id=${id}&print`, "PRINT", 'width=1280,height=720')
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
    console.log(data)
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: `/assets/php/includes/payments.inc.php?id=${id}`,
            data: data,
            success: response => {
                try {
                    let json = JSON.parse(response);
                    resolve(json);
                } catch {
                    reject({ error: "Unable to parse output as JSON!", output: response });
                }
            },
            error: (xhr, status, error) => {
                reject({ error: "Unexpected error has occurred!", output: error, status, xhr });
            }
        });
    });
}