/**
 * It calls the phone number listed.
 */
function Call() {
    // window.location.href = `tel:+1 (207) 723-9215`
    window.open(`tel:+1 (207) 723-9215`)
}
/**
 * It opens the default email client and creates a new email with the subject line "Contact US"
 */
function Email() {
    window.open(`mailto:bscanlin1@yahoo.com?subject=Contact US`)
}
function Book() {
    let arrivalDate = new Date()
    let departureDate = new Date();
    departureDate.setDate(departureDate.getDate() + 7)
    window.open(`mailto:bscanlin1@yahoo.com?subject=Book&body=Name:%0D%0AEmail:%0D%0APhone:%0D%0AArrival Date:${arrivalDate.toDateString()}%0D%0ADeparture Date:${departureDate.toDateString()}%0D%0AAdults:%0D%0AChildren:%0D%0A`)
}