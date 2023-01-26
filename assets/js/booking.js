var currentOptions =
{
    cabin: "",
    people: {
        adults: 3,
        children: 2
    },
    price: 4.99
}

var cabinImage = $("#cabin-image")

$(Array.from($("#cabin-names p"))).on('click', e => {
    let cabin = e.currentTarget;
    let url = `/assets/images/cabins/${cabin.id}.jpg`
    Array.from($("#cabin-names p[selected]")).forEach(c => {
        $(c).attr('selected', null)
    })
    $(cabin).attr('selected', "")

    cabinImage.css("background-image", `url('${url}')`)
    currentOptions.cabin = cabin.id.split('-').pop()
    console.log(currentOptions)
})
$("#cabin-names #cabin-a")[0].click()