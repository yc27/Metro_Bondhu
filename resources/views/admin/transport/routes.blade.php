<!-- Routes Tab -->
<div class="row">
    <div class="col-12 col-md-6 col-lg-7 pr-md-1">
        <button id="Btn-Create-Route" class="btn btn-block blue-gradient mx-0 my-4 fa-lg" data-toggle="modal" data-target="#Modal-Add-Route">
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
    </div>
    <div class="col-12 col-md-6 col-lg-5 py-4 pl-md-1">
        <div id="map-routes"></div>
    </div>
</div>

<!-- Add Route Modal -->
<div class="modal fade bottom" id="Modal-Add-Route" tabindex="-1" role="dialog" aria-labelledby="Add-Route-Modal-Label" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-notify modal-info" role="document">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h4 class="modal-title w-100 text-center font-weight-bold" id="Add-Route-Modal-Label">Add New Route</h4>
                <button type="button" class="close" id="Btn-Form-Route-Close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="container-fluid">
                    <form id="Form-Route" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="row">
                                    <div class="col-12 col-lg-6 pr-lg-1">
                                        <label><strong>Starting Point:</strong></label>
                                        <div id="geocoder-start" class="mb-2"></div>

                                        <div class="row">
                                            <div class="col-6 pr-1">
                                                <label>Lattitude:</label>
                                                <input type="text" class="form-control form-control-sm mb-2" name="start-lat" id="start-lat">
                                            </div>

                                            <div class="col-6 pl-1">
                                                <label>Longitude:</label>
                                                <input type="text" class="form-control form-control-sm mb-3" name="start-lng" id="start-lng">
                                            </div>
                                        </div>

                                        <button class="btn btn-sm btn-block btn-success btn-start-point">Add Start Point</button>
                                    </div>

                                    <div class="col-12 col-lg-6 pl-lg-1 pt-3 pt-lg-0">
                                        <label><strong>Ending Point:</strong></label>
                                        <div id="geocoder-end" class="mb-2"></div>

                                        <div class="row">
                                            <div class="col-6 pr-1">
                                                <label>Lattitude:</label>
                                                <input type="text" class="form-control form-control-sm mb-2" name="end-lat" id="end-lat">
                                            </div>

                                            <div class="col-6 pl-1">
                                                <label>Longitude:</label>
                                                <input type="text" class="form-control form-control-sm mb-3" name="end-lng" id="end-lng">
                                            </div>
                                        </div>

                                        <button class="btn btn-sm btn-block btn-danger btn-end-point">Add End Point</button>
                                    </div>
                                </div>

                                <hr class="w-100">

                                <div class="row">
                                    <div class="col-12 col-lg-6 pr-lg-1">
                                        <label><strong>Way Point:</strong></label>
                                        <div id="geocoder-waypoint" class="mb-2"></div>

                                        <div class="row">
                                            <div class="col-6 pr-1">
                                                <label>Lattitude:</label>
                                                <input type="text" class="form-control form-control-sm mb-2" name="waypoint-lat" id="waypoint-lat">
                                            </div>
                                            <div class="col-6 pl-1">
                                                <label>Longitude:</label>
                                                <input type="text" class="form-control form-control-sm mb-3" name="waypoint-lng" id="waypoint-lng">
                                            </div>
                                        </div>

                                        <button class="btn btn-sm btn-block btn-primary btn-way-point">Add Waypoint</button>
                                    </div>
                                    <div class="col-12 col-lg-6 pl-lg-1 pt-3 pt-lg-0 d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="mb-0"><strong>Coordinates:</strong></label>
                                            <i class="fas fa-times text-danger clear-waypoints"></i>
                                        </div>
                                        <textarea class="form-control form-control-sm h-100" id="coordinates" name="waypoints" readonly></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6 pt-3 pt-lg-0 d-flex flex-column">
                                <p class="note note-primary text-dark"><strong>Tip:</strong> To add a point click on the map or enter lattitude and longitude and click add button.</p>

                                <div id="map-canvas"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer justify-content-end py-0">
                <button class="btn btn-indigo text-white" id="Btn-Draw-Route">
                    Draw Route
                </button>

                <button class="btn btn-mdb-color text-white" id="Btn-Save-Route">
                    Save Route
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Add Route Modal -->

<!-- Route Delete Modal -->
<div id="Modal-Route-Delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal-Route-Delete-Label" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-danger" role="document">
        <div class="modal-content text-dark" style="font-size: 14px">
            <div class="modal-header">
                <p class="heading lead" id="Modal-Route-Delete-Label">Confirme Delete?</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this route?
                    <br><br>
                    <div class="text-danger">This action cannot be undone.</div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" id="Btn-Delete-Route" class="btn btn-danger btn-sm" data-dismiss="modal">Delete</button>
                <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- /Route Delete Modal -->
<!-- /Routes Tab -->

@section('script')
@parent
<script>
    mapboxgl.accessToken = "{{ config('services.mapbox.token') }}";

    var mapRoutes = new mapboxgl.Map({
        container: 'map-routes',
        style: 'mapbox://styles/yeamin/ckbxg69ca0fpt1is0u3hwl1yn',
        center: [91.86880624578957, 24.894808641185534],
        zoom: 12
    });

    var navRoutes = new mapboxgl.NavigationControl({
        showCompass: false
    });
    mapRoutes.addControl(navRoutes, 'top-right');

    var mapCanvas = new mapboxgl.Map({
        container: 'map-canvas',
        style: 'mapbox://styles/yeamin/ckbxg69ca0fpt1is0u3hwl1yn',
        center: [91.86880624578957, 24.894808641185534],
        zoom: 13
    });

    var navCanvas = new mapboxgl.NavigationControl({
        showCompass: false
    });
    mapCanvas.addControl(navCanvas, 'top-left');
</script>
<script type="text/javascript" src={{ asset('js/routes.js') }}></script>
@endsection
