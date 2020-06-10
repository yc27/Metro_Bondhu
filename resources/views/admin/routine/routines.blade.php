<div id="Routines" style="display: none;">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="lead">Routines</div>
        </div>
        <div class="card-body">
            <div class="container">
                <form id="Form-Routine-Search">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-danger d-none" id="Form-Routine-Search-Error">
                                <ul id="Form-Routine-Search-Error-Message"></ul>
                            </div>
                        </div>

                        <div class="col-12 col-lg-10">
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-3">
                                    Session:
                                    <select class="Select-Session browser-default custom-select" name="session"></select>
                                </div>

                                <div class="col-12 col-sm-6 col-md-3 pt-2 pt-sm-0">
                                    Department:
                                    <select class="Select-Department browser-default custom-select" name="department"></select>
                                </div>

                                <div class="col-12 col-sm-6 col-md-3 pt-2 pt-md-0">
                                    Batch:
                                    <select class="Select-Batch browser-default custom-select" name="batch"></select>
                                </div>

                                <div class="col-12 col-sm-6 col-md-3 pt-2 pt-md-0">
                                    Section:
                                    <select class="Select-Section browser-default custom-select" name="section"></select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-2 pt-2 pt-lg-0 align-self-end" style="height: calc(1.5em + .75rem + 2px);">
                            <input type="submit" id="Btn-Routine-Search" class="btn btn-sm btn-block btn-success h-100" style="font-size: 0.8rem;" value="Search">
                        </div>
                    </div>
                </form>
                <div id="Routine-Search-Reasult"></div>
            </div>
        </div>
    </div>
</div>

<!-- Create-Routine Form Modal -->
<div class="modal fade" id="Modal-Create-Routine-Form" tabindex="-1" role="dialog" aria-labelledby="Modal-Create-Routine-Label" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header primary-color-dark text-white">
                <h4 class="modal-title w-100 text-center">Create Routine</h4>
            </div>
            <form id="Form-Create-Routine">
                <div class="modal-body mx-3 pb-0">
                    <div class="alert alert-danger d-none" id="Form-Create-Routine-Error">
                        <ul id="Form-Create-Routine-Error-Message"></ul>
                    </div>

                    <input type="hidden" id="Day-Id" name="day">
                    <input type="hidden" id="Period-Id" name="period">
                    <input type="hidden" id="Section-Id" name="section">
                    <input type="hidden" id="Session-Id" name="session">

                    <label>Subject</label>
                    <select class="Select-Subject browser-default custom-select mb-4" name="subject"></select>

                    <label>Teacher</label>
                    <select class="Select-Teacher browser-default custom-select mb-4" name="teacher"></select>

                    <label>Room No</label>
                    <input type="text" class="form-control mb-4" name="room">
                </div>
                <div class="modal-footer p-0">
                    <div class="row w-100 m-0">
                        <div class="col-6 m-0 btn text-primary" id="Btn-Form-Create-Routine-Save">
                            <i class="fas fa-save mr-2"></i>Save
                        </div>
                        <div class="col-6 m-0 btn text-danger" id="Btn-Form-Create-Routine-Close" data-dismiss="modal">
                            <i class="fas fa-times-circle mr-2"></i>Cancel
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Create-Routine Form Modal -->

<!-- Reset Modal -->
<div id="Modal-Routine-Reset" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal-Routine-Reset-Label" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-danger" role="document">
        <div class="modal-content text-dark" style="font-size: 14px">
            <div class="modal-header">
                <p class="heading lead" id="Modal-Routine-Reset-Label">Confirme Reset?</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to reset this routine table? If you confirm, this routine table will be truncated.
                    <br><br>
                    <div class="text-danger">This action cannot be undone.</div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" id="Btn-Reset-Routine" class="btn btn-danger btn-sm" data-dismiss="modal">Reset</button>
                <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Modal -->
