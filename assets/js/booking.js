let cabins = Array.prototype;
let currentOptions = {
    isNightly: "nightly",
    cabin: {
        name: "",
        price: 0,
        id: 0
    },
    people: {
        adults: 0,
        children: 0,
        pets: 0
    },
    nights: 7,
    arrival: null,
    departure: null,
    card: null,
    price: 0.00,
    contact: {
        name: null,
        email: null,
        phone: null,
    }
};

let scrollBox = {
    element: $("#sections")[0], current: "time-span", next: "cabin", previous: null
};

let formatter = new Intl.NumberFormat("en-US", {
    style: "currency", currency: "USD"
})


async function Submit() {
    let data = new FormData();
    data.append("name", $("#contact-information #name").val())
    data.append("email", $("#contact-information #email").val());
    data.append("phone", $("#contact-information #telephone-number").val().replaceAll('(', "").replaceAll('-', "").replaceAll(')', "").replaceAll(' ', ""));

    data.append("adults", currentOptions.people.adults);
    data.append("children", currentOptions.people.children);
    data.append("pets", currentOptions.people.pets);
    data.append("cabin", currentOptions.cabin.name);
    data.append("arrival", `${currentOptions.arrival.toISOString().split('T')[0]}`);
    data.append("departure", `${currentOptions.departure.toISOString().split('T')[0]}`);
    data.append("seasonal", !currentOptions.isNightly);
    data.append("credits", 0);
    let id = -1;
    let response = await fetch("/assets/php/includes/bookings.inc.php?c=create", { method: "POST", body: data })
    if (!response.ok) {
        console.error("not ok")
        let json = { error: "Unable to process request at this time!" };
        try {
            json = await response.json();
        } catch {
        }
        alert(json.error)
        return;
    } else {
        try {
            let json = await response.json();
            id = json["id"];
        } catch {
        }
    }
    if (id == -1) {
        window.location.href = "/error/?c=500";
    }
    return id;
}


GetCabinsList().then(() => {
    NavigateTo("time-span")
    InitCounts()
})



