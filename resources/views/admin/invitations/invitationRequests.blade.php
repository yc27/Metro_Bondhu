<!-- Invitation -->
<div id="Invite" class="tabcontent">
    <div class="container">
        <div class="text-dark title h1">
            Invitation Requests
        </div>
        <div class="py-1 px-2 my-2 mx-0 align-middle rounded warning-color text-dark" style="width: fit-content;">
            Pending Requests
            <span class="badge primary-color p-2" id="Pending-Requests"></span>
        </div>
        <hr>
        <div class="border border-dark rounded p-2">
            <table class="table table-striped text-center w-100" id="Requests-Table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Send Invitation Modal -->
<div id="Modal-Send-Invitation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal-Send-Invitation-Label" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-warning" role="document">
        <div class="modal-content text-dark" style="font-size: 14px">
            <div class="modal-header">
                <p class="heading lead" id="Modal-Send-Invitation-Label">Confirme Send Invitation?</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">
                    Are you sure you want to send invitation to this email address?
                    <br><br>    
                    <div class="orange-text">If you confirm this action, a token will be generated and sent to this email address.</div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" id="Btn-Send-Invitation" class="btn btn-warning btn-sm" data-dismiss="modal">Send Invitation</button>
                <button type="button" class="btn btn-outline-warning btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- /Send Invitation Modal -->

<!-- Delete Modal -->
<div id="Modal-Request-Delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal-Request-Delete-Label" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-danger" role="document">
        <div class="modal-content" style="font-size: 14px">
            <div class="modal-header">
                <p class="heading lead" id="Modal-Request-Delete-Label">Confirme Delete?</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this request?
                    <br><br>
                    <div class="text-danger">This action cannot be undone.</div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" id="Btn-Delete-Request" class="btn btn-danger btn-sm" data-dismiss="modal">Delete</button>
                <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Modal -->

<!-- DataTable Script -->
<script type="text/javascript" src={{ asset('js/invitationRequest.js') }}></script>
<!-- /Invitation -->