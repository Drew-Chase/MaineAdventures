
$("#online-payment-card, #inperson-payment-card").on('click', () => {
    $("#previous").attr('disabled', "");
    $("#next").attr('disabled', "");
    LoadItemizedList();
})
$("#inperson-payment-card").on('click', () => {
    $("#submit-booking-btn").on('click', async () => {
        let id = await Submit();
        if (id != -1) window.location.href = `/booking/complete/?id=${id}`;
    })
})
$("#online-payment-card").on('click', () => {
    $("#submit-booking-btn").on('click', async () => {
        let id = await Submit();
        if (id != -1) window.location.href = `/booking/pay.php?id=${id}`;
    })
})
$("#cancel-booking-btn").on('click', async () => {
    $("#itemized").css('display', "none")
    $("#sections").css('display', "")
    $("#sections")[0].scrollIntoView();
    NavigateTo("cabin");
    $("#submit-booking-btn").off('click', "**")
})

$("#time-span .card").on('click', e => {
    currentOptions.isNightly = e.currentTarget.querySelector('.name').innerText == "Nightly"
    NavigateTo(scrollBox.next);
})

$("#next").on('click', e => {
    if ($(e.currentTarget).attr('disabled') == null) NavigateTo(scrollBox.next);
});
$("#previous").on('click', e => {
    if ($(e.currentTarget).attr('disabled') == null) NavigateTo(scrollBox.previous);
});

$("input[type=tel]").on('keydown', e => {
    let key = e.key;
    if ((key != "Enter" && key != "Backspace") && (isNaN(key) || isNaN(parseInt(key)))) {
        e.preventDefault();
    }
})
$("input[type=tel]").on('change', e => {
    let input = e.currentTarget;
    let num = $(input).val().replace(/\D/g, '');
    if (num != "") {
        let area = num.substring(0, 3);
        let town = num.substring(3, 6)
        let unique = num.substring(6, 10);
        $(input).val(`(${area}) ${town}-${unique}`);
    }
})
$("#contact-information input").on("focus", e => $(e.target).attr('interacted', ""))
$("#contact-information input").on("keyup", () => {
    if (validateContactInformation()) {
        $("#next").attr('disabled', null)
    } else {
        $("#next").attr('disabled', "")
    }
})


$(".btn.print").on('click', () => Print())

$("section").css("display", "none")