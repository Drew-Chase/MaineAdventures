

/**
 * It takes a date object and returns a string in the format of YYYY-MM-DD.
 * @param input - The date object to be formatted.
 * @returns A string in the format of YYYY-MM-DD
 */
function GetFormattedDate(input) {
    let day = ("0" + input.getDate()).slice(-2);
    let month = ("0" + (input.getMonth() + 1)).slice(-2);
    let year = input.getFullYear();
    return `${year}-${month}-${day}`;
}

function validateContactInformation() {
    let error = false;
    if ($("#email[interacted]").length == 1 && !(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($("#email[interacted]").val()))) {
        $("#email[interacted]").addClass("error")
    } else {
        $("#email[interacted]").removeClass("error")
    }
    if ($("#fname[interacted]").length == 1 && $("#fname[interacted]").val().length == 0) {
        $("#fname[interacted]").addClass("error")
    } else {
        $("#fname[interacted]").removeClass("error")
    }
    if ($("#lname[interacted]").length == 1 && $("#lname[interacted]").val().length == 0) {
        $("#lname[interacted]").addClass("error")
    } else {
        $("#lname[interacted]").removeClass("error")
    }
    if ($("#telephone-number[interacted]").length == 1 && $("#telephone-number[interacted]").val().replaceAll("(", "").replaceAll(")", "").replaceAll("-", "").replaceAll(" ", "").length != 10) {
        $("#telephone-number[interacted]").addClass("error")
    } else {
        $("#telephone-number[interacted]").removeClass("error")
    }
    Array.from($("#contact-information input")).forEach(i => {
        if (i.value.length == 0 || i.classList.contains("error")) {
            error = true;
        }
    })
    return !error;
}

async function LoadItemizedList() {
    let data = {
        adults: currentOptions.people.adults,
        children: currentOptions.people.children,
        pets: currentOptions.people.pets,
        cabin: currentOptions.cabin.name,
        arrival: `${currentOptions.arrival.toISOString().split('T')[0]}`,
        departure: `${currentOptions.departure.toISOString().split('T')[0]}`,
        seasonal: !currentOptions.isNightly,
    }
    let html = await $.post("/panel/itemized.php", data).then();
    $("#itemized #itemized-content").html(html)
    $("#itemized").css('display', "")
    $("#sections").css('display', "none")
    $("#itemized")[0].scrollIntoView();


}