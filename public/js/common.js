// loading animation
$(window).on('load', function() {
    $('.loader').fadeOut("slow");
});

// Append Leading Zero
function leadingZero(n) {
    return n < 10 ? "0" + n : n;
}

// Format Time
function formatTime(hh, mm) {
    return (
        leadingZero( ((hh + 11) % 12) + 1 ) +
        ":" +
        leadingZero(mm) +
        (hh > 11 ? "pm" : "am")
    );
}

// Format Date
function formatDate(d, m, yyyy) {
    const months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
    ];

    return (
        months[m] +
        " " +
        leadingZero(d) +
        ", " +
        yyyy
    );
}

// Fromat DateTime
function formatDateTime(d) {
    const time = formatTime(d.getHours(), d.getMinutes());
    const date = formatDate(d.getDate(), d.getMonth(), d.getFullYear());

    return date + " " + time;
}

// Create Toast
function createToast(type = "info", header = "Info", msg) {
    var btnClose =
        '<button type="button" class="ml-2 mb-0 close">\n' +
        '<span aria-hidden="true">&times;</span>\n' +
        "</button>\n";

    var toastBody =
        btnClose +
        "<strong>" +
        header +
        ": </strong> " +
        msg;

    var toast =
        '<div class="toast toast-' +
        type +
        '" style="display:none;">\n' +
        toastBody +
        "</div>\n";

    $("#Toasts").after(
        $(toast).fadeIn("slow", function() {
            setTimeout(() => {
                $(this).fadeOut("slow", function() {
                    $(this).remove();
                });
            }, 3000);
        })
    );
}

// Close Toast
$("body").on("click", ".toast .close", function() {
    $(this)
        .closest(".toast")
        .remove();
});