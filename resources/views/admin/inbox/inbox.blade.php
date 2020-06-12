<!-- Inbox -->
<div id="Inbox" class="tabcontent">
    <div class="container-fluid">
        <div class="text-dark title h1">
            Inbox
        </div>
        @if($unseen_messages_count !== 0)
        <div class="py-1 px-2 my-2 mx-0 align-middle rounded warning-color text-dark" style="width: -moz-fit-content;width: fit-content;">
            Total Unseen Messages:
            <span class="badge primary-color p-2" id="Unseen-Messages-Count">{{ $unseen_messages_count }}</span>
        </div>
        @endif
        <hr>
        @if($messages->isEmpty())
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h2 class="h2 text-center indigo-text">Inbox Empty</h2>
                </div>
            </div>
        </div>
        @else
        <div class="inbox">
            @include('admin.inbox.messages')
        </div>
        @endif
    </div>
</div>

<!-- Message View Modal -->
<div id="Modal-Message-View" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal-Message-View-Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-notify" role="document">
        <div class="modal-content">
            <div class="modal-header light-blue darken-4" style="flex-direction: column">
                <div class="row m-0">
                    <div class="col pl-0 header-title h4 custom-blue-1" id="Modal-Message-Name"></div>
                </div>
                <div class="row m-0">
                    <div class="col pl-0 header-title h6 custom-blue-2" id="Modal-Message-Email"></div>
                </div>
                <div class="row m-0">
                    <div class="col pl-0 small text-white" id="Modal-Message-Date"></div>
                </div>

                <button type="button" class="close position-absolute" style="right: 1rem" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark" id="Modal-Message-Body">
            </div>
            <div class="modal-footer p-0 justify-content-center">
                <div class="row text-center m-0 w-100">
                    <div class="col-6 border-right btn m-0 text-info mark-message" id="Btn-Mark-Message" data-dismiss="modal">
                        <i class="fas fa-check-square mr-2"></i>Mark As Unseen
                    </div>
                    <div class="col-6 btn m-0 text-danger delete-message" data-dismiss="modal" data-toggle="modal" data-target="#Modal-Message-Delete" >
                        <i class="fas fa-trash-alt mr-2"></i>Delete Message
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Message View Modal -->

<!-- Message Delete Modal -->
<div id="Modal-Message-Delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal-Message-Delete-Label" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-danger" role="document">
        <div class="modal-content text-dark" style="font-size: 14px">
            <div class="modal-header">
                <p class="heading lead" id="Modal-Message-Delete-Label">Confirme Delete?</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this message?
                    <br><br>
                    <div class="text-danger">This action cannot be undone.</div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" id="Btn-Delete-Message" class="btn btn-danger btn-sm" data-dismiss="modal">Delete</button>
                <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- /Message Delete Modal -->
<!-- /Inbox -->

@section('script')
@parent
<script type="text/javascript" src={{ asset('js/inbox.js') }}></script>
@endsection