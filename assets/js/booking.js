let currentOptions =
{
    isNightly: "nightly",
    cabin: {
        name: "",
        price: 0
    },
    people: {
        adults: 0,
        children: 0,
        pets: 0
    },
    nights: 7,
    card: null,
    price: 0.00
};

(() => {


    let cabins =
    {
        nightly: [
            {
                name: "Quaker Brook",
                image: "cabin-a",
                price: 40
            },
            {
                name: "Deer Brook",
                image: "cabin-b",
                price: 40
            },
            {
                name: "Suncook (10+ People)",
                image: "cabin-c",
                price: 60
            },
            {
                name: "Rip Stream",
                image: "cabin-d",
                price: 50
            },
            {
                name: "Red Brook",
                image: "cabin-e",
                price: 50
            },
        ],
        seasonal: [
            {
                name: "Premium Lot with electricity and water",
                image: "cabin-a",
                price: 3000
            },
            {
                name: "Primitive Lot",
                image: "cabin-b",
                price: 1900
            }
        ]
    }

    let formatter = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD"
    })

    function InitCabin() {
        let cabinImage = $("#cabin-image")

        let c = currentOptions.isNightly ? Array.from(cabins.nightly) : Array.from(cabins.seasonal);
        $("#cabin-names")[0].innerHTML = '';
        let index = 0;
        c.forEach(i => {
            let item = document.createElement('p');
            item.id = i.name.replaceAll(' ', '-').toLowerCase();
            item.innerText = `${i.name} - ${formatter.format(i.price)}/night`;

            $("#cabin-names")[0].appendChild(item)
            $(item).attr("index", index)

            $(item).on('click', () => {
                let url = `/assets/images/cabins/${i.image}.jpg`
                Array.from($("#cabin-names p[selected]")).forEach(c => {
                    $(c).attr('selected', null)
                })
                $(item).attr('selected', "")

                cabinImage.css("background-image", `url('${url}')`)
                SelectCabin($(item).attr("index"))

            })
            if (index == 0) {
                item.click();
            }
            index++;
        })

        $("#cabin-names p")[0].click()
    }

    function SelectCabin(index) {
        let cabin;
        if (currentOptions.isNightly) {
            cabin = cabins.nightly[index]
        } else {
            cabin = cabins.seasonal[index]
        }
        currentOptions.cabin.name = cabin.name;
        currentOptions.cabin.price = cabin.price;
    }

    function InitCounts() {
        $(".count").on('click', e => {
            let element = e.target;
            let parent = element.parentElement;
            let siblings = Array.from(parent.querySelectorAll(".count"));
            siblings.forEach(i => {
                $(i).attr('selected', null)
            })
            $(element).attr('selected', "")
            $(parent).attr('value', element.innerText)

        })

        $("#pets .count").on('click', e => {
            currentOptions.people.pets = Number.parseInt($(e.target.parentElement).attr('value'));
        })
        $("#adults .count").on('click', e => {
            currentOptions.people.adults = Number.parseInt($(e.target.parentElement).attr('value'));
        })
        $("#children .count").on('click', e => {
            currentOptions.people.children = Number.parseInt($(e.target.parentElement).attr('value'));
        })

        $("#pets .count")[0].click();
        $("#adults .count")[1].click();
        $("#children .count")[3].click();

    }

    function InitTimeSelector() {
        let now = new Date();
        now.setDate(now.getDate() + 5);
        let start = GetFormattedDate(now)
        $("#start-date")[0].value = start;

        $("input[type=date]").attr('min', start)

        now.setDate(now.getDate() + 7);
        $("#end-date")[0].value = GetFormattedDate(now);

        $("#start-date, #end-date").on('change', () => {

            let start = $("input#end-date")[0].valueAsDate
            let end = $("input#start-date")[0].valueAsDate
            let days = Math.round((start - end) / (1000 * 60 * 60 * 24));
            currentOptions.nights = days;
        })

        $("#start-date").on('change', e => {
            let value = e.target.value;
            $("#end-date")[0].min = value;
            let startDate = e.target.valueAsDate;
            if (startDate > $("#end-date")[0].valueAsDate) {
                startDate.setDate(startDate.getDate() + 7);
                $("#end-date").val(GetFormattedDate(startDate))

            }
        })
        $("#end-date").on('change', e => {
            let value = e.target.value;
            $("#start-date")[0].max = value;
        })
    }

    function UpdatePrice() {
        let price = 0;
        let price_per_child = 10;
        let price_per_adult = 15;
        let price_per_pet = 10;

        let cabin_cost = currentOptions.cabin.price * currentOptions.nights;
        let adults_cost = currentOptions.people.adults * price_per_adult * currentOptions.nights
        let children_cost = currentOptions.people.children * price_per_child * currentOptions.nights
        let pets_cost = currentOptions.people.pets * price_per_pet * currentOptions.nights;
        price += adults_cost
        if (currentOptions.people.children > 0)
            price += children_cost
        if (currentOptions.people.pets > 0)
            price += pets_cost

        price += cabin_cost;

        currentOptions.price = price;
        price = formatter.format(price)

        $("#itemized-cabin-name")[0].innerText = currentOptions.cabin.name;
        $("#itemized-nights")[0].innerText = `${currentOptions.nights} Nights`;
        $("#itemized-cabin-price")[0].innerText = formatter.format(cabin_cost);
        $("#itemized-cabin-price-per")[0].innerText = formatter.format(currentOptions.cabin.price);

        $("#itemized-adults-count")[0].innerText = currentOptions.people.adults;
        $("#itemized-adults-price")[0].innerText = formatter.format(adults_cost);
        $("#itemized-adults-price-per")[0].innerText = formatter.format(price_per_adult);

        $("#itemized-children-count")[0].innerText = currentOptions.people.children;
        $("#itemized-children-price")[0].innerText = formatter.format(children_cost);
        $("#itemized-children-price-per")[0].innerText = formatter.format(price_per_child);

        $("#itemized-pets-count")[0].innerText = currentOptions.people.pets;
        $("#itemized-pets-price")[0].innerText = formatter.format(pets_cost);
        $("#itemized-pets-price-per")[0].innerText = formatter.format(price_per_pet);
        if (currentOptions.card != null) {
            $("#card-suffix")[0].innerText = currentOptions.card;
        } else {
            $("#itemized-paid").css('display', "none")
        }
        $("#total-balance")[0].innerHTML = price
    }


    let scrollBox = {
        element: $("#sections")[0],
        current: "time-span",
        next: "cabin",
        previous: null
    };

    function NavigateTo(name) {
        $("#section-navigation").css('opacity', "")
        $("#previous").attr('disabled', null);
        $("#next").attr('disabled', null);

        $(`#${name}`).css("display", "")
        $(`#${name}`)[0].scrollIntoView();
        scrollBox.current = name;
        scrollBox.previous = $(`#${scrollBox.current}`).attr('previous')
        scrollBox.next = $(`#${scrollBox.current}`).attr('next')

        $("#previous").attr('disabled', "");
        $("#next").attr('disabled', "");

        if (scrollBox.current == "success") {
            $("#section-navigation").css('opacity', 0)
        }
        if (scrollBox.current == "itemized") {
            $("#sections").css('display', "none")
            $("#section-navigation").css('display', "none")
            UpdatePrice()
            $(`#${name}`)[0].scrollIntoView();
        }
        setTimeout(() => {
            scrollBox.element.querySelectorAll("section").forEach(i => {
                if (i.id != name)
                    $(i).css('display', "none")
            })

            if (scrollBox.next == null) {
                $("#next").attr('disabled', "")
            } else {
                $("#next").attr('disabled', null)
            }
            if (scrollBox.previous == null) {
                $("#previous").attr('disabled', "")
            } else {
                $("#previous").attr('disabled', null)
            }

            if (scrollBox.current == "contact-information") {
                if (validateContactInformation()) {
                    $("#next").attr('disabled', null)
                } else {
                    $("#next").attr('disabled', "")
                }
            }
            if (scrollBox.current == "payment-method") {
                $("#next").attr('disabled', "")
            }
        }, 500)
    }

    function Print() {
        let print_window = window.open('', "PRINT", 'width=1280,height=720,scale=200')
        print_window.document.write(`<html>
        <head>
            <link rel="stylesheet" href="/assets/css/min/main.min.css">
            <link rel="stylesheet" href="/assets/css/min/social-media.min.css">
            <link rel="stylesheet" href="/assets/css/min/inputs.min.css">
            <link rel="stylesheet" href="/assets/css/min/links.min.css">
            <link rel="stylesheet" href="/assets/css/min/nav.min.css">
            <link rel="stylesheet" href="/assets/css/min/scrollbar.min.css">
            <link rel="stylesheet" href="/assets/css/min/booking.min.css">
            <link rel="stylesheet" href="/assets/css/min/footer.min.css">
            <style>
                .btn{
                    display:none;
                }
            </style>
        </head>
        <body>
        <div id="itemized">
            ${$("#itemized").html()}
        </div>
        </body>
        </html>`)
        print_window.document.close();
        print_window.onload = () => {
            print_window.focus();
            print_window.print();
            print_window.close();
        }
    }

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

    async function Submit() {
        return Submit(null, null, null, null)
    }

    async function Submit(card, cvc, exp) {
        UpdatePrice()
        let inPerson = card == null;
        let data = new FormData();
        data.append("first_name", $("#contact-information #fname").val());
        data.append("last_name", $("#contact-information #lname").val());
        data.append("email", $("#contact-information #email").val());
        data.append("phone", $("#contact-information #telephone-number").val());
        data.append("adults", currentOptions.adults);
        data.append("children", currentOptions.children);
        data.append("pets", currentOptions.people.pets);
        data.append("cabin", currentOptions.cabin.name);
        data.append("arrival", `${GetFormattedDate($("#start-date")[0].valueAsDate)} ${$("#start-time").val()}`);
        data.append("departure", `${GetFormattedDate($("#end-date")[0].valueAsDate)} ${$("#end-time").val()}`);
        data.append("seasonal", !currentOptions.isNightly);
        data.append("price", currentOptions.price);
        let id = -1;
        let response = await fetch("/assets/php/bookings.inc.php?c=create", { method: "POST", body: data })
        if (!response.ok) {
            console.error("not ok")
            let json = { error: "Unable to process request at this time!" };
            try {
                json = await response.json();
            } catch { }
            alert(json.error)
            return;
        } else {
            try {
                let json = await response.json();
                id = json["id"];
            } catch { }
        }
        if (id == -1) {
            alert("Unable to process request at this time!")
            return;
        }
        if (!inPerson) {
            data = new FormData();
            data.append("id", id);
            data.append("card", card);
            data.append("card_exp", exp);
            data.append("cvc", cvc);
            data.append("price", Math.ceil(currentOptions.price * 100))
            let response = await fetch("/assets/php/payments.inc.php", {
                method: "POST",
                body: data
            })
            if (response.ok) {
                let cardLength = card.split('').length;
                currentOptions.card = `x${card.slice(cardLength - 4, cardLength)}`
            } else {
                let json = { error: "Unexpected error has occurred when attempting to process your payment!" }
                try {
                    json = await response.json();
                } catch { }
                alert(json.error)
                return;
            }
        }
        NavigateTo("itemized");
    }

    $("#inperson-payment-card").on('click', () => {
        $("#previous").attr('disabled', "");
        $("#next").attr('disabled', "");
        Submit();
    })


    $("#time-span .card").on('click', e => {
        currentOptions.isNightly = e.currentTarget.querySelector('.name').innerText == "Nightly"
        InitCabin()
        NavigateTo("cabin");
        $("#section-navigation").css('opacity', "")
    })

    $("#next").on('click', e => {
        if ($(e.currentTarget).attr('disabled') == null)
            NavigateTo(scrollBox.next);
    });
    $("#previous").on('click', e => {
        if ($(e.currentTarget).attr('disabled') == null)
            NavigateTo(scrollBox.previous);
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

    InitCabin();
    InitCounts();
    InitTimeSelector()

    // NavigateTo("time-span")

}).call();



