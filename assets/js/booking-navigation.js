const disableNextButton = () => $("#next").attr('disabled', "");
const enableNextButton = () => $("#next").attr('disabled', null);
const disablePreviousButton = () => $("#previous").attr('disabled', "");
const enablePreviousButton = () => $("#previous").attr('disabled', null);

/**
 * Navigates to a section by its name.
 * @param {string} name - The name of the section to navigate to.
 */
function NavigateTo(name) {
    // Check if the section has class 'footless'
    $("#section-navigation").css('opacity', $(`#${name}`).hasClass('footless') ? "0" : "");

    // Show the section
    $(`#${name}`).css("display", "");
    $(`#${name}`)[0].scrollIntoView();
    scrollBox.current = name;
    scrollBox.previous = $(`#${scrollBox.current}`).attr('previous');
    scrollBox.next = $(`#${scrollBox.current}`).attr('next');

    disableNextButton();
    disablePreviousButton();

    switch (scrollBox.current) {
        case "cabin":
            if (currentOptions.cabin.id === 0) {
                InitCabin();
            }
            break;
        case "success":
            $("#section-navigation").css('opacity', 0);
            break;

        case "itemized":
            $("#sections").css('display', "none");
            $("#section-navigation").css('display', "none");
            UpdatePrice();
            $(`#${name}`)[0].scrollIntoView();
            break;
        case "start-time":
            InitStartTimeSelector();
            break;
        case "end-time":
            InitEndTimeSelector();
            break;
    }

    setTimeout(() => {
        // Hide other sections
        scrollBox.element.querySelectorAll("section").forEach(i => {
            if (i.id !== name) {
                $(i).css('display', "none");
            }
        });

        // Enable/disable previous and next buttons
        scrollBox.next == null ? disableNextButton() : enableNextButton();
        scrollBox.previous == null ? disablePreviousButton() : enablePreviousButton();

        // Enable/disable next button based on section
        switch (scrollBox.current) {
            case "contact-information":
                validateContactInformation() ? enableNextButton() : disableNextButton()
                break;
            case "start-time":
                currentOptions.arrival != null ? enableNextButton() : disableNextButton()
                break;
            case "end-time":
                currentOptions.departure != null ? enableNextButton() : disableNextButton()
                break;
            case "payment-method":
            case "login":
                disableNextButton();
                break;
        }
    }, 500);
}
