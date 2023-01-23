function Share(platform) {
    let url = ``;
    switch (platform) {
        case "facebook":
            url = `https://www.facebook.com/sharer/sharer.php?u=https://maineadventures.org`
            break;
        case "twitter":
            url = `https://twitter.com/share?url=https://maineadventures.org&text=Maine Adventures - Ditch the city for a taste of nature`
            break;
        case "email":
            url = `mailto:?subject=Main Adventures - Ditch the city for a taste of nature &body=For great outdoors adventures check out Maine Adventures: https://maineadventures.org&title=Share by Email`
            break;
        default:
            alert(`Invalid share platform: ${platform}`)
            return;
    }
    window.open(url, "_blank", "popup=true, width=550, height=700")
}