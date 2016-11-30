$(function () {
    function updateCountDown() {
        var cd = moment().countdown('2016-11-30 19:00:00', countdown.DAYS | countdown.HOURS | countdown.MINUTES | countdown.SECONDS);

        $("#countdown-days").text(cd.days);
        $("#countdown-hours").text((cd.hours < 10 ? "0" : "") + cd.hours);
        $("#countdown-minutes").text((cd.minutes < 10 ? "0" : "") + cd.minutes);
        $("#countdown-seconds").text((cd.seconds < 10 ? "0" : "") + cd.seconds);

        $("#countdown-days-label").text("jour" + (cd.days > 1 ? "s" : ""));
        $("#countdown-hours-label").text("heure" + (cd.hours > 1 ? "s" : ""));
        $("#countdown-minutes-label").text("minute" + (cd.minutes > 1 ? "s" : ""));
        $("#countdown-seconds-label").text("seconde" + (cd.seconds > 1 ? "s" : ""));

        if (cd.value > 0) {
            requestAnimationFrame(updateCountDown);
        } else {
            $('#btn-book').attr('href', '/book').text('Places disponibles ici !');
            $("#countdown-days").text(0);
            $("#countdown-hours").text(0);
            $("#countdown-minutes").text(0);
            $("#countdown-seconds").text(0);

            $("#countdown-days-label").text("jour");
            $("#countdown-hours-label").text("heure");
            $("#countdown-minutes-label").text("minute");
            $("#countdown-seconds-label").text("seconde");
        }
    }

    updateCountDown();

    // Google Analytics
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-87765103-1', 'auto');
    ga('send', 'pageview');
});