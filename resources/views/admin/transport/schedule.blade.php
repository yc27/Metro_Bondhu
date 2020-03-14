<!-- Schedules Tab -->
<button class="btn btn-block blue-gradient mx-0 my-4 fa-lg" data-toggle="modal" data-target="#Modal-AddSchedule-Form">
	<i class="fas fa-plus-circle mr-2"></i>
	Add Bus Schedule
</button>

<div class="alert alert-success d-none" id="Create-Schedule-Success">
    <span id="Create-Schedule-Success-Message"></span>
</div>

<div class="border border-dark rounded p-2">
    <table class="table table-striped text-center w-100" id="Schedule-Table">
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

<!-- Add Schedule Modal -->
<div class="modal fade" id="Modal-AddSchedule-Form" tabindex="-1" role="dialog" aria-labelledby="Modal-AddSchedule-Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Create Bus Schedule</h4>
                <button type="button" id="Btn-Close-Schedule-Form" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="Form-Create-Schedule" method="post" action="javascript:void(0)" enctype="multipart/form-data">
                @csrf
                <div class="modal-body mx-3 pb-0">
                        <div class="alert alert-danger d-none" id="Create-Schedule-Error">
                            <ul id="Create-Schedule-Error-Message"></ul>
                        </div>
                        
                        <label for="Source">Source Place</label>
                        <input type="text" name="source" id="Source" class="form-control mb-4" placeholder="From where journy will start">

                        <label for="Destination">Destination Place</label>
                        <input type="text" name="destination" id="Destination" class="form-control mb-4" placeholder="From where journy will end">

                        <label for="Start-Time">Start Time</label>
                        <input type="time" name="starts_at" id="Start-Time" class="form-control mb-4">

                        <label>Stoppages</label>
                        <button id="Btn-Add-Stoppage" class="btn btn-success btn-sm btn-block m-0 mb-4" type="button">Add Stoppage</button>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button id="Btn-Create-Schedule" class="btn btn-default btn-block" type="submit">Create Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Schedules Tab -->