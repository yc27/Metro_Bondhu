// Datatable
routesTable = $("#Routes-Table").DataTable({
    autoWidth: true,
    bAutoWidth: true,
    scrollX: true,
    processing: true,
    serverSide: true,
    order: [[1, "asc"]],
    pagingType: "full_numbers",
    ajax: {
        url: "/transport/show/routes"
    },
    columns: [
        { data: "id", name: "id" },
        {
            render: function(data, type, row) {
                return "(" + row.source_lng + ", " + row.source_lat + ")";
            }
        },
        {
            render: function(data, type, row) {
                return (
                    "(" + row.destination_lng + ", " + row.destination_lat + ")"
                );
            }
        },
        { data: "way_points", name: "way_points" }
    ],
    columnDefs: [
        {
            targets: 0,
            visible: false,
            searchable: false
        },
        {
            targets: 4,
            render: function(data, type, row, meta) {
                return (
                    '<button type="button" class="delete-route btn btn-sm btn-danger px-2" data-toggle="modal" data-target="#Modal-Route-Delete" data-id="' +
                    row.id +
                    '"><i class="fas fa-trash-alt"></i></button>'
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

mapRoutes.on("load", function() {
    mapRoutes.resize();
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

            getDirection(coords, route["id"], mapRoutes);
        });
    });
});

var mapActivePoint = "";

// start point marker
var startMarker = new mapboxgl.Marker({
    color: "green",
    draggable: true
}).on("dragend", function() {
    var lngLat = this.getLngLat();

    $("#start-lat").val(lngLat.lat);
    $("#start-lng").val(lngLat.lng);
});

// end point marker
var endMarker = new mapboxgl.Marker({
    color: "red",
    draggable: true
}).on("dragend", function() {
    var lngLat = this.getLngLat();

    $("#end-lat").val(lngLat.lat);
    $("#end-lng").val(lngLat.lng);
});

// way point marker
var wayPoints = [];
var waypointMarker;
var waypointMarkerList = [];

// geocoder start-point
var startGeocoder = new MapboxGeocoder({
    accessToken: mapboxgl.accessToken,
    countries: "bd",
    mapboxgl: mapboxgl,
    marker: false
});
document
    .getElementById("geocoder-start")
    .appendChild(startGeocoder.onAdd(mapCanvas));

// geocoder end-point
var endGeocoder = new MapboxGeocoder({
    accessToken: mapboxgl.accessToken,
    countries: "bd",
    mapboxgl: mapboxgl,
    marker: false
});
document
    .getElementById("geocoder-end")
    .appendChild(endGeocoder.onAdd(mapCanvas));

// geocoder way-point
var waypointGeocoder = new MapboxGeocoder({
    accessToken: mapboxgl.accessToken,
    countries: "bd",
    mapboxgl: mapboxgl,
    marker: false
});
document
    .getElementById("geocoder-waypoint")
    .appendChild(waypointGeocoder.onAdd(mapCanvas));

mapCanvas.on("load", function() {
    startGeocoder.on("result", function(ev) {
        var [lng, lat] = ev.result.center;

        setStartMarker(lat, lng);        
        setMapActivePointStart();
    });

    endGeocoder.on("result", function(ev) {
        var [lng, lat] = ev.result.center;

        setEndMarker(lat, lng);
        setMapActivePointEnd();
    });

    waypointGeocoder.on("result", function(ev) {
        var [lng, lat] = ev.result.center;

        $("#waypoint-lat").val(lat);
        $("#waypoint-lng").val(lng);

        if (waypointMarker) {
            waypointMarker.remove();
            waypointMarker.setLngLat([lng, lat]).addTo(mapCanvas);
        } else {
            waypointMarker = new mapboxgl.Marker({
                draggable: true
            })
                .setLngLat([lng, lat])
                .on("dragend", function() {
                    var lngLat = this.getLngLat();

                    $("#waypoint-lat").val(lngLat.lat);
                    $("#waypoint-lng").val(lngLat.lng);
                })
                .addTo(mapCanvas);
        }

        setMapActivePointWaypoint();
    });
});

mapCanvas.on("click", function(e) {
    e.preventDefault();

    if (mapActivePoint === "start-point") {
        var lat = e.lngLat["lat"];
        var lng = e.lngLat["lng"];

        $("#start-lat").val(lat);
        $("#start-lng").val(lng);

        startMarker.remove();
        startMarker.setLngLat([lng, lat]).addTo(mapCanvas);
        startMarker.setDraggable(true);
    } else if (mapActivePoint === "end-point") {
        var lat = e.lngLat["lat"];
        var lng = e.lngLat["lng"];

        $("#end-lat").val(lat);
        $("#end-lng").val(lng);

        endMarker.remove();
        endMarker.setLngLat([lng, lat]).addTo(mapCanvas);
        endMarker.setDraggable(true);
    } else if (mapActivePoint === "way-point") {
        var lat = e.lngLat["lat"];
        var lng = e.lngLat["lng"];

        $("#waypoint-lat").val(lat);
        $("#waypoint-lng").val(lng);

        if (typeof waypointMarker === "undefined" || !waypointMarker) {
            waypointMarker = new mapboxgl.Marker({
                draggable: true
            })
                .setLngLat([lng, lat])
                .on("dragend", function() {
                    var lngLat = this.getLngLat();

                    $("#waypoint-lat").val(lngLat.lat);
                    $("#waypoint-lng").val(lngLat.lng);
                })
                .addTo(mapCanvas);
        } else {
            waypointMarker.remove();
            waypointMarker.setLngLat([lng, lat]).addTo(mapCanvas);
            waypointMarker.setDraggable(true);
        }
    }
});

function clearMapActivePoint() {
    if (mapActivePoint === "start-point") {
        $(".btn-start-point").data("state", "");
        $(".btn-start-point").text("Add Start Point");
        $(".btn-start-point")
            .removeClass("btn-warning")
            .addClass("btn-success");

        startMarker.setDraggable(false);
    } else if (mapActivePoint === "end-point") {
        $(".btn-end-point").data("state", "");
        $(".btn-end-point").text("Add End Point");
        $(".btn-end-point")
            .removeClass("btn-warning")
            .addClass("btn-danger");

        endMarker.setDraggable(false);
    } else if (mapActivePoint === "way-point") {
        $(".btn-way-point").data("state", "");
        $(".btn-way-point").text("Add Waypoint");
        $(".btn-way-point")
            .removeClass("btn-warning")
            .addClass("btn-primary");
    }

    mapActivePoint = "";
}

function setMapActivePointStart() {
    clearMapActivePoint();
    
    $(".btn-start-point").data("state", "confirm");
    $(".btn-start-point").text("Confirm");
    $(".btn-start-point")
        .removeClass("btn-success")
        .addClass("btn-warning");
    
    startMarker.setDraggable(true);
    mapActivePoint = "start-point";
}

function setMapActivePointEnd() {
    clearMapActivePoint();

    $(".btn-end-point").data("state", "confirm");
    $(".btn-end-point").text("Confirm");
    $(".btn-end-point")
        .removeClass("btn-danger")
        .addClass("btn-warning");
    
    endMarker.setDraggable(true);
    mapActivePoint = "end-point";
}

function setMapActivePointWaypoint() {
    clearMapActivePoint();

    $(".btn-way-point").data("state", "confirm");
    $(".btn-way-point").text("Confirm");
    $(".btn-way-point")
        .removeClass("btn-primary")
        .addClass("btn-warning");
    
    mapActivePoint = "way-point";
}

function verifyLatLng(lat, lng) {
    if (!lat || !lng) {
        createToast(
            "warning",
            "NOTE",
            "Lattitude & Longitude can not be empty. Click on the map to add a point"
        );
        return false;
    }

    if (lat < -90 || lat > 90) {
        createToast(
            "danger",
            "ERROR",
            "Lattitude should be between -90 and 90."
        );
        return false;
    }

    if (lng < -180 || lng > 180) {
        createToast(
            "danger",
            "ERROR",
            "Longitude should be between -180 and 180."
        );
        return false;
    }

    return true;
}

function setStartMarker(lat, lng) {
    var deferred = new $.Deferred();

    if (verifyLatLng(lat, lng) === true) {
        $("#start-lat").val(lat);
        $("#start-lng").val(lng);

        startMarker.remove();
        startMarker.setLngLat([lng, lat]).addTo(mapCanvas);
        startMarker.setDraggable(true);

        mapCanvas.flyTo({
            center: [lng, lat],
            essential: true
        });

        deferred.resolve();
    } else {
        deferred.reject();
    }

    return deferred.promise();
}

function setEndMarker(lat, lng) {
    var deferred = new $.Deferred();

    if (verifyLatLng(lat, lng) === true) {
        $("#end-lat").val(lat);
        $("#end-lng").val(lng);

        endMarker.remove();
        endMarker.setLngLat([lng, lat]).addTo(mapCanvas);
        endMarker.setDraggable(true);

        mapCanvas.flyTo({
            center: [lng, lat],
            essential: true
        });

        deferred.resolve();
    } else {
        deferred.reject();
    }

    return deferred.promise();
}

function getDirection(coordinates, id = 0, mapD) {
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
        drawRoute(coords, "route-" + id, mapD);
    };

    req.send();
}

function drawRoute(coords, layer = "route", mapD) {
    if (mapD.getSource(layer)) {
        mapD.removeLayer(layer);
        mapD.removeSource(layer);
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

    mapD.addLayer({
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
    mapD.resize();
}

function removeRoute(layer = "route", mapD) {
    if (mapD.getSource(layer)) {
        mapD.removeLayer(layer);
        mapD.removeSource(layer);
    } else {
        return;
    }
}

$(".btn-start-point").click(function(e) {
    e.preventDefault();

    var lat = $("#start-lat").val();
    var lng = $("#start-lng").val();

    if ($(this).data("state") === "confirm") {
        setStartMarker(lat, lng).done(function () {
            clearMapActivePoint();
        });
    } else {
        clearMapActivePoint();
        setMapActivePointStart()
        setStartMarker(lat, lng);
    }
});

$(".btn-end-point").click(function(e) {
    e.preventDefault();

    var lat = $("#end-lat").val();
    var lng = $("#end-lng").val();

    if ($(this).data("state") === "confirm") {
        setEndMarker(lat, lng).done(function () {
            clearMapActivePoint();
        });
    } else {
        clearMapActivePoint();
        setMapActivePointEnd();
        setEndMarker(lat, lng);
    }
});

$(".btn-way-point").click(function(e) {
    e.preventDefault();

    var lat = $("#waypoint-lat").val();
    var lng = $("#waypoint-lng").val();

    if ($(this).data("state") === "confirm") {
        if (verifyLatLng(lat, lng) === true) {
            waypointMarker.remove();
            waypointMarker.setLngLat([lng, lat]).addTo(mapCanvas);
            waypointMarker.setDraggable(false);
            waypointMarkerList.push(waypointMarker);
            waypointMarker = null;

            mapCanvas.flyTo({
                center: [lng, lat],
                essential: true
            });

            wayPoints.push([lng, lat]);

            var coordinates = "";
            $.each(wayPoints, function(index, point) {
                coordinates += point[0] + ", " + point[1] + ";";
            });
            $("#coordinates").val(coordinates);

            $("#waypoint-lat").val("");
            $("#waypoint-lng").val("");

            clearMapActivePoint();
        }
    } else {
        clearMapActivePoint();
        setMapActivePointWaypoint();

        if (verifyLatLng(lat, lng) === true) {
            waypointMarker = new mapboxgl.Marker({
                draggable: true
            })
                .setLngLat([lng, lat])
                .on("dragend", function() {
                    var lngLat = this.getLngLat();

                    $("#waypoint-lat").val(lngLat.lat);
                    $("#waypoint-lng").val(lngLat.lng);
                })
                .addTo(mapCanvas);

            mapCanvas.flyTo({
                center: [lng, lat],
                essential: true
            });
        }
    }
});

$("#Btn-Create-Route").click(function(e) {
    e.preventDefault();

    setTimeout(() => {
        mapCanvas.resize();
    }, 250);
});

$("#Btn-Draw-Route").click(function (e) {
    e.preventDefault();

    if (verifyLatLng($("#start-lat").val(), $("#start-lng").val()) === false) {
        return;
    }
    
    if (verifyLatLng($("#end-lat").val(), $("#end-lng").val()) === false) {
        return;
    }

    var startCoords = $("#start-lng").val() + "," + $("#start-lat").val();
    var endCoords = $("#end-lng").val() + "," + $("#end-lat").val();

    var coords = wayPoints.join(";");
    coords += coords.length > 0 ? ";" : "";

    getDirection(startCoords + ";" + coords + endCoords, "0", mapCanvas);
});

$("#Btn-Save-Route").click(function(e) {
    e.preventDefault();

    if (verifyLatLng($("#start-lat").val(), $("#start-lng").val()) === false) {
        return;
    }

    if (verifyLatLng($("#end-lat").val(), $("#end-lng").val()) === false) {
        return;
    }

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        type: "POST",
        url: "/transport/store/route",
        data: $("#Form-Route").serialize(),

        success: function(response) {
            $("#Btn-Form-Route-Close").click();
            $("#Form-Route").trigger("reset");

            clearMapActivePoint();
            removeRoute("route-0", mapCanvas);

            wayPoints.splice(0, wayPoints.length);

            if (waypointMarker) {
                waypointMarker.remove();
            }
            $.each(waypointMarkerList, function(index, marker) {
                marker.remove();
            });
            startMarker.remove();
            endMarker.remove();

            routesTable.ajax.reload();
            routesTable.columns.adjust().draw();

            var start =
                response.data["source_lng"] + "," + response.data["source_lat"];
            var end =
                response.data["destination_lng"] +
                "," +
                response.data["destination_lat"];

            var coords = response.data["way_points"];
            coords += coords == null ? "" : ";";

            coords =
                start +
                ";" +
                (coords == "null" || coords == null ? "" : coords) +
                end;

            getDirection(coords, response.data["id"], mapRoutes);
            createToast("success", "Success", response.msg);
        },

        error: function(xhr) {
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

$("body").on("click", "#Btn-Delete-Route", function() {
    var id = $(this).data("id");

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $.ajax({
        type: "delete",
        url: "/transport/delete/route/" + id,
        success: function(data) {
            $("#Route-Id-" + id).remove();
            removeRoute("route-" + id, mapRoutes);
            createToast("danger", "Success", "Route deleted successfully.");
        },
        error: function(data) {
            console.log("Error:", data);
        }
    });
});
$("body").on("click", ".delete-route", function() {
    $("#Btn-Delete-Route").data("id", $(this).data("id"));
});
