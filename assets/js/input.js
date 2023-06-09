(() => {
    $("toggle").each((_, toggle) => {
        toggle = $(toggle)
        let options = toggle.find('option');
        let selected = toggle.find('option[selected]')
        let optionWidth = 100 / options.length;
        if (selected.length === 0) {
            $(options[0]).attr('selected', "")
        }
        toggle.css('--width', `${optionWidth}%`)
        options.each((index, option) => {
            $(option).click(() => {
                toggle.find('option[selected]').attr('selected', null)
                $(option).attr('selected', "")
                toggle.css('--left', `${optionWidth * index}%`)
            })
        })
        if (toggle.hasClass('password')) {
            toggle.find('option[value=show-password]').on('click', showPassword)
            toggle.find('option[value=hide-password]').on('click', hidePassword)
            $("input[type=password]").each((_, input) => {
                input = $(input)
                input.attr('og-type', 'password');
            })
        }
        toggle.find('option[selected]')[0].click();
    })
    $("input[required]").on('focusout', e => {
        let input = $(e.target);
        if (input.val() == "") {
            input.addClass('error')
        } else {
            input.removeClass('error');
        }
    })
    function showPassword() {
        $("input[type=password]").each((_, input) => {
            input = $(input)
            input.attr('type', "text")
        })
    }
    function hidePassword() {
        $("input[og-type=password]").each((_, input) => {
            input = $(input)
            input.attr('type', "password")
        })
    }
})()