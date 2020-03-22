<!-- Routes Tab -->
<button id="Btn-Create-Schedule" class="btn btn-block blue-gradient mx-0 my-4 fa-lg" data-toggle="modal" data-target="#Modal-Add-Route">
	<i class="fas fa-plus-circle mr-2"></i>
	Add Route
</button>

<div class="border border-dark rounded p-2 mt-4">
    <table class="table table-striped text-center w-100" id="Routes-Table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Source</th>
                <th>Destination</th>
                <th>Stoppages</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<!-- Add Route Modal -->
<div class="modal fade bottom" id="Modal-Add-Route" tabindex="-1" role="dialog" aria-labelledby="Add-Route-Modal-Label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-notify modal-info" role="document">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h4 class="modal-title w-100 text-center font-weight-bold" id="Add-Route-Modal-Label">Add New Route</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body p-2">
                <div class="container">
                    {{-- <form> --}}
                    <div class="row mb-2">
                        <div class="col-lg-6 p-1">
                            <div class="row my-1 mx-0 align-items-center border rounded">
                                <div class="col-md-5 p-2">
                                    <button class="btn btn-sm btn-block blue text-white" id="Btn-Set-Start">
                                        Set Start Point
                                    </button>
                                </div>
                                <div class="col-md-7 p-2">
                                    <textarea rows="1" wrap="off" class="form-control" type="text" id="Start-Point" name="end-point" style="resize: none; overflow-y: hidden" readonly>
                                    </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 p-1">
                            <div class="row my-1 mx-0 align-items-center border rounded">
                                <div class="col-md-5 p-2">
                                    <button class="btn btn-sm btn-block blue text-white" id="Btn-Set-End">
                                        Set End Point
                                    </button>
                                </div>
                                <div class="col-md-7 p-2">
                                    <textarea rows="1" wrap="off" class="form-control" type="text" id="End-Point" name="end-point" style="resize: none; overflow-y: hidden" readonly>
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col p-1">
                            <div class="row mx-0 border rounded">
                                <div class="col p-2">
                                    <button class="btn btn-sm btn-block blue lighten-1 text-white" id="Btn-Add-WayPoints">
                                        Add Stoppage
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- </form> --}}

                    <div id="map-canvas" style="width:100%; height: 300px; border: 2px solid #056af7; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"></div>
                </div>
            </div>

            <div class="modal-footer justify-content-center">
                <button class="btn btn-block indigo text-white" id="Btn-Set-Route">
                    Set Route
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Add Route Modal -->

<script>
	function myMap() {
		window.mapProp = {
			center: new google.maps.LatLng(24.894808641185534, 91.86880624578957),
			zoom: 15
		};

		window.map = new google.maps.Map(
			document.getElementById("map-canvas"),
			mapProp
		);
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.key') }}&callback=myMap"></script>
{{-- <script src="https://maps.googleapis.com/maps/api/js?key=&callback=myMap"></script> --}}

{{-- <script>
    window.lat = 24.8839623;
    window.lng = 91.8960201;

    var map;
    var mark;
    var lineCoords = [];

    var initialize = function() {
        map = new google.maps.Map(document.getElementById('map-canvas'), {
            center: {
				lat: lat,
				lng: lng
            },
			zoom: 18
        });
        mark = new google.maps.Marker({
            position: {
				lat: lat,
				lng: lng
			},
			map: map
        });
    };

    window.initialize = initialize;

    var redraw = function(payload) {
        if (payload.message.lat) {
            lat = payload.message.lat;
            lng = payload.message.lng;

            map.setCenter({
				lat: lat,
				lng: lng,
				alt: 0
            });
            mark.setPosition({
				lat: lat,
				lng: lng,
				alt: 0
            });

            lineCoords.push(new google.maps.LatLng(lat, lng));

            var lineCoordinatesPath = new google.maps.Polyline({
				path: lineCoords,
				geodesic: true,
				strokeColor: '#2E10FF'
            });

            lineCoordinatesPath.setMap(map);
        }
    };

    var pnChannel = "metro-guide";

    var pubnub = new PubNub({
		publishKey: 'pub-c-e167a8fc-a116-4be4-b4b5-92696eff0260',
		subscribeKey: 'sub-c-60d3cbba-6477-11ea-aaa3-eab2515ceb0d'
    });

    document.querySelector('#action').addEventListener('click', function() {
        var text = document.getElementById("action").textContent;
        if (text == "Start Tracking") {
            pubnub.subscribe({
                channels: [pnChannel]
            });
            pubnub.addListener({
                message: redraw
            });
            document.getElementById("action").classList.add('btn-danger');
            document.getElementById("action").classList.remove('btn-success');
            document.getElementById("action").textContent = 'Stop Tracking';
        } else {
            pubnub.unsubscribe({
                channels: [pnChannel]
            });
            document.getElementById("action").classList.remove('btn-danger');
            document.getElementById("action").classList.add('btn-success');
            document.getElementById("action").textContent = 'Start Tracking';
        }
	});
</script> --}}

<!-- DataTable Script -->
<script type="text/javascript" src={{ asset('js/routes.js') }}></script>
<!-- /Routes Tab -->