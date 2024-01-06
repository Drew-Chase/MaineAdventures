
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