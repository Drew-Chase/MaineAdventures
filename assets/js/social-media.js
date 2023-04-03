/**
 * It takes a platform as a parameter, and then opens a new window with the appropriate url for that
 * platform
 * @param platform - The platform you want to share to.
 * @returns undefined.
 */
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
var user = null;
$('.btn.login-fb').attr('disabled', "")
window.fbAsyncInit = function () {
    FB.init({
        appId: '1262781427666667',
        autoLogAppEvents: true,
        xfbml: true,
        version: 'v16.0'
    })

    $('.btn.login-fb').attr('disabled', null)
    $('.btn.login-fb').on('click', () => {
        FB.login(login => {
            if (login.authResponse) {
                FB.api('/me', { fields: 'id,first_name,last_name,email' }, response => {
                    user = response;
                    $('.btn.login-fb').attr('disabled', "")
                });
                FB.api("/me/picture", {type: "square", width: 1024, height: 1024, redirect: false}, picture=>{
                    console.log(picture)
                })

            } else {
                console.log('User cancelled login or did not fully authorize.');
            }
        });
    })
};