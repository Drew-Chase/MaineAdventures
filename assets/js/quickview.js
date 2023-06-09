(() => {
    getArrivals();
    getDepartures();
    getCalendar()
    let timeout = null;
    let searchDelay = 1000;
    $('.nav-item#search-button').on('click', () => {
        $(".search-modal").attr('active', true);
    })
    $(".search-modal").on('click', e => {
        let target = $(e.target)
        if (target.hasClass('search-modal')) {
            $(".search-modal").attr('active', null);
        }
    })
    $(".search-modal input").on('keyup', () => {
        let input = $(".search-modal input");
        if (timeout != null) {
            clearTimeout(timeout);
        }
        timeout = setTimeout(() => search(input.val()), searchDelay)
        if (input.val() == "") {
            $(".search-box").attr('focus', null)
            $(".search-results").attr('focus', null)
        } else {
            $(".search-box").attr('focus', true)
            $(".search-results").attr('focus', true)
        }
    })

    async function getArrivals() {
        let response = await $.get('/assets/php/includes/bookings.inc.php?c=arriving')
        let arrivalContent = $(".arrivals");
        if (response.message != null) {
            arrivalContent.html(`<p>${response.message}</p>`)
        } else {
            Array.from(response).forEach(item => {
                arrivalContent.append(createCustomer(item.id, item.name, item.email, item.phone, item.paid == "1", item.processed == "1"))
            })
        }
    }

    async function getCalendar() {
        let response = await $.get('/assets/php/includes/bookings.inc.php?c=calendar')
        let arrivalContent = $(".calendar");
        if (response.message != null) {
            arrivalContent.html(`<p>${response.message}</p>`)
        } else {
            let index = 0
            Array.from(response).forEach(item => {
                if (index <= 5) {
                    arrivalContent.append(createCustomer(item.id, item.name, item.email, item.phone, item.paid == "1", item.processed == "1"))
                    index++;
                }
            })
        }
    }
    async function getDepartures() {
        let response = await $.get('/assets/php/includes/bookings.inc.php?c=departing')
        let arrivalContent = $(".departures");
        if (response.message != null) {
            arrivalContent.html(`<p>${response.message}</p>`)
        } else {
            Array.from(response).forEach(item => {
                arrivalContent.append(createCustomer(item.id, item.name, item.email, item.phone, item.paid == "1", item.processed == "1"))
            })
        }
    }
    async function search(query) {
        console.log(`Searching for '${query}'`)
        let response = await $.post('/assets/php/includes/bookings.inc.php?c=search', { query: query })
        let result = $(".search-results")
        result.html("");
        Array.from(response).forEach(item => {
            result.append(createCustomer(item.id, item.name, item.email, item.phone, item.paid == "1", item.processed == "1"))
        })
    }

    function createCustomer(id, name, email, phone, paid, checkedin) {
        let item = document.createElement('div')
        item.classList.add('col', 'customer-item')

        let row = document.createElement('div')
        row.classList.add('row')

        let title = document.createElement('p')
        title.classList.add('title')
        title.innerText = name;

        let buttons = document.createElement('div')
        buttons.classList.add('row', 'buttons')

        let primaryButton = document.createElement('a')
        primaryButton.classList.add('btn', 'primary')
        primaryButton.innerText = checkedin ? "Check Out" : "Check In"
        primaryButton.href = `/panel/checkin.php?id=${id}`;

        let secondaryButton = document.createElement('div')
        secondaryButton.classList.add('btn', 'secondary', 'dark')
        secondaryButton.innerText = "More Info..."

        $(secondaryButton).on('click', () => {
            window.open(`/panel/itemized.php?id=${id}`, '_blank', 'width=1280,height=720,toolbar=no,location=no,status=no,menubar=no');
        })

        buttons.appendChild(primaryButton)
        buttons.appendChild(secondaryButton)
        row.appendChild(title)
        row.appendChild(buttons)
        item.appendChild(row)
        return item;
    }

    $("#save-cabins").on('click', () => {
        if ($("#save-cabins").attr('disabled') != null) {
            return;
        }
        $(".cabin-item").each((_, cabin) => {
            cabin = $(cabin);
            let id = cabin.attr('id');
            let name = cabin.find('input#title-input').val();
            let price = Number.parseInt(cabin.find('input#price-input').val());
            let people = Number.parseInt(cabin.find('input#people-input').val());
            let seasonal = cabin.find('toggle.seasonal option[selected]').attr('value') == "seasonal";
            let json = JSON.stringify({
                id: id,
                name: name,
                price: price,
                people: people,
                seasonal: seasonal
            });
            $("#save-cabins").attr('disabled', "true")
            $.ajax({
                url: `/assets/php/includes/cabins.inc.php?c=update`,
                type: 'POST',
                data: json,
                contentType: "application/json",
            });
            setTimeout(() => {
                $("#save-cabins").attr('disabled', null)
            }, 5000);
        })
    })
    $("#add-cabin").on('click', addCabin)
    function addCabin() {
        let id = "-1";
        let name = "";
        let price = 0;
        let people = 0;
        let seasonal = 0;
        let json = JSON.stringify({
            id: id,
            name: name,
            price: price,
            people: people,
            seasonal: seasonal
        });
        $("#save-cabins").attr('disabled', "true")
        $.ajax({
            url: `/assets/php/includes/cabins.inc.php?c=update`,
            type: 'POST',
            data: json,
            contentType: "application/json",
            complete: _ => {
                setTimeout(() => window.location.reload(), 1000)
            }
        });
    }

})();

function removeCabin(id) {
    $.get(`/assets/php/includes/cabins.inc.php?c=delete&id=${id}`)
    $(`#${id}`).addClass('delete')
    setTimeout(() => {
        $(`#${id}`).remove();
    }, 1000)
}


function uploadCabinImage(id) {
    let imagePreview = $(`#${id} .image-preview`);
    let input = document.createElement('input');
    input.type = "file";
    input.name = "image";
    input.accept = "image/jpeg, image/png, image/webp";
    input.addEventListener('change', () => {
        imagePreview.addClass('loading');
        imagePreview.empty().append('<img>');
        let imageElement = imagePreview.find('img');

        let formData = new FormData();
        formData.append('image', input.files[0]);

        $.ajax({
            url: `/assets/php/includes/cabins.inc.php?c=upload&id=${id}`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: response => {
                console.log(response);
                setTimeout(() => {
                    imageElement.attr('src', `/assets/images/cabins/${id}.webp?timestamp=${Date.now()}`);
                    imagePreview.removeClass('loading');
                }, 1000);
            },
            complete: _ => {
                imagePreview.removeClass('loading');
            }
        });
    });
    input.click();
}


function createInputAndUploadGalleryImage() {
    let input = document.createElement('input');
    input.type = "file";
    input.name = "image";
    input.accept = "image/jpeg, image/png, image/webp";
    input.multiple = true;
    input.addEventListener('change', () => {
        uploadGalleryImage(input.files)
    });
    input.click();
}

async function uploadGalleryImage(files) {
    $("#gallery.dropzone").addClass('loading')
    try {
        files = Array.from(files);
        for (const file of files) {
            console.log(file);
            let formData = new FormData();
            formData.append('image', file);
            formData.append('id', file.name);

            await new Promise((resolve, reject) => {
                $.ajax({
                    url: '/assets/php/includes/gallery-images.inc.php?c=upload',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: resolve,
                    error: reject
                });
            });
        }
        window.location.reload();
    } catch (error) {
        console.error('Error uploading files:', error);
    }
    $("#gallery.dropzone").removeClass('loading')
}


function deleteGalleryImage(id) {
    let formData = new FormData();
    formData.append('id', id)
    $.ajax({
        url: `/assets/php/includes/gallery-images.inc.php?c=delete`,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
    });
}

$("#add-image-button").on('click', e => {
    createInputAndUploadGalleryImage()
})
$(".gallery-image.admin").on('click', e => {
    e.currentTarget.remove();
    deleteGalleryImage($(e.currentTarget).find('.title').text())
})

$("#gallery").on('dragover', e => {
    e.preventDefault();
    $("#gallery").addClass('dragover');
})
$("#gallery").on('dragleave', e => {
    e.preventDefault();
    $("#gallery").removeClass('dragover');
})
$("#gallery").on('drop', e => {
    e.preventDefault();
    $("#gallery").removeClass('dragover');

    uploadGalleryImage(e.originalEvent.dataTransfer.files);
})