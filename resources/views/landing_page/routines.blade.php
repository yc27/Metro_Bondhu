<!-- Routines -->
<section class="py-4 app-routine" id="Routines">
    <h2 class="h2 text-center">Routines</h2>
    <hr class="w-25 w-sm-50 mt-2 mb-4">

    <div class="container-fluid">
        <form id="Form-Routine-Search">
            <div class="row">
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
        <div id="Routine-Search-Reasult" style="display: none"></div>
    </div>
</section>
<!-- /Routines -->
