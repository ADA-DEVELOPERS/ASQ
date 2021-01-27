(function() {
    if (window.ctBrowser.name == 'safari') {
        try {
            var safariVersion = parseInt(window.ctBrowser.version);
        } catch(e) {
            var safariVersion = 0;
        }
        if (safariVersion >= 9) {
            window.ctSettings.parallaxDisabled = true;
            window.ctSettings.fillTopArea = true;
        }
    }
})();
