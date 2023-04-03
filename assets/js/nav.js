var nav = $("nav")
var pageArrow = $("#page-arrow")
$(document).on('scroll', () => {
    if (window.scrollY <= window.screen.availHeight / 2) {
        pageArrow.attr("fixed", false);
    } else {
        pageArrow.attr("fixed", true);
    }
    if (nav.attr('static') == null) {
        if (window.scrollY <= 50) {
            nav.attr("fixed", false);
        } else {
            nav.attr("fixed", true);
        }
    }
})

pageArrow.on("click", () => {
    let isFixed = pageArrow.attr("fixed") != null && pageArrow.attr("fixed") == "true";
    if (isFixed) {
        window.scrollTo(0, 0)
    } else {
        window.scrollTo(0, window.screen.height - 200)
    }
})

$("#nav-hamburger").on("click", () => {
    let isActive = nav.hasClass("active")
    if (isActive) {
        $("body").css("overflow", "")
        nav.removeClass("active")
    } else {
        $("body").css("overflow", "hidden")
        nav.addClass("active")
    }
})