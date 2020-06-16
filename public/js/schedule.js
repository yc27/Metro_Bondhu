schedulesTable = $("#Schedules-Table").DataTable({
    autoWidth: true,
    bAutoWidth: true,
    scrollX: true,
    processing: true,
    serverSide: true,
    order: [[1, "asc"]],
    pagingType: "full_numbers",
    ajax: {
        url: "/transport/show/schedules"
    },
    columns: [
        { data: "id", name: "id" },
        { data: "starts_at", name: "starts_at" },
        { data: "source", name: "source" },
        { data: "destination", name: "destination" },
        { data: "stoppages", name: "stoppages" }
    ],
    columnDefs: [
        {
            targets: 0,
            visible: false,
            searchable: false
        },
        {
            targets: 1,
            render: function (data, type, row, meta) {
                var [hh, mm, ss] = row.starts_at.split(":");
                return formatTime(parseInt(hh), parseInt(mm));
            }
        },
        {
            targets: 5,
            render: function(data, type, row, meta) {
                const btnEdit =
                    '<button type="button" class="edit-schedule btn btn-sm btn-primary" data-toggle="modal" data-target="#Modal-Schedule-Form" data-id="' +
                    row.id +
                    '">\n' +
                    '<i class="fas fa-edit mr-2"></i>\n' +
                    "Edit\n" +
                    "</button>";

                const btnDelete =
                    '<button type="button" class="delete-schedule btn btn-sm btn-danger" data-toggle="modal" data-target="#Modal-Schedule-Delete" data-id="' +
                    row.id +
                    '">\n' +
                    '<i class="fas fa-trash-alt mr-2"></i>\n' +
                    "Delete\n" +
                    "</button>";

                return btnEdit + "\n" + btnDelete;
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
    }
});

// Add Stoppage Input
$("#Btn-Add-Stoppage").click(function() {
    const inputRow =
        '<div class="col-7 col-sm-9"><input type="text" name="stoppages[]" class="form-control"></div>\n' +
        '<div class="col-5 col-sm-3" style="height: calc(1.5em + .75rem + 2px);"><button class="btn btn-danger btn-sm btn-block btn-reomve-stoppage h-100" type="button">Remove</button></div>\n';

    const stoppage =
        '<div class="form-row mb-4 align-items-center remove-stoppage">\n' +
        inputRow +
        "</div>";

    $("#Clone-Stoppage").before(stoppage);
});
// Remove Stoppage Input
$("body").on("click", ".btn-reomve-stoppage", function() {
    $(this)
        .parents(".remove-stoppage")
        .remove();
});

// Clicked to Create Schedule
$("#Btn-Create-Schedule").click(function() {
    $(".remove-stoppage").remove();
    $("#Form-Schedule").trigger("reset");
    $("#Schedule-Id").val(null);
    $("#Btn-Form-Schedule").html("Create Schedule");
    $("#Modal-Bus-Schedule-Title").html("Create New Schedule");
});

// Clicked to Edit Schedule
$("body").on("click", ".edit-schedule", function() {
    $(".remove-stoppage").remove();
    $("#Form-Schedule").trigger("reset");
    $("#Btn-Form-Schedule").html("Save Changes");
    $("#Modal-Bus-Schedule-Title").html("Edit Schedule");

    var scheduleId = $(this).data("id");
    $.get("/transport/get/schedule/" + scheduleId, function(data) {
        $("#Schedule-Id").val(data.id);
        $("#Source").val(data.source);
        $("#Destination").val(data.destination);
        $("#Start-Time").val(data.starts_at);
    });
    $.get("/transport/get/stoppages/" + scheduleId, function(data) {
        var inputRow, stoppage;
        $.each(data, function(key, item) {
            inputRow =
                '<div class="col-7 col-sm-9"><input type="text" name="stoppages[]" class="form-control" value="' +
                item.stoppage +
                '"></div>\n' +
                '<div class="col-5 col-sm-3" style="height: calc(1.5em + .75rem + 2px);"><button class="btn btn-danger btn-sm btn-block btn-reomve-stoppage h-100" type="button">Remove</button></div>\n';

            stoppage =
                '<div class="form-row mb-4 align-items-center remove-stoppage">\n' +
                inputRow +
                "</div>";

            $("#Clone-Stoppage").before(stoppage);
        });
    });
});

// Store Bus-Schedule
$("#Form-Schedule").on("submit", function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        type: "PUT",
        url: "/transport/store/schedule",
        data: $("#Form-Schedule").serialize(),
        success: function(response) {
            $(".remove-stoppage").remove();
            $("#Form-Schedule").trigger("reset");
            $("#Btn-Close-Schedule-Form").click();
            schedulesTable.ajax.reload();
            schedulesTable.columns.adjust().draw();

            createToast("success", "Success", response.msg);
        },
        error: function(xhr) {
            $.each(xhr.responseJSON.errors, function(key, item) {
                if ($.isArray(item)) {
                    $.each(item, function(key, value) {
                        $("#Form-Schedule-Error-Message").append(
                            "<li>" + item + "</li>"
                        );
                    });
                } else {
                    $("#Form-Schedule-Error-Message").append(
                        "<li>" + item + "</li>"
                    );
                }
            });

            $("#Form-Schedule-Error").removeClass("d-none");
            setTimeout(function() {
                $("#Form-Schedule-Error").addClass("d-none");
                $("#Form-Schedule-Error-Message").empty();
            }, 10000);
        }
    });
});

// Delete Bus-Schedule
$("body").on("click", "#Btn-Delete-Schedule", function() {
    var scheduleId = $(this).data("id");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $.ajax({
        type: "delete",
        url: "/transport/delete/schedule/" + scheduleId,
        success: function(data) {
            $("#Schedule-Id-" + scheduleId).remove();
            createToast("danger", "Success", "Schedule deleted successfully.");
        },
        error: function(data) {
            console.log("Error:", data);
        }
    });
});
$("body").on("click", ".delete-schedule", function() {
    $("#Btn-Delete-Schedule").data("id", $(this).data("id"));
});
