(() => {
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
        price: 0.00
    }

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
        let day = ("0" + now.getDate()).slice(-2);
        let month = ("0" + (now.getMonth() + 1)).slice(-2);
        let start = now.getFullYear() + "-" + (month) + "-" + (day);
        $("#start-date")[0].value = start;

        $("input[type=date]").attr('min', start)
        $("input[type=month]").attr('min', `${now.getFullYear()}-${month}`)
        $("input[type=month]").attr('value', `${now.getFullYear()}-${month}`)
        $("input[type=month]").attr('placeholder', `${month}/${now.getFullYear().toString().substring(2, 4)}`)

        now.setDate(now.getDate() + 7);
        day = ("0" + now.getDate()).slice(-2);
        month = ("0" + (now.getMonth() + 1)).slice(-2);
        start = now.getFullYear() + "-" + (month) + "-" + (day);
        $("#end-date")[0].value = start;

        $("#start-date, #end-date").on('change', () => {

            let start = $("input#end-date")[0].valueAsDate
            let end = $("input#start-date")[0].valueAsDate
            let days = Math.round((start - end) / (1000 * 60 * 60 * 24));
            currentOptions.nights = days;
        })

        $("#start-date").on('change', e => {
            let value = e.target.value;
            $("#end-date")[0].min = value;
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

        $("#total-balance")[0].innerHTML = price
    }


    let scrollBox = {
        element: $("#sections")[0],
        current: "time-span",
        next: "cabin",
        previous: null
    };
    function NavigateNext() {

        $(`#${scrollBox.next}`).css('display', "")
        scrollBox.element.scrollBy(scrollBox.element.offsetWidth, 0)
        scrollBox.previous = scrollBox.current
        scrollBox.current = scrollBox.next
        scrollBox.next = $(`#${scrollBox.current}`).attr('next')
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
            let update = setInterval(() => {
                if (validateContactInformation()) {
                    if (update != null) {
                        clearInterval(update)
                        update = null;
                    }
                }
            }, 1000)
        }
        if (scrollBox.current == "itemized") {
            UpdatePrice()
        }
        setTimeout(() => {
            scrollBox.element.querySelectorAll("section").forEach(i => {
                if (i.id != scrollBox.current)
                    $(i).css('display', "none")
            })
        }, 500)
        window.scrollTo(0, $("#sections")[0].offsetTop)
    }

    function NavigatePrevious() {
        $(`#${scrollBox.previous}`).css('display', "")

        scrollBox.current = scrollBox.previous
        scrollBox.previous = $(`#${scrollBox.current}`).attr('previous')
        scrollBox.next = $(`#${scrollBox.current}`).attr('next')
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
        setTimeout(() => {
            scrollBox.element.querySelectorAll("section").forEach(i => {
                if (i.id != scrollBox.current)
                    $(i).css('display', "none")
            })
        }, 500)
        window.scrollTo(0, $("#sections")[0].offsetTop)
    }

    function Print() {
        let print_window = window.open('', "PRINT", 'width=1280,height=720,top=100,left=150')
        print_window.document.write(`<html>
        <head>
        </head>
        <body>
        ${$("#itemized").html()}
        </body>
        </html>`)
        print_window.document.close();
        print_window.focus();
        print_window.print();
        print_window.close();
    }

    $("#time-span .card").on('click', e => {
        currentOptions.isNightly = e.currentTarget.querySelector('.name').innerText == "Nightly"
        InitCabin()
        NavigateNext();
        $("#section-navigation").css('opacity', "")
    })

    $("#next").on('click', e => {
        if ($(e.currentTarget).attr('disabled') == null)
            NavigateNext()
    });
    $("#previous").on('click', e => {
        if ($(e.currentTarget).attr('disabled') == null)
            NavigatePrevious()
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
    // $("#contact-information input").on("keydown", () => validateContactInformation())

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
        Array.from($("#contact-information input[interacted]")).forEach(i => {
            if (i.value.length == 0 || i.classList.contains("error")) {
                error = true;
            }
        })
        console.log(!error)
        return !error;
    }


    $("#print-itemized").on('click', () => Print())
    InitCabin();
    InitCounts();
    InitTimeSelector()

}).call();