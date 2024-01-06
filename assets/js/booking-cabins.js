


/**
 * It takes an array of objects, and creates a paragraph element for each object, and appends it to
 * a div.
 * </code>
 */
function InitCabin() {
    let cabinImage = $("#cabin-image")
    $("#cabin-names").html('');
    let index = 0;
    cabins.forEach(i => {
        let seasonal = i.seasonal != 0;
        if (currentOptions.isNightly && !seasonal || !currentOptions.isNightly && seasonal) {
            let item = document.createElement('p');
            item.id = i.name.replaceAll(' ', '-').toLowerCase();
            item.innerText = `${i.name} (${i.people} people) - ${formatter.format(i.price)}/night`;

            $("#cabin-names")[0].appendChild(item)
            $(item).attr("index", index)

            /* Adding an event listener to the item. */
            $(item).on('click', () => {
                let url = `/assets/images/cabins/${i.id}.webp`
                Array.from($("#cabin-names p[selected]")).forEach(c => {
                    $(c).attr('selected', null)
                })
                $(item).attr('selected', "")

                cabinImage.css("background-image", `url('${url}')`)
                SelectCabin($(item).attr("index"))

            })
            if (currentOptions.cabin.id == 0) {
                if (index == 0) {
                    item.click();
                }
            }
        }
        index++;
    })
}

/**
 * SelectCabin() is a function that takes in an index, and then sets the currentOptions.cabin.name,
 * currentOptions.cabin.price, and currentOptions.cabin.people to the name, price, and people of
 * the cabin at the index.
 * @param index - the index of the cabin in the cabins array
 */
function SelectCabin(index) {
    let cabin;
    cabin = cabins[index]
    currentOptions.cabin.id = cabin.id;
    currentOptions.cabin.name = cabin.name;
    currentOptions.cabin.price = cabin.price;
    currentOptions.cabin.people = cabin.people;
}

/**
 * It fetches a JSON file from the server and stores it in a variable.
 */
async function GetCabinsList() {
    let response = await fetch("/assets/php/includes/cabins.inc.php?c=get");
    let json = { "error": "Unexpected error has occurred" };
    try {
        json = await response.json();
    } catch (ex) {
        console.error(ex);
    }
    if (response.ok) {
        cabins = json;
    } else alert(json.error);

}