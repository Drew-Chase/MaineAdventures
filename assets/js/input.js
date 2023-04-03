(() => {
    $("toggle").each((index, toggle) => {
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
    })
})()