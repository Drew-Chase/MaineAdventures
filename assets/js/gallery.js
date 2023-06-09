var selectedGalleryImage = null;
$(".gallery-image img").each((_, i) => {
    if (i.complete) {
        load(i.parentElement)
    }
})

$(".gallery-image img").on('load', e => load(e.currentTarget.parentElement))
$(".gallery-image:not(.admin)").on('click', e => open(e.currentTarget))
$("body").on('click', e => {
    if (e.target.tagName == "BODY") {
        if (selectedGalleryImage != null) {
            close();
        }
    }
})

function load(gallery) {
    gallery = $(gallery)
    gallery.addClass('loaded')
}
function open(gallery) {
    if (selectedGalleryImage == null) {
        gallery = $(gallery)
        gallery.addClass('fullscreen')
        $("body").addClass('overlay')
        selectedGalleryImage = gallery;
    }
}
function close() {
    if (selectedGalleryImage != null) {
        selectedGalleryImage.removeClass('fullscreen')
        $('body').removeClass('overlay')
        selectedGalleryImage = null;
    }
}