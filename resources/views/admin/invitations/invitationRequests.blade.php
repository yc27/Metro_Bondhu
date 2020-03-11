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
        <div class="request-table p-0">
            <table class="table table-striped text-center" id="Request-Table">
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

<!-- Generate Token Modal -->
<div id="Modal-Generate-Token" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal-Generate-Token-Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-dark" style="font-size: 14px">
            <div class="modal-header">
                <h4 class="modal-title w-100" id="Modal-Generate-Token-Label">Confirme Token Generation?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">
                    Are you sure you want to generate token for this email address?
                    <br><br>    
                    <div class="orange-text">If you confirm this action, a token will be generated and sent to this email address.</div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" id="Btn-Generate-Token" class="btn btn-warning btn-sm" data-dismiss="modal">Generate Token</button>
                <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- /Generate Token Modal -->

<!-- Delete Modal -->
<div id="Modal-Request-Delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal-Request-Delete-Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-dark" style="font-size: 14px">
            <div class="modal-header">
                <h4 class="modal-title w-100" id="Modal-Request-Delete-Label">Confirme Delete?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this user?
                    <br><br>
                    <div class="text-danger">This action cannot be undone.</div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" id="Btn-Delete-Request" class="btn btn-danger btn-sm" data-dismiss="modal">Delete</button>
                <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Modal -->

<!-- DataTable Script -->
<script type="text/javascript" src={{ asset('js/invitationRequest.js') }}></script>