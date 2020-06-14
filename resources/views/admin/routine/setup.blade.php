<!-- Routine -->
<div id="Routine" class="tabcontent">
    <div class="container-fluid">
        <div class="text-dark title h1">
            Routine
        </div>
        <hr>

        <div class="academic-structure-menu clearfix">
            <div class="menu-button mb-4 float-left">
                <div class="card text-center menu" data-menu="Departments">
                    <div class="card-body">
                        <span>D</span>
                    </div>
                    <div class="card-footer">
                        Departments
                    </div>
                </div>
            </div>

            <div class="menu-button mb-4 float-left">
                <div class="card text-center menu" data-menu="Batches">
                    <div class="card-body">
                        <span>B</span>
                    </div>
                    <div class="card-footer">
                        Batches
                    </div>
                </div>
            </div>

            <div class="menu-button mb-4 float-left">
                <div class="card text-center menu" data-menu="Sections">
                    <div class="card-body">
                        <span>S</span>
                    </div>
                    <div class="card-footer">
                        Sections
                    </div>
                </div>
            </div>

            <div class="menu-button mb-4 float-left">
                <div class="card text-center menu" data-menu="Teachers">
                    <div class="card-body">
                        <span>T</span>
                    </div>
                    <div class="card-footer">
                        Teachers
                    </div>
                </div>
            </div>

            <div class="menu-button mb-4 float-left">
                <div class="card text-center menu" data-menu="Subjects">
                    <div class="card-body">
                        <span>S</span>
                    </div>
                    <div class="card-footer">
                        Subjects
                    </div>
                </div>
            </div>

            <div class="menu-button mb-4 float-left">
                <div class="card text-center menu" data-menu="Periods">
                    <div class="card-body">
                        <span>P</span>
                    </div>
                    <div class="card-footer">
                        Periods
                    </div>
                </div>
            </div>

            <div class="menu-button mb-4 float-left">
                <div class="card text-center menu" data-menu="ClassDays">
                    <div class="card-body">
                        <span>C</span>
                    </div>
                    <div class="card-footer">
                        Class Days
                    </div>
                </div>
            </div>

            <div class="menu-button mb-4 float-left">
                <div class="card text-center menu" data-menu="Session">
                    <div class="card-body">
                        <span>S</span>
                    </div>
                    <div class="card-footer">
                        Session
                    </div>
                </div>
            </div>

            <div class="menu-button mb-4 float-left">
                <div class="card text-center menu Routines" data-menu="Routines">
                    <div class="card-body">
                        <span class="deep-orange-text">R</span>
                    </div>
                    <div class="card-footer deep-orange">
                        Routines
                    </div>
                </div>
            </div>

            <div class="academic-structure-details float-left ml-0">
                @include('admin.routine.departments')
                @include('admin.routine.batches')
                @include('admin.routine.sections')
                @include('admin.routine.teachers')
                @include('admin.routine.subjects')
                @include('admin.routine.periods')
                @include('admin.routine.classDays')
                @include('admin.routine.session')
            </div>
        </div>
        @include('admin.routine.routines')
    </div>
</div>

<!-- Academic-Structure Form Modal -->
<div class="modal fade" id="Modal-Academic-Structure-Form" tabindex="-1" role="dialog" aria-labelledby="Modal-Academic-Structure-Label" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header primary-color-dark text-white">
                <h4 id="Modal-Academic-Structure-Title" class="modal-title w-100 text-center"></h4>
            </div>
            <form id="Form-Academic-Structure" enctype="multipart/form-data">
                <div class="modal-body mx-3 pb-0">
                    <div class="alert alert-danger d-none" id="Form-Academic-Structure-Error">
                        <ul id="Form-Academic-Structure-Error-Message"></ul>
                    </div>
                    <div id="Form-Academic-Structure-Content"></div>
                </div>
                <div class="modal-footer p-0">
                    <div class="row w-100 m-0">
                        <div class="col-6 m-0 btn text-primary" id="Btn-Form-Academic-Structure-Save">
                            <i class="fas fa-save mr-2"></i>Save
                        </div>
                        <div class="col-6 m-0 btn text-danger" id="Btn-Form-Academic-Structure-Close" data-dismiss="modal">
                            <i class="fas fa-times-circle mr-2"></i>Cancel
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Academic-Structure Form Modal -->

<!-- Academic-Structure Delete Modal -->
<div id="Modal-Academic-Structure-Delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal-Academic-Structure-Label" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-danger" role="document">
        <div class="modal-content text-dark" style="font-size: 14px">
            <div class="modal-header">
                <p class="heading lead" id="Modal-Academic-Structure-Delete-Label">Confirme Delete?</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this entry?
                    <br><br>
                    <div class="text-danger">This action cannot be undone.</div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" id="Btn-Delete-Academic-Structure" class="btn btn-danger btn-sm" data-dismiss="modal">Delete</button>
                <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- /Academic-Structure Delete Modal -->
<!-- /Routine -->

@section('script')
@parent
<script type="text/javascript" src={{ asset('js/routine.js') }}></script>
@endsection
