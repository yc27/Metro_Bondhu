<!-- Schedules Tab -->
<button id="Btn-Create-Schedule" class="btn btn-block blue-gradient mx-0 my-4 fa-lg" data-toggle="modal" data-target="#Modal-Schedule-Form">
    <i class="fas fa-plus-circle mr-2"></i>
    Add Bus Schedule
</button>

<div class="alert alert-success d-none" id="Schedule-Success">
    <span id="Schedule-Success-Message"></span>
</div>

<div class="border border-dark rounded p-2">
    <table class="table table-striped text-center w-100" id="Schedules-Table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Starting Time</th>
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

<!-- Schedule Form Modal -->
<div class="modal fade" id="Modal-Schedule-Form" tabindex="-1" role="dialog" aria-labelledby="Modal-Schedule-Label" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-info" role="document">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h4 id="Modal-Bus-Schedule-Title" class="modal-title w-100 text-center font-weight-bold"></h4>
                <button type="button" id="Btn-Close-Schedule-Form" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <form id="Form-Schedule" method="post" action="javascript:void(0)" enctype="multipart/form-data">
                @csrf
                <div class="modal-body mx-3 pb-0">
                        <div class="alert alert-danger d-none" id="Form-Schedule-Error">
                            <ul id="Form-Schedule-Error-Message"></ul>
                        </div>
                        
                        <input type="hidden" id="Schedule-Id" name="schedule-id">
                        <label for="Source">Source Place</label>
                        <input type="text" name="source" id="Source" class="form-control mb-4" placeholder="From where journy will start">

                        <label for="Destination">Destination Place</label>
                        <input type="text" name="destination" id="Destination" class="form-control mb-4" placeholder="From where journy will end">

                        <label for="Start-Time">Start Time</label>
                        <input type="time" name="starts_at" id="Start-Time" class="form-control mb-4">

                        <label>Stoppages</label>
                        <button id="Btn-Add-Stoppage" class="btn btn-mdb-color btn-sm btn-block m-0 mb-4" type="button">Add Stoppage</button>
                        <div id="Clone-Stoppage" class="d-none"></div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button id="Btn-Form-Schedule" class="btn btn-indigo btn-block" type="submit"></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Schedule Form Modal -->

<!-- Schedule Delete Modal -->
<div id="Modal-Schedule-Delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal-Schedule-Delete-Label" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-danger" role="document">
        <div class="modal-content text-dark" style="font-size: 14px">
            <div class="modal-header">
                <p class="heading lead" id="Modal-Schedule-Delete-Label">Confirme Delete?</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this schedule?
                    <br><br>
                    <div class="text-danger">This action cannot be undone.</div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" id="Btn-Delete-Schedule" class="btn btn-danger btn-sm" data-dismiss="modal">Delete</button>
                <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- /Schedule Delete Modal -->
<!-- /Schedules Tab -->

@section('script')
@parent
<script type="text/javascript" src={{ asset('js/schedule.js') }}></script>
@endsection