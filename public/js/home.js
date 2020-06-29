// Scroll To Top
$(".btn-scroll-top").click(function() {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});

// Scroll To Section
$("#Navbar-Content .nav-link").click(function (e) {
    e.preventDefault();

    var menu = $(this).data("menu");

    var offset = $("#" + menu).offset().top;
    offset -= $("nav").innerHeight();

    $("body, html").animate(
        {
            scrollTop: offset
        },
        500
    );
});

$(".Feedback").click(function(e) {
    e.preventDefault();

    var offset = $("#Feedback").offset().top;
    offset -= $("nav").innerHeight();

    $("body, html").animate(
        {
            scrollTop: offset
        },
        500
    );
});

// Show Schedules
$("#Schedules-Table").DataTable({
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
            render: function(data, type, row, meta) {
                var [hh, mm, ss] = row.starts_at.split(":");
                return formatTime(parseInt(hh), parseInt(mm));
            }
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

// Draw Map
mapRoutes.on("load", function() {
    $.get("/transport/get/routes").done(function(routes) {
        $.each(routes, function(index, route) {
            var start = route["source_lng"] + "," + route["source_lat"];
            var end = route["destination_lng"] + "," + route["destination_lat"];

            var coords = route["way_points"];
            coords += coords == null ? "" : ";";

            coords =
                start +
                ";" +
                (coords == "null" || coords == null ? "" : coords) +
                end;

            getDirection(coords, route["id"]);
        });
    });
});
function getDirection(coordinates, id = 0) {
    var url =
        "https://api.mapbox.com/directions/v5/mapbox/driving/" +
        coordinates +
        "?geometries=geojson&access_token=" +
        mapboxgl.accessToken;

    var req = new XMLHttpRequest();
    req.responseType = "json";
    req.open("GET", url, true);

    req.onload = function() {
        var jsonResponse = req.response;
        var coords = jsonResponse.routes[0].geometry;
        drawRoute(coords, "route-" + id);
    };

    req.send();
}
function drawRoute(coords, layer = "route") {
    if (mapRoutes.getSource(layer)) {
        mapRoutes.removeLayer(layer);
        mapRoutes.removeSource(layer);
    }

    var colors = [
        "#669DF6",
        "#AFA828",
        "#7C029D",
        "#1869FC",
        "#008C47",
        "#DD1E76",
        "#F2706C",
        "#9DCB16",
        "#9D4D19",
        "#4E4161"
    ];
    var idx = Math.floor(Math.random() * 10);

    mapRoutes.addLayer({
        id: layer,
        type: "line",
        source: {
            type: "geojson",
            data: {
                type: "Feature",
                properties: {},
                geometry: coords
            }
        },
        layout: {
            "line-join": "round",
            "line-cap": "round"
        },
        paint: {
            "line-color": colors[idx],
            "line-width": 6,
            "line-opacity": 0.9
        }
    });
    mapRoutes.resize();
}

// Initialize Tiny Editor
tinymce.init({
    selector: "#message",
    skin: "oxide-dark",
    content_css: "css/style.css",
    extended_valid_elements: "blockquote[class=blockquote]",
    plugins: "lists",
    toolbar:
        "undo redo | bold italic underline | fontsizeselect | alignleft aligncenter alignright alignjustify | blockquote | bullist numlist | subscript superscript | forecolor backcolor | outdent indent | removeformat",
    menubar: false,
    force_br_newlines: true,
    force_p_newlines: false,
    forced_root_block: "div",
    min_height: 300,
    max_height: 350
});

// Store Message
$("#Form-Message").on("submit", function(e) {
    e.preventDefault();
    tinymce.triggerSave();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        type: "POST",
        url: "/store/message",
        data: $("#Form-Message").serialize(),
        success: function(response) {
            $("#Form-Message").trigger("reset");

            createToast("success", "SUCCESS:", response.msg);
        },
        error: function(xhr) {
            if (xhr.status == 422) {
                $.each(xhr.responseJSON.errors, function(key, item) {
                    if ($.isArray(item)) {
                        $.each(item, function(key, value) {
                            createToast("danger", "ERROR", value);
                        });
                    } else {
                        createToast("danger", "ERROR", item);
                    }
                });
            } else {
                createToast(
                    "danger",
                    "ERROR",
                    "Something went wrong!<br>Please try again after some time."
                );
            }
        }
    });
});

// Get Sessions
function getSessions() {
    return $.get("/routine/get/sessions");
}

// Get Departments
function getDepartments() {
    return $.get("/routine/get/departments");
}

// Get Batches
function getBatches(dept_id) {
    return $.get("/routine/get/batches/" + dept_id);
}

// Get Sections
function getSections(batch_id) {
    return $.get("/routine/get/sections/" + batch_id);
}

// Set Department Options
function setDepartmentOptions(form) {
    var deferred = new $.Deferred();

    getDepartments().done(function(departments) {
        var departmentOptions = "";
        $.each(departments, function(index, value) {
            departmentOptions +=
                '<option value="' +
                value["id"] +
                '">' +
                value["short_name"] +
                "</option>";
        });
        $(form + " .Select-Department").html(departmentOptions);

        deferred.resolve();
    });

    return deferred.promise();
}

// Set Batch Options
function setBatchOptions(form, deptId) {
    var deferred = new $.Deferred();

    getBatches(deptId).done(function(batches) {
        var batchOptions = "";
        $.each(batches, function(index, value) {
            batchOptions +=
                '<option value="' +
                value["id"] +
                '">' +
                value["batch_no"] +
                "</option>";
        });
        $(form + " .Select-Batch").html(batchOptions);

        deferred.resolve();
    });

    return deferred.promise();
}

// Set Section Options
function setSectionOptions(form, batchId) {
    var deferred = new $.Deferred();

    getSections(batchId).done(function(sections) {
        var sectionOptions = "";
        $.each(sections, function(index, value) {
            sectionOptions +=
                '<option value="' +
                value["id"] +
                '">' +
                value["section_no"] +
                "</option>";
        });
        $(form + " .Select-Section").html(sectionOptions);

        deferred.resolve();
    });

    return deferred.promise();
}

// Set Session Options
function setSessionOptions(form) {
    var deferred = new $.Deferred();

    getSessions().done(function(sessions) {
        var sessionOptions = "";
        $.each(sessions, function(index, value) {
            sessionOptions +=
                '<option value="' +
                value["id"] +
                '">' +
                value["session"] +
                "</option>";
        });
        $(form + " .Select-Session").html(sessionOptions);

        deferred.resolve();
    });

    return deferred.promise();
}

// Create Routine Table Cell
function createRoutineCell(subject, teacher, room) {
    const cell =
        '<span class="subject">' +
        subject +
        '</span></br>by <span class="teacher">' +
        teacher +
        '</span></br>at <span class="room">' +
        room +
        "</span>\n";

    return cell;
}

// Create Routine Table
function setRoutineTable(data) {
    var deferred = new $.Deferred();

    const btnPDF =
        '<button class="btn btn-sm btn-primary ml-0 download-routine-pdf" data-session="' +
        data.sessionId +
        '" data-department="' +
        data.departmentId +
        '" data-batch="' +
        data.batchId +
        '" data-section="' +
        data.sectionId +
        '"><i class="fas fa-file-pdf mr-2"></i>Download PDF</button>\n';

    const btnClear =
        '<button class="btn btn-sm btn-danger ml-0 clear-routine-table"><i class="fas fa-times-circle mr-2"></i>Clear Result</button>\n';

    const buttons = "<div>" + btnPDF + btnClear + "</div>\n";

    var tableHeader =
        '<div class="d-flex align-items-end justify-content-between mb-2">\n' +
        "<div>Dept: <strong>" +
        data.departmentName["short_name"] +
        "</strong></br>Batch: <strong>" +
        data.batchNo["batch_no"] +
        "</strong></br>Section: <strong>" +
        data.sectionNo["section_no"] +
        "</strong></br>Session: <strong>" +
        data.session["session"] +
        "</strong></div>\n" +
        buttons +
        "\n</div>";

    var tableRows = "<tr><th></th>";
    $.each(data.periods, function(key, period) {
        var [hh_s, mm_s, ss_s] = period["start_time"].split(":");
        var [hh_e, mm_e, ss_e] = period["end_time"].split(":");

        tableRows +=
            '<th class="text-center">' +
            formatTime(parseInt(hh_s), parseInt(mm_s)) +
            " - " +
            formatTime(parseInt(hh_e), parseInt(mm_e)) +
            "</th>";
    });
    tableRows += "</tr>";

    const tableHead = "<thead>" + tableRows + "</thead>\n";

    tableRows = "";
    $.each(data.classDays, function(key, classDay) {
        tableRows +=
            '<tr><td class="align-middle">' + classDay["day"] + "</td>";
        $.each(data.periods, function(key, period) {
            var flag = false;
            $.each(data.routines, function(key, routine) {
                if (
                    routine["day"] === classDay["id"] &&
                    routine["period"] === period["id"]
                ) {
                    tableRows +=
                        '<td class="text-center align-middle py-2">\n' +
                        createRoutineCell(
                            routine["subject"],
                            routine["teacher"],
                            routine["room"]
                        ) +
                        "</td>\n";
                    flag = true;
                }
            });
            if (flag === false) {
                tableRows += '<td class="text-center align-middle">\n</td>';
            }
        });
        tableRows += "</tr>";
    });

    const tableBody = "<tbody>" + tableRows + "</tbody>\n";
    const table =
        '<table class="table table-sm" id="Table-Routine">\n' +
        tableHead +
        tableBody +
        "</table>";

    const result = "<hr>\n" + tableHeader + "\n" + table;

    $("#Routine-Search-Reasult").html(result);

    deferred.resolve();
    return deferred.promise();
}

// Set Routine Search Form
$("#Routine-Search-Reasult").empty();
setSessionOptions("#Form-Routine-Search");
setDepartmentOptions("#Form-Routine-Search").done(function() {
    setBatchOptions(
        "#Form-Routine-Search",
        $("#Form-Routine-Search .Select-Department").val()
    ).done(function() {
        setSectionOptions(
            "#Form-Routine-Search",
            $("#Form-Routine-Search .Select-Batch").val()
        );
    });
});

// Change Options For Batches & Sections
$("#Form-Routine-Search").on("change", ".Select-Department", function() {
    setBatchOptions("#Form-Routine-Search", $(this).val()).done(function() {
        setSectionOptions(
            "#Form-Routine-Search",
            $("#Form-Routine-Search .Select-Batch").val()
        );
    });
});
$("#Form-Routine-Search").on("change", ".Select-Batch", function() {
    setSectionOptions("#Form-Routine-Search", $(this).val());
});

// Search Routin
$("#Form-Routine-Search").on("submit", function(e) {
    e.preventDefault();
    $("#Routine-Search-Reasult").slideUp("slow", function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });

        $.ajax({
            type: "GET",
            url: "/routine/search",
            data: $("#Form-Routine-Search").serialize(),
            success: function(response) {
                setRoutineTable(response).done(function() {
                    $("#Routine-Search-Reasult").slideDown("slow");
                });
            },
            error: function(xhr) {
                $("#Routine-Search-Reasult").empty();
                $.each(xhr.responseJSON.errors, function(key, item) {
                    if ($.isArray(item)) {
                        $.each(item, function(key, value) {
                            createToast("danger", "ERROR", value);
                        });
                    } else {
                        createToast("danger", "ERROR", item);
                    }
                });
            }
        });
    });
});

// Download Routine PDF
$("body").on("click", ".download-routine-pdf", function() {
    var sessionId = $(this).data("session");
    var departmentId = $(this).data("department");
    var batchId = $(this).data("batch");
    var sectionId = $(this).data("section");

    var link =
        "/routine/download/pdf/" +
        sessionId +
        "/" +
        departmentId +
        "/" +
        batchId +
        "/" +
        sectionId;

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $.ajax({
        type: "GET",
        url: link,
        success: function(response) {
            window.open(link, "_blank");
            createToast("info", "Success", "PDF Downloaded.");
        },
        error: function(response) {
            console.log("Error:", response);
        }
    });
});

// Clear Routine Table
$("body").on("click", ".clear-routine-table", function() {
    $("#Routine-Search-Reasult").slideUp("slow", function() {
        $("#Routine-Search-Reasult").empty();
    });
});
