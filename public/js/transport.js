window.scheduleTable = $("#Schedule-Table").DataTable({
    autoWidth: true,
    bAutoWidth: true,
    scrollX: true,
    processing: true,
    serverSide: true,
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
            targets: 5,
            render: function(data, type, row, meta) {
                return (
                    '<button type="button" class="edit-schedule btn btn-sm btn-primary" data-toggle="modal" data-target="#Modal-Schedule-Edit" data-id="' +
                    row.id +
                    '"><i class="fas fa-edit mr-2"></i></i>Edit</button><button type="button" class="delete-schedule btn btn-sm btn-danger" data-toggle="modal" data-target="#Modal-Schedule-Delete" data-id="' +
                    row.id +
                    '"><i class="fas fa-trash-alt mr-2"></i>Delete</button>'
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
    }
});

// store bus-schedule
$(document).ready(function() {
    $("#Form-Create-Schedule").on("submit", function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        $.ajax({
            type: "PUT",
            url: "/transport/store/bus_schedule",
            data: $("#Form-Create-Schedule").serialize(),
            success: function(response) {
                document.getElementById("Form-Create-Schedule").reset();
                document.getElementById("Btn-Close-Schedule-Form").click();
                window.scheduleTable.ajax.reload();

                $("#Create-Schedule-Success-Message").html(response.msg);
                $("#Create-Schedule-Success").removeClass("d-none");
                setTimeout(function() {
                    $("#Create-Schedule-Success").addClass("d-none");
                }, 10000);
            },
            error: function(xhr, status, error) {
                console.log("Error:", error);

                $.each(xhr.responseJSON.errors, function(key, item) {
                    $("#Create-Schedule-Error-Message").append(
                        "<li>" + item + "</li>"
                    );
                });

                $("#Create-Schedule-Error").removeClass("d-none");
                setTimeout(function() {
                    $("#Create-Schedule-Error").addClass("d-none");
                    $("#Create-Schedule-Error-Message").empty();
                }, 10000);
            }
        });
    });
});

// clone stoppage input
$(document).ready(function() {
    $("#Btn-Add-Stoppage").click(function() {
        var cloned_stoppage = document.createElement("div");

        cloned_stoppage.className = "form-row mb-4 remove-clone";

        cloned_stoppage.innerHTML =
            '<div class="col-7 col-sm-9"><input type="text" name="stoppages[]" class="form-control"></div><div class="col-5 col-sm-3"><button class="btn btn-danger btn-sm btn-block btn-reomve-stoppage" type="button">Remove</button></div>';

        $("#Btn-Add-Stoppage").after(cloned_stoppage);
    });

    $("body").on("click", ".btn-reomve-stoppage", function() {
        $(this)
            .parents(".remove-clone")
            .remove();
    });
});