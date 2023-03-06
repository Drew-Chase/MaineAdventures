(() => {
    let data =
    {
        arrivals:
            [
                {
                    id: 0,
                    name: "John Doe",
                    cabin: "Cabin #4",
                    adults: 3,
                    children: 3,
                    pets: 3,
                    paid: true,
                    checkedIn: false,
                    start: "03/03/2022",
                    end: "03/16/2022"
                },
                {
                    id: 0,
                    name: "John Doe",
                    cabin: "Cabin #4",
                    adults: 3,
                    children: 3,
                    pets: 3,
                    paid: false,
                    checkedIn: false,
                    start: "03/03/2022",
                    end: "03/16/2022"
                },
            ],
        departures:
            [
                {
                    id: 0,
                    name: "John Doe",
                    cabin: "Cabin #4",
                    adults: 3,
                    children: 3,
                    pets: 3,
                    paid: true,
                    checkedIn: true,
                    start: "03/03/2022",
                    end: "03/16/2022"
                },
                {
                    id: 0,
                    name: "John Doe",
                    cabin: "Cabin #4",
                    adults: 3,
                    children: 3,
                    pets: 3,
                    paid: false,
                    checkedIn: true,
                    start: "03/03/2022",
                    end: "03/16/2022"
                },
            ],
        reviews:
            [
                {
                    id: 0,
                    name: "John Doe",
                    cabin: "Cabin #4",
                    adults: 3,
                    children: 3,
                    pets: 3,
                    paid: true,
                    checkedIn: false,
                    start: "03/03/2022",
                    end: "03/16/2022",
                    review: 1,
                    note: "This was a nice place, bad food!"
                },
                {
                    id: 0,
                    name: "John Doe",
                    cabin: "Cabin #4",
                    adults: 3,
                    children: 3,
                    pets: 3,
                    paid: true,
                    checkedIn: false,
                    start: "03/03/2022",
                    end: "03/16/2022",
                    review: 4,
                    note: "Best stay ever!!!"
                },
            ],
    };
    populateCards();
    function populateCards() {
        let arrivals = data.arrivals;
        let departures = data.departures;
        let reviews = data.reviews;
        $("#arrivals.quick-view-row .cards").html("")
        arrivals.forEach(arr => {
            createCard(arr).then(i => {
                if (!i.checkedIn) {
                    $("#arrivals.quick-view-row .cards").append(i)
                }
            })
        })
        departures.forEach(arr => {
            createCard(arr).then(i => {
                if (!i.checkedIn) {
                    $("#departures.quick-view-row .cards").append(i)
                }
            })
        })
        reviews.forEach(arr => {
            createCard(arr).then(i => {
                if (!i.checkedIn) {
                    $("#reviews.quick-view-row .cards").append(i)
                }
            })
        })

    };
    /**
     * It creates a card with the data passed in.
     * @param data - {
     * @returns The html variable is being returned.
     */
    async function createCard(data) {
        let html = await $.get("/assets/html/quickview-card.html")
        html = $($.parseHTML(html))
        let isReview = data.review != null;
        if (data.paid) {
            html.addClass('paid')
        }
        /* Populating the html with the data. */
        html.find('.name').html(data.name)
        html.find('.cabin').html(data.cabin)
        html.find('#cust-adults').html(`${data.adults} Adults`)
        html.find('#cust-children').html(`${data.children} children`)
        html.find('#cust-pets').html(`${data.pets} pets`)
        html.find('#cust-payment').html(data.paid ? "online" : "in person");
        html.find('#cust-start').html(data.start)
        html.find('#cust-end').html(data.end)
        html.find('#cust-nights').html(`${Math.round((new Date(data.end).getTime() - new Date(data.start).getTime()) / (1000 * 3600 * 24))} Nights`)


        html.find('.info-btn').on('click', () => {
            html.attr('flip', true)
        })
        html.find('.close-info-btn').on('click', () => {
            html.attr('flip', null)
        })
        if (!isReview) {
            if (data.checkedIn) {
                html.find('.front .btn.primary').html('Check Out')
                if (!data.paid) {
                    html.find('.front .btn.secondary').css('background', '#ff3131');
                    html.find('.front .btn.secondary').css('color', 'white');
                    html.find('.front .btn.secondary').css('font-weight', '900');
                    html.find('.front .btn.secondary').css('text-transform', 'uppercase');
                }
            } else {
                html.find('.front .btn.primary').html('Check In')
            }
            if (!data.paid) {
                let payBtn = html.find('.front .btn.secondary');
                payBtn.html('Pay')
                payBtn.attr('title', 'Process payment!');
                payBtn.on('click', () => {
                    window.open(`/panel/pay.php?id=${data.id}`)
                })
            } else {
                html.find('.front .btn.secondary').remove()
            }
        } else {
            html.find('.front .btn.primary').html('View')
            html.find('.front .btn.secondary').html('Respond')
            html.find('.front .content .col.center').prepend(createStars(data.review))
        }
        return html;
    }
    function createStars(rating) {
        let html = `<div class="stars row" title="${rating} / 5 Stars">`
        for (let i = 0; i < 5; i++) {
            if (i < rating) {
                html += `<i class="fa-solid fa-star"></i>`;
            } else {
                html += `<i class="fa-regular fa-star"></i>`;
            }
        }
        html += `</div>`
        return html;
    }
})()