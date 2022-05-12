$(document).ready(function () {
    $("#kyc-verify-wizard").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slide",
        onFinished: function (event, currentIndex) {
            $("#form").submit();
        }
    });
});
