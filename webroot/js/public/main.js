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

        requestAnimationFrame(updateCountDown);
    }

    updateCountDown();
});