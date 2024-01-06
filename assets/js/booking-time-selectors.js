var unavailableDates = [];

function InitStartTimeSelector() {
    const cabin = currentOptions.cabin.name;

    const currentDate = new Date();
    const minDate = new Date();
    minDate.setDate(currentDate.getDate() + 4);
    const maxDate = new Date();
    maxDate.setFullYear(currentDate.getFullYear() + 10);

    const url = `/assets/php/includes/bookings.inc.php?c=unavailable&cabin=${encodeURIComponent(cabin)}`;

    $.get(url, { format: 'json' })
        .done(function (response) {
            unavailableDates = response || [];

            const year = minDate.getFullYear();
            const month = minDate.getMonth() + 1;

            createCalendar('start', year, month, minDate, maxDate, unavailableDates, 0, currentOptions.arrival);
        })
        .fail(function () {
            console.error('Failed to fetch unavailable dates.');
        });

    $("#calendar-start").on('change', e => {
        currentOptions.arrival = new Date($(e.target).attr('date'));
        currentOptions.arrival.setDate(currentOptions.arrival.getDate() + 1)
        enableNextButton();
    })
}

function InitEndTimeSelector() {
    const currentDate = new Date();
    const minDate = new Date($("#calendar-start").attr('date'));
    minDate.setDate(minDate.getDate() + 1)
    var maxDate = new Date();
    maxDate.setFullYear(currentDate.getFullYear() + 6);

    if (unavailableDates != []) {
        for (let i = 0; i < unavailableDates.length; i++) {
            let date = new Date(unavailableDates[i])
            if (date > minDate) {
                maxDate = date;
                maxDate.setDate(date.getDate() - 1);
                break;
            }
        }
    }

    const year = minDate.getFullYear();
    const month = minDate.getMonth() + 1;

    createCalendar('end', year, month, minDate, maxDate, unavailableDates, 0, currentOptions.departure);

    $("#calendar-end").on('change', e => {
        currentOptions.departure = new Date($(e.target).attr('date'));
        currentOptions.departure.setDate(currentOptions.departure.getDate() + 1)
        enableNextButton();
    })
}