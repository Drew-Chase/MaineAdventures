(async () => {
    let cabins = Array.prototype;
    let currentOptions = {
        isNightly: "nightly",
        cabin: {
            name: "",
            price: 0,
            id: 0
        },
        people: {
            adults: 0,
            children: 0,
            pets: 0
        },
        nights: 7,
        arrival: new Date(),
        departure: new Date(),
        card: null,
        price: 0.00
    };


    let formatter = new Intl.NumberFormat("en-US", {
        style: "currency", currency: "USD"
    })

    /**
     * It fetches a JSON file from the server and stores it in a variable.
     */
    async function GetCabinsList() {
        let response = await fetch("/assets/php/includes/cabins.inc.php?c=get");
        let json = { "error": "Unexpected error has occurred" };
        try {
            json = await response.json();
        } catch (ex) {
            console.error(ex);
        }
        if (response.ok) {
            cabins = json;
        } else alert(json.error);

    }

    /**
     * It takes an array of objects, and creates a paragraph element for each object, and appends it to
     * a div.
     * </code>
     */
    function InitCabin() {
        let cabinImage = $("#cabin-image")
        $("#cabin-names").html('');
        let index = 0;
        cabins.forEach(i => {
            let seasonal = i.seasonal != 0;
            if (currentOptions.isNightly && !seasonal || !currentOptions.isNightly && seasonal) {
                let item = document.createElement('p');
                item.id = i.name.replaceAll(' ', '-').toLowerCase();
                item.innerText = `${i.name} (${i.people} people) - ${formatter.format(i.price)}/night`;

                $("#cabin-names")[0].appendChild(item)
                $(item).attr("index", index)

                /* Adding an event listener to the item. */
                $(item).on('click', () => {
                    let url = `/assets/images/cabins/${i.id}.webp`
                    Array.from($("#cabin-names p[selected]")).forEach(c => {
                        $(c).attr('selected', null)
                    })
                    $(item).attr('selected', "")

                    cabinImage.css("background-image", `url('${url}')`)
                    SelectCabin($(item).attr("index"))

                })
                if (currentOptions.cabin.id == 0) {
                    if (index == 0) {
                        item.click();
                    }
                }
            }
            index++;
        })
    }

    /**
     * SelectCabin() is a function that takes in an index, and then sets the currentOptions.cabin.name,
     * currentOptions.cabin.price, and currentOptions.cabin.people to the name, price, and people of
     * the cabin at the index.
     * @param index - the index of the cabin in the cabins array
     */
    function SelectCabin(index) {
        let cabin;
        cabin = cabins[index]
        currentOptions.cabin.id = cabin.id;
        currentOptions.cabin.name = cabin.name;
        currentOptions.cabin.price = cabin.price;
        currentOptions.cabin.people = cabin.people;
    }

    /**
     * It's a function that takes a click event and sets the value of the clicked element to the value
     * of the parent element.
     */
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
    }

    let scrollBox = {
        element: $("#sections")[0], current: "time-span", next: "cabin", previous: null
    };

    /**
     * It takes a string as an argument, and then it hides all the sections except the one with the id that
     * matches the string.
     * @param name - The name of the section to navigate to.
     */

    function NavigateTo(name) {
        if ($(`#${name}`).hasClass('footless')) {
            $("#section-navigation").css('opacity', "0")
        } else {
            $("#section-navigation").css('opacity', "")
        }
        $("#previous").attr('disabled', null);
        $("#next").attr('disabled', null);

        $(`#${name}`).css("display", "")
        $(`#${name}`)[0].scrollIntoView();
        scrollBox.current = name;
        scrollBox.previous = $(`#${scrollBox.current}`).attr('previous')
        scrollBox.next = $(`#${scrollBox.current}`).attr('next')

        $("#previous").attr('disabled', "");
        $("#next").attr('disabled', "");
        if (scrollBox.current == "cabin" && currentOptions.cabin.id == 0) {
            InitCabin()
        }
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
                if (i.id != name) $(i).css('display', "none")
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
            if (scrollBox.current == "login") {
                $("#next").attr('disabled', "");
            }
        }, 500)
    }

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

    async function Submit() {
        let data = new FormData();
        data.append("name", $("#contact-information #name").val())
        data.append("email", $("#contact-information #email").val());
        data.append("phone", $("#contact-information #telephone-number").val().replaceAll('(', "").replaceAll('-', "").replaceAll(')', "").replaceAll(' ', ""));

        data.append("adults", currentOptions.people.adults);
        data.append("children", currentOptions.people.children);
        data.append("pets", currentOptions.people.pets);
        data.append("cabin", currentOptions.cabin.name);
        data.append("arrival", `${GetFormattedDate(currentOptions.arrival)}`);
        data.append("departure", `${GetFormattedDate(currentOptions.departure)}`);
        data.append("seasonal", !currentOptions.isNightly);
        data.append("credits", 0);
        let id = -1;
        let response = await fetch("/assets/php/includes/bookings.inc.php?c=create", { method: "POST", body: data })
        if (!response.ok) {
            console.error("not ok")
            let json = { error: "Unable to process request at this time!" };
            try {
                json = await response.json();
            } catch {
            }
            alert(json.error)
            return;
        } else {
            try {
                let json = await response.json();
                id = json["id"];
            } catch {
            }
        }
        if (id == -1) {
            window.location.href = "/error/?c=500";
        }
        return id;
    }

    async function LoadItemizedList() {
        let data = {
            adults: currentOptions.people.adults,
            children: currentOptions.people.children,
            pets: currentOptions.people.pets,
            cabin: currentOptions.cabin.name,
            arrival: `${GetFormattedDate($("#start-date")[0].valueAsDate)}`,
            departure: `${GetFormattedDate($("#end-date")[0].valueAsDate)}`,
            seasonal: !currentOptions.isNightly,
        }
        let html = await $.post("/panel/itemized.php", data).then();
        $("#itemized #itemized-content").html(html)
        $("#itemized").css('display', "")
        $("#sections").css('display', "none")
        $("#itemized")[0].scrollIntoView();


    }

    await GetCabinsList()


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
    NavigateTo("time-span")

    InitCounts()
    InitTimeSelector()

}).call();



