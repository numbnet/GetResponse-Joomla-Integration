if (document.getElementById('gr_disconnect')) {
    document.getElementById('gr_disconnect').onclick = function () {
        document.getElementById('gr-disconnect-overlay').classList.remove('gr-hidden');
        return false;
    };
}

if (document.getElementById('gr-stay-connected')) {
    document.getElementById('gr-stay-connected').onclick = function () {
        document.getElementById('gr-disconnect-overlay').classList.add('gr-hidden');
        return false;
    };
}

if (document.getElementsByClassName('GR_click_hint')) {
    var hints = document.getElementsByClassName('GR_click_hint');

    for (var i = 0; i < hints.length; i++) {
        hints[i].onclick = function () {
            var href = this.getAttribute('href'),
                element = document.getElementById(href.substr(1));

            if (element.hasClass('gr-hidden')) {
                element.classList.remove('gr-hidden');
            } else {
                element.classList.add('gr-hidden');
            }

            return false;
        }
    }
}