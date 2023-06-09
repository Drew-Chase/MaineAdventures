// Create the calendar
function createCalendar(id, year, month, min, max, invalidDates = []) {
    const calendar = $(`#calendar-${id}`);
    const date = new Date(year, month - 1, 1);
    const currentDate = new Date();

    // Clear the calendar
    calendar.empty();

    // Create the header
    const header = $('<div class="calendar-header"></div>').html(date.toLocaleString('en-us', { month: 'long', year: 'numeric' }));
    calendar.append(header);

    // Create the days
    const daysContainer = $('<div class="calendar-days"></div>');
    calendar.append(daysContainer);

    // Get the number of days in the month
    const daysInMonth = new Date(year, month, 0).getDate();

    // Get the starting day of the month
    const startDay = date.getDay();

    // Add empty days before the start day
    for (let i = 0; i < startDay; i++) {
        const emptyDay = $('<div class="calendar-day invalid"></div>');
        daysContainer.append(emptyDay);
    }

    // Create the days of the month
    for (let day = 1; day <= daysInMonth; day++) {
        const calendarDay = $('<div class="calendar-day"></div>').text(day);

        // Highlight the current day
        if (
            date.getFullYear() === currentDate.getFullYear() &&
            date.getMonth() === currentDate.getMonth() &&
            day === currentDate.getDate()
        ) {
            calendarDay.addClass('current-day');
        }
        const itemDate = new Date(year, month - 1, day);
        const formattedDate = itemDate.toISOString().split('T')[0];
        if (invalidDates.includes(formattedDate) || itemDate > max || itemDate < min) {
            calendarDay.addClass('invalid');
            calendarDay.attr('title', "This day is not available!");
            calendarDay.html(`${day}<p>This day is not available!</p`)
        }
        
        // Add click event listener to select the date
        calendarDay.click(() => {
            if (calendarDay.hasClass('invalid')) {
                return;
            }
            calendar.find('.calendar-day.selected').removeClass('selected')
            calendarDay.addClass('selected')
            calendar.attr('date', formattedDate)
            calendar.trigger("changed")
        });

        daysContainer.append(calendarDay);
    }
}
