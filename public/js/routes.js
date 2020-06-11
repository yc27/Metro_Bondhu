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
            data: "source",
            name: "source",
            render: function(data, type, row) {
                return "(" + row.source_lat + ", " + row.source_lng + ")";
            }
        },
        {
            data: "destination",
            name: "destination",
            render: function(data, type, row) {
                return (
                    "(" + row.destination_lat + ", " + row.destination_lng + ")"
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
                    '<button type="button" class="delete-schedule btn btn-sm btn-danger" data-toggle="modal" data-target="#Modal-Schedule-Delete" data-id="' +
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

var mapProp, map, mapClickHandler, markerDragHandler, markerDragendHandler;

var startMarker = new google.maps.Marker({
    icon: {
        url: "img/StartMarker.png",
        scaledSize: new google.maps.Size(40, 60)
    },
    animation: google.maps.Animation.DROP
});

var endMarker = new google.maps.Marker({
    icon: {
        url: "img/EndMarker.png",
        scaledSize: new google.maps.Size(40, 60)
    },
    animation: google.maps.Animation.DROP
});

var waypointsMarker = new google.maps.Marker({
    icon: {
        url: "img/StoppageMarker.png",
        scaledSize: new google.maps.Size(40, 60)
    },
    animation: google.maps.Animation.DROP
});

const btnSetStart = document.getElementById("Btn-Set-Start");
const btnSetEnd = document.getElementById("Btn-Set-End");
const btnAddWayPoints = document.getElementById("Btn-Add-WayPoints");

btnSetStart.addEventListener("click", activateSetStart);
btnSetEnd.addEventListener("click", activateSetEnd);
btnAddWayPoints.addEventListener("click", activateSetWaypoint);

function geocodeLatLng(lat, lng) {
    var latlng = {
        lat: lat,
        lng: lng
    };

    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({ location: latlng }, function(results, status) {
        if (status === "OK") {
            if (results[0]) {
                map.setZoom(11);
                console.log(results[0].formatted_address);
            } else {
                console.log("No results found");
            }
        } else {
            console.log("Geocoder failed due to: " + status);
		}
    });
}

function handleEvent(event, input) {
    $(input).val(event.latLng);
}

// Set Starting Point
function activateSetStart() {
    deactivateSetEnd();
    deactivateSetWaypoint();
    btnSetStart.innerText = "Confirm";
    btnSetStart.className = btnSetStart.className.replace("blue", "green");
    btnSetStart.removeEventListener("click", activateSetStart);
    btnSetStart.addEventListener("click", deactivateSetStart);

    startMarker.setOptions({ draggable: true });

    mapClickHandler = map.addListener("click", function(event) {
        startMarker.setPosition(event.latLng);
        startMarker.setMap(map);
        handleEvent(event, "#Start-Point");
        geocodeLatLng(event.latLng.lat(), event.latLng.lng());
    });

    markerDragHandler = startMarker.addListener("drag", function(event) {
        handleEvent(event, "#Start-Point");
    });

    markerDragendHandler = startMarker.addListener("dragend", function(event) {
        handleEvent(event, "#Start-Point");
    });
}
function deactivateSetStart() {
    btnSetStart.innerText = "Set Start Point";
    btnSetStart.className = btnSetStart.className.replace("green", "blue");
    btnSetStart.removeEventListener("click", deactivateSetStart);
    btnSetStart.addEventListener("click", activateSetStart);

    startMarker.setOptions({ draggable: false });
    google.maps.event.removeListener(mapClickHandler);
    google.maps.event.removeListener(markerDragHandler);
    google.maps.event.removeListener(markerDragendHandler);
}

// Set Ending Point
function activateSetEnd() {
    deactivateSetStart();
    deactivateSetWaypoint();
    btnSetEnd.innerText = "Confirm";
    btnSetEnd.className = btnSetEnd.className.replace("blue", "green");
    btnSetEnd.removeEventListener("click", activateSetEnd);
    btnSetEnd.addEventListener("click", deactivateSetEnd);

    endMarker.setOptions({ draggable: true });

    mapClickHandler = map.addListener("click", function(event) {
        endMarker.setPosition(event.latLng);
        endMarker.setMap(map);
        handleEvent(event, "#End-Point");
    });

    markerDragHandler = endMarker.addListener("drag", function(event) {
        handleEvent(event, "#End-Point");
	});
	
    markerDragendHandler = endMarker.addListener("dragend", function(event) {
        handleEvent(event, "#End-Point");
    });
}
function deactivateSetEnd() {
    btnSetEnd.innerText = "Set End Point";
    btnSetEnd.className = btnSetEnd.className.replace("green", "blue");
    btnSetEnd.removeEventListener("click", deactivateSetEnd);
    btnSetEnd.addEventListener("click", activateSetEnd);

    endMarker.setOptions({ draggable: false });
    google.maps.event.removeListener(mapClickHandler);
    google.maps.event.removeListener(markerDragHandler);
    google.maps.event.removeListener(markerDragendHandler);
}

// Add Waypoints
function activateSetWaypoint() {
    deactivateSetStart();
    deactivateSetEnd();
    btnAddWayPoints.innerText = "Confirm";
    btnAddWayPoints.className = btnAddWayPoints.className.replace(
        "blue",
        "orange"
    );
    btnAddWayPoints.removeEventListener("click", activateSetWaypoint);
    btnAddWayPoints.addEventListener("click", deactivateSetWaypoint);

    waypointsMarker.setOptions({ draggable: true });

    mapClickHandler = map.addListener("click", function(event) {
        waypointsMarker.setPosition(event.latLng);
        waypointsMarker.setMap(map);
    });
}
function deactivateSetWaypoint() {
    btnAddWayPoints.innerText = "Add Stoppage";
    btnAddWayPoints.className = btnAddWayPoints.className.replace(
        "orange",
        "blue"
    );
    btnAddWayPoints.removeEventListener("click", deactivateSetWaypoint);
    btnAddWayPoints.addEventListener("click", activateSetWaypoint);

    waypointsMarker.setOptions({ draggable: false });
    google.maps.event.removeListener(mapClickHandler);
}

$("#Btn-Set-Route").click(function () {
	var directionsDisplay = new google.maps.DirectionsRenderer();
	var directionsService = new google.maps.DirectionsService();

	directionsDisplay.setMap(map);

	var route = {
        origin: $("#Start-Point").val(),
		destination: $("#End-Point").val(),
		travelMode: "DRIVING"
	};
	
	directionsService.route(route, function(result, status) {
		if (status === "OK") {
			directionsDisplay.setDirections(result);
		}
    });
});