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
                name: "Suncook",
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

        UpdatePrice();
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
            UpdatePrice();
        })
        $("#adults .count").on('click', e => {
            currentOptions.people.adults = Number.parseInt($(e.target.parentElement).attr('value'));
            UpdatePrice();
        })
        $("#children .count").on('click', e => {
            currentOptions.people.children = Number.parseInt($(e.target.parentElement).attr('value'));
            UpdatePrice();
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
            console.log(currentOptions.nights)
            UpdatePrice()
        })

        $("#end-date").on('change', e => {
            let value = e.target.value;
            $("#start-date")[0].max = value;
        })
        $("#start-date").on('change', e => {
            let value = e.target.value;
            $("#end-date")[0].min = value;
        })
        UpdatePrice();
    }

    function InitPriceObserver() {
        let callback = (entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    $("#balance-amount").attr('sticky', null)
                } else {
                    $("#balance-amount").attr('sticky', "")
                }
            })
        }

        let observer = new IntersectionObserver(callback, {
            threshold: .2
        })
        observer.observe($("#balance")[0])
        $("#balance-amount[sticky]").on('click', e => {
            window.location.hash = "balance"
        })
        $("#balance .page-nav-item")[0].click()
    }

    function UpdatePrice() {
        let price = 0;
        let price_per_child = 10;
        let price_per_adult = 15;
        let price_per_pet = 10;
        price += currentOptions.people.adults * price_per_adult
        if (currentOptions.people.children > 0)
            price += currentOptions.people.children * price_per_child
        if (currentOptions.people.pets > 0)
            price += currentOptions.people.pets * price_per_pet

        price += currentOptions.cabin.price * currentOptions.nights;

        price = formatter.format(price)
        $("#book-trip-btn")[0].innerHTML = `Book Trip - ${price}`
        $("#balance-amount")[0].innerHTML = `Next <i class="fa fa-chevron-right"></i>`
        $("#item-cabin")[0].innerHTML = `Cabin: <strong>${currentOptions.cabin.name}</strong> - <span class="price">${currentOptions.cabin.price}/night</span>`
        $("#item-adults")[0].innerHTML = `Adults: <strong>${currentOptions.people.adults}</strong> - <span class="price">${formatter.format(price_per_adult)}/adult</span>`
        $("#item-children")[0].innerHTML = `Children: <strong>${currentOptions.people.children}</strong> - <span class="price">${formatter.format(price_per_child)}/child</span>`
        $("#item-pets")[0].innerHTML = `Pets: <strong>${currentOptions.people.pets}</strong> - <span class="price">${formatter.format(price_per_pet)}/pet</span>`
        $("#item-nights")[0].innerHTML = `Nights: <strong>${currentOptions.nights}</strong>`
    }


    let scrollBox = $("#sections")[0];
    function NavigateNext() {
        scrollBox.scrollBy(scrollBox.offsetWidth, 0)
    }

    function NavigatePrevious() {
        scrollBox.scrollBy(-scrollBox.offsetWidth, 0)
    }

    $("#time-span .card").on('click', e => {
        $("#cabin").css('display', "")
        currentOptions.isNightly = e.currentTarget.querySelector('.name').innerText == "Nightly"
        InitCabin()
        NavigateNext();
        setTimeout(() => {
            $("#time-span").css('display', "none")
        }, 500)
    })


    $("#cabin .next-btn").on('click', () => {
        $("#pets").css('display', "")
        NavigateNext();
        setTimeout(() => {
            $("#cabin").css('display', "none")
        }, 500)
    })

    $("#pets .next-btn").on('click', () => {
        $("#adults").css('display', "")
        NavigateNext();
        setTimeout(() => {
            $("#pets").css('display', "none")
        }, 500)
    })

    $("#adults .next-btn").on('click', () => {
        $("#children").css('display', "")
        NavigateNext();
        setTimeout(() => {
            $("#adults").css('display', "none")
        }, 500)
    })
    $("#children .next-btn").on('click', () => {
        $("#times").css('display', "")
        NavigateNext();
        setTimeout(() => {
            $("#children").css('display', "none")
        }, 500)
    })


    // InitCabin();
    InitCounts();
    // InitPriceObserver();
    InitTimeSelector()
    UpdatePrice()

}).call();