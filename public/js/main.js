// display DataTables
var schedulesTable;
var routesTable;
var requestsTable;

$(document).ready(function() {
    $.noConflict();
    $("table.display").dataTable();
});

// side nav-bar collapse function
var sidebarToggle = document.getElementById("Sidenav-Toggle");
sidebarToggle.addEventListener("click", function() {
    var sidebar = document.getElementById("Side-Navbar");
    sidebar.classList.toggle("active");

    content = document.getElementById("Page-Content");
    content.classList.toggle("pushed-right");
    
    setTimeout(function() {
        schedulesTable.columns.adjust().draw();
        routesTable.columns.adjust().draw();
        requestsTable.columns.adjust().draw();
        $noticeMason.masonry();
    }, 500);
});

// get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
// tab change function
function openMenu(evt, menu) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    var active = document.getElementsByClassName(menu);
    for (i = 0; i < active.length; i++) {
        active[i].className += " active";
    }
    document.getElementById(menu).style.display = "block";
    
    if (menu === "Notice") {
        $noticeMason.masonry();
    } else if (menu === "Transport") {
        schedulesTable.columns.adjust().draw();
    }else if (menu === "Invite") {
        requestsTable.columns.adjust().draw();
    }
}

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