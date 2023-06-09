<!-- A LFInteractive Project -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Main Adventures - Ditch the city for a taste of nature</title>
    <link rel="shortcut icon" href="/assets/images/icon.svg" type="image/x-icon">

    <!-- Pages Styling -->
    <link rel="stylesheet" href="/assets/css/min/main.min.css">
    <link rel="stylesheet" href="/assets/css/min/social-media.min.css">
    <link rel="stylesheet" href="/assets/css/min/links.min.css">
    <link rel="stylesheet" href="/assets/css/min/nav.min.css">
    <link rel="stylesheet" href="/assets/css/min/scrollbar.min.css">
    <link rel="stylesheet" href="/assets/css/min/home.min.css">
    <link rel="stylesheet" href="/assets/css/min/footer.min.css">

    <!-- Responsive Styling -->
    <link rel="stylesheet" href="/assets/css/min/responsive.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/libraries/fontawesome/css/all.min.css">
    <!-- JQuery -->
    <script src="/assets/libraries/jquery.js"></script>
</head>

<body>
    <nav>
        <span id="brand">
            <a href="/" title="Go Home">
                <img src="/assets/images/icon.svg" alt="Maine Adventures Logo">
                <span class="title"> Maine Adventures </span>
            </a>
        </span>
        <div id="nav-items">
            <a href="/" class="nav-item" title="Goto Home Page">Home</a>
            <a href="/services" class="nav-item" title="Goto Services Page">Services</a>
            <a href="/booking" class="nav-item btn primary" title="Goto Booking Page">Schedule Trip</a>
        </div>
    </nav>

    <main>

        <div class="center col" style="background-color: var(--foreground); color: var(--background); padding: 100px 0; height: 50vh; min-height: 500px">
            <h1 style="margin-bottom: 0; color: var(--primary);">
                <?php
                if (isset($_GET["c"])) {
                    $code = $_GET["c"];
                    switch ($code) {
                        case "400":
                            echo "Bad Request!";
                            break;
                        case "401":
                            echo "Unauthorized Access";
                            break;
                        case "402":
                            echo "Payment Issue?";
                            break;
                        case "403":
                            echo "Your not Allowed Here";
                            break;
                        case "404":
                            echo "Page not Found";
                            break;
                        case "429":
                            echo "Too Many Requests";
                            break;
                        case "500":
                            echo "This is our bad!";
                            break;
                        case "501":
                            echo "This is our bad!";
                            break;
                        case "502":
                            echo "How are you seeing this?";
                            break;
                        case "511":
                            echo "Client not Authenticated!";
                            break;
                        case "no-cust":
                            echo "No Booking was Found!";
                            break;
                        default:
                            echo "Something went Wrong";
                            break;
                    }
                } else {
                    header("location: /error/?c=500");
                }
                ?>
            </h1>
            <h4 style="margin-top: 0">Sorry for the inconvenience</h4>
        </div>


        <section id="share-page-cta" class="col center">
            <h3>Share this Page!</h3>
            <div class="row">
                <i class="fa fa-brands fa-facebook-f social-icon center" title="Share on Facebook" onclick="Share('facebook')"></i>
                <i class="fa fa-brands fa-twitter social-icon center" title="Share on Twitter" onclick="Share('twitter')"></i>
                <i class="fa fa-solid fa-envelope social-icon center" title="Share with Email" onclick="Share('email')"></i>
            </div>
        </section>
        <section id="contact" class="row">
            <div class="col">
                <div id="phone-card" class="contact-card row" onclick="Call()" title="Call Us">
                    <i class="fa-solid fa-phone"></i>
                    <div class="col">
                        <p class="name">Phone</p>
                        <a href="tel:+1 (207) 723-9215" class="value">+1 (207) 723-9215</a>
                    </div>
                </div>
                <div id="email-card" class="contact-card row" onclick="Email()" title="Email Us">
                    <i class="fa-solid fa-envelope"></i>
                    <div class="col">
                        <p class="name">Email</p>
                        <a href="mailto:contact-us@maineadventures.org?subject=Contact US" class="value">contact-us@maineadventures.org</a>
                    </div>
                </div>
            </div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d5554.9241316447815!2d-69.222342!3d45.882071!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x81e08b7556a8c8e3!2sAllagash%20Gateway!5e0!3m2!1sen!2sus!4v1674368904758!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </section>

        <footer id="footer" class="center col">
            <img id="footer-logo" src="/assets/images/large-logo.svg" alt="">
            <a href="https://www.facebook.com/allagashgateway/" target="_blank">
                <i class="fa fa-brands fa-facebook-f social-icon center" title="Check us out on Facebook"></i>
            </a>
            <p id="copyright">&copy; Copyright 2011-2023 Allagash Gateway Campsites & Cabins. All rights reserved.</p>
        </footer>
    </main>


    <!-- JS Scripts -->
    <script src="/assets/js/min/contact-us.min.js"></script>
    <script src="/assets/js/min/social-media.min.js"></script>
    <script src="/assets/js/min/nav.min.js"></script>
    <script src="/assets/js/min/lf.min.js"></script>
</body>

</html>