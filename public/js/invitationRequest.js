var requestTable;
$(function() {
    $.noConflict();
    window.requestTable = $("#Request-Table").DataTable({
        processing: true,
        serverSide: true,
        order: [[3, "asc"]],
        pagingType: "full_numbers",
        ajax: {
            url: "/requests/show"
        },
        columns: [
            { data: "id", name: "id" },
            { data: "email", name: "email" },
            { data: "created_at", name: "created_at" }
        ],
        columnDefs: [
            {
                targets: 0,
                visible: false,
                searchable: false
            },
            {
                targets: 2,
                render: function(data, type, row, meta) {
                    var d = new Date(row.created_at);
                    return formateDate(d);
                }
            },
            {
                targets: 3,
                render: function(data, type, row, meta) {
                    return (
                        '<button type="button" class="generate-token btn btn-sm btn-success" data-toggle="modal" data-target="#Modal-Generate-Token" data-id="' +
                        row.id +
                        '">Generate Token</button><button type="button" class="delete-request btn btn-sm btn-danger" data-toggle="modal" data-target="#Modal-Request-Delete" data-id="' +
                        row.id +
                        '">Delete Request</button>'
                    );
                },
                searchable: false,
                orderable: false
            },
            {
                targets: "_all",
                className: "align-middle"
            }
        ],
        language: {
            lengthMenu: "Display _MENU_ records per page",
            zeroRecords: "No Data Found",
            info: "Showing page _PAGE_ of _PAGES_",
            infoEmpty: "No records available",
            infoFiltered: "(Filtered from _MAX_ total records)"
        },
        drawCallback: function(settings) {
            pendingRequests();
        }
    });
});

// Fromate Date
function formateDate(d) {
    var months = [
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

    function leadingZero(n) {
        return n < 10 ? "0" + n : n;
    }

    var hh = d.getHours();
    return (
        (hh % 12 === 0 ? 12 : hh % 12) +
        ":" +
        leadingZero(d.getMinutes()) +
        (hh > 11 ? "pm, " : "am, ") +
        leadingZero(d.getDate()) +
        " " +
        months[d.getMonth()] +
        " " +
        d.getFullYear()
    );
}

// Update No of Pending Requests
function pendingRequests() {
    var json = window.requestTable.ajax.json();
    $("#Pending-Requests").text(json.pendingRequests);
}

// Generate Token
$("body").on("click", "#Btn-Generate-Token", function() {
    var requestId = $("#Generate-Token").data("id");
    $("#Generate-Token").prop("id", "");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $.ajax({
        type: "put",
        url: "/requests/generate/token/" + requestId,
        success: function(data) {
            window.requestTable.ajax.reload();
        },
        error: function(data) {
            console.log("Error:", data);
        }
    });
});
$("body").on("click", ".generate-token", function() {
    $("#Generate-Token").prop("id", "");
    $(this).prop("id", "Generate-Token");
});

// Delete Request
$("body").on("click", "#Btn-Delete-Request", function() {
    var requestId = $("#Delete-Request").data("id");
    $("#Delete-Request").prop("id", "");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $.ajax({
        type: "delete",
        url: "/requests/delete/" + requestId,
        success: function(data) {
            window.requestTable.ajax.reload();
        },
        error: function(data) {
            console.log("Error:", data);
        }
    });
});
$("body").on("click", ".delete-request", function() {
    $("#Delete-Request").prop("id", "");
    $(this).prop("id", "Delete-Request");
});
