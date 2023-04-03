(() => {
    let user = {}
    if (!window.location.pathname.startsWith("/panel/login")&&!window.location.pathname.startsWith("/panel/register")) {
        IsLoggedIn().then(response => {
            if (!response.success) {
                console.error(response)
                window.location.href = "/panel/login"
            } else {
                user = response.user;
                console.log(`Logged in as ${user.username}`)
                Init();
            }
        });
    } else {
        IsLoggedIn().then(response => {
            if (response.success) {
                window.location.href = "/panel/"
            }
        });
    }
    function Init() {
        Array.from($(".username")).forEach(i => {
            i.innerText = user.username;
        })
    }
    async function IsLoggedIn() {
        let username = "";
        let password = "";
        let cookies = document.cookie.split(';');
        cookies.forEach(i => {
            try {
                let kv = i.split("=");
                let key = kv[0].trim();
                let value = kv[1].trim();
                if (key == "username") {
                    username = value;
                } else if (key == "password") {
                    password = value;
                }
            } catch { }
        })
        let json = await Login(username, password);
        return { success: json.error == null, user: json };
    }
    async function Login(username, password) {
        let data = new FormData();
        data.append("username", username);
        data.append("password", password);
        let response = await fetch("/assets/php/auth.inc.php?c=login", {
            body: data,
            method: "POST"
        });
        let json = { error: "Unknown error has occurred!" };
        try {
            json = await response.json();
        } catch (e) { console.error(e) }
        if (response.ok) {
            document.cookie = `username=${username}; expires=${new Date(3000, 1, 1).toLocaleString("GMT")}; path=/panel`
            document.cookie = `password=${password}; expires=${new Date(3000, 1, 1).toLocaleString("GMT")}; path=/panel`
        }

        return json;
    }

    async function Register(username, password, admin)
    {


        return Login(username, password)
    }

    function Logout() {
        document.cookie = `username=; expires=${new Date(1970, 1, 1).toLocaleString("GMT")}; path=/panel`
        document.cookie = `password=; expires=${new Date(1970, 1, 1).toLocaleString("GMT")}; path=/panel`
        window.location.href = "/";
    }

    $("#login-form input").on('keydown', e => {
        if (e.key == "Enter") {
            $("#login-form .btn")[0].click();
        }
    })
    $("#login-form .btn").on('click', () => {
        Login($("#username").val(), $("#password").val()).then(json => {
            if (json.error != null) {
                $("#login-form .error").css('opacity', "1");
                $("#login-form .error")[0].innerText = json.error;
            } else {
                $("#login-form .error").css('opacity', "0");
                window.location.href = "/panel"
            }
        })
    })
}).call();