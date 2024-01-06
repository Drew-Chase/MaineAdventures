const views =
{
    days: 0,
    months: 1,
    years: 2
}
function createCalendar(id, year, month, min, max, invalidDates = [], view = views.days, selected = null) {
    const calendar = $(`#calendar-${id}`);
    const date = new Date(year, month - 1, 1);
    const currentDate = new Date();

    // Clear the calendar
    calendar.empty();

    // Create the header
    const header = $('<div class="calendar-header"></div>');
    const prevButton = $('<button class="calendar-nav-button calendar-prev-button fa fa-chevron-left"></button>');
    const nextButton = $('<button class="calendar-nav-button calendar-next-button fa fa-chevron-right"></button>');
    const timeSelectorContainer = $(`<span class="calendar-time-selector"></span>`);
    const monthSelectButton = $(`<span class="calendar-current-month calendar-selector" title="select month">${date.toLocaleString('en-us', { month: 'long' })}</span>`);
    const yearSelectButton = $(`<span class="calendar-current-year calendar-selector" title="select year">${date.toLocaleString('en-us', { year: 'numeric' })}</span>`);
    const monthsContainer = $('<div class="calendar-months calendar-container"></div>');
    const yearsContainer = $('<div class="calendar-years calendar-container"></div>');
    const daysContainer = $('<div class="calendar-days calendar-container"></div>');
    const showDays = view == views.days;
    const showMonths = view == views.months;
    const showYears = view == views.years;

    const isMinimumYear = () => min.getFullYear() === year
    const isMinimumMonth = () => min.getMonth() === month - 1 && isMinimumYear()
    const updatePreviousMonthNavigation = () => isMinimumMonth() ? prevButton.addClass('disabled') : prevButton.removeClass('disabled');
    const updatePreviousYearNavigation = () => isMinimumYear() ? prevButton.addClass('disabled') : prevButton.removeClass('disabled');

    if (showMonths) {
        monthSelectButton.addClass('selected')
    }
    if (showYears) {
        yearSelectButton.addClass('selected')
        nextButton.addClass('disabled');
        prevButton.addClass('disabled');
    }

    const showNextMonth = () => {
        const nextMonth = new Date(date.getFullYear(), date.getMonth() + 1, 1);
        createCalendar(id, nextMonth.getFullYear(), nextMonth.getMonth() + 1, min, max, invalidDates, views.days, selected);
    }
    const showNextYear = () => {
        const nextYear = new Date(date.getFullYear() + 1, date.getMonth(), 1);
        createCalendar(id, nextYear.getFullYear(), nextYear.getMonth() + 1, min, max, invalidDates, views.months, selected);
    }
    const showPreviousMonth = () => {
        if (!isMinimumMonth()) {
            const prevMonth = new Date(date.getFullYear(), date.getMonth() - 1, 1);
            createCalendar(id, prevMonth.getFullYear(), prevMonth.getMonth() + 1, min, max, invalidDates, views.days, selected);
        }
    }
    const showPreviousYear = () => {
        if (!isMinimumYear()) {
            const previousYear = new Date(date.getFullYear() - 1, date.getMonth(), 1);
            createCalendar(id, previousYear.getFullYear(), previousYear.getMonth() + 1, min, max, invalidDates, views.months, selected);
        }
    }

    if (showMonths) {
        updatePreviousYearNavigation();
    } else {
        updatePreviousMonthNavigation();
    }
    if (!showYears) {
        prevButton.click(() => showMonths ? showPreviousYear() : showPreviousMonth());
        nextButton.click(() => showMonths ? showNextYear() : showNextMonth());
    }

    monthSelectButton.click(() => createCalendar(id, year, month, min, max, invalidDates, views.months, selected));
    yearSelectButton.click(() => createCalendar(id, year, month, min, max, invalidDates, views.years, selected));

    timeSelectorContainer.append(monthSelectButton);
    timeSelectorContainer.append(yearSelectButton);
    header.append(prevButton);
    header.append(timeSelectorContainer);
    header.append(nextButton);

    calendar.append(header);
    calendar.

    // Create the year view

    calendar.append(yearsContainer)

    for (let y = 0; y < 6; y++) {
        const yearButton = $(`<button class="calendar-year calendar-item"></button>`).text(min.getFullYear() + y);

        if (year + y < min.getFullYear()) {
            yearButton.addClass('invalid');
        }
        if (min.getFullYear() + y === year) {
            yearButton.addClass('selected');
        }
        if (year + y === currentDate.getFullYear() && !yearButton.hasClass('selected')) {
            yearButton.addClass('current');
        }

        yearButton.click(() => {
            if (!yearButton.hasClass("invalid")) {
                const selectedYear = min.getFullYear() + y;
                createCalendar(id, selectedYear, month, min, max, invalidDates, views.months, selected);
            }
        });

        yearsContainer.append(yearButton);
    }


    if (!showYears) {
        yearsContainer.css('display', "none")
    }

    if (!showMonths) {
        monthsContainer.css('display', "none")
    }
    calendar.append(monthsContainer);

    // Create the months of the year
    for (let m = 0; m < 12; m++) {
        const monthButton = $('<button class="calendar-month calendar-item"></button>').text(getMonthName(m));

        if (year === min.getFullYear() && m < min.getMonth()) {
            monthButton.addClass('invalid');
        }
        if (year === currentDate.getFullYear() && m === month - 1) {
            monthButton.addClass('selected');
        } else if (year === min.getFullYear() && m === min.getMonth()) {
            monthButton.addClass('current');
        }

        monthButton.click(() => {
            if (!monthButton.hasClass("invalid")) {
                const selectedMonth = m + 1;
                createCalendar(id, year, selectedMonth, min, max, invalidDates, views.days, selected);
            }
        });

        monthsContainer.append(monthButton);
    }

    function getMonthName(monthIndex) {
        const date = new Date(year, monthIndex, 1);
        return date.toLocaleString('en-us', { month: 'long' });
    }


    calendar.append(daysContainer);
    if (!showDays) {
        daysContainer.css('display', "none")
    }

    // Get the number of days in the month
    const daysInMonth = new Date(year, month, 0).getDate();

    // Get the starting day of the month
    const startDay = date.getDay();

    // Add empty days before the start day
    for (let i = 0; i < startDay; i++) {
        const emptyDay = $('<div class="calendar-day invalid calendar-item"></div>');
        daysContainer.append(emptyDay);
    }
    // Create the days of the month
    for (let day = 1; day <= daysInMonth; day++) {
        const calendarDay = $('<div class="calendar-day calendar-item"></div>').text(day);

        // Highlight the current day
        if (date.getFullYear() === currentDate.getFullYear() && date.getMonth() === currentDate.getMonth() && day === currentDate.getDate()) {
            calendarDay.addClass('current');
        }
        if (selected != null && selected.getMonth() == date.getMonth() && selected.getFullYear() == date.getFullYear() && selected.getDate() == day) {
            calendarDay.addClass('selected');
        }

        const itemDate = new Date(year, month - 1, day);
        const formattedDate = itemDate.toISOString().split('T')[0];

        if (invalidDates.includes(formattedDate) || itemDate > max || itemDate < min) {
            calendarDay.addClass('invalid');
            calendarDay.attr('title', 'This day is not available!');
            calendarDay.html(`${day}<p>This day is not available!</p>`);
        }

        // Add click event listener to select the date
        calendarDay.click(() => {
            if (calendarDay.hasClass('invalid')) {
                return;
            }
            calendar.find('.calendar-day.selected').removeClass('selected');
            calendarDay.addClass('selected');
            calendar.attr('date', formattedDate);
            selected = itemDate;
            calendar.trigger('change');
        });

        daysContainer.append(calendarDay);
    }

}
