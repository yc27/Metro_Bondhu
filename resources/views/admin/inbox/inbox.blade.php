<!-- Inbox -->
<div id="Inbox" class="tabcontent">
    <div class="container-fluid">
        <div class="text-dark title h1">
            Inbox
        </div>
        <hr>

        @if($messages->isEmpty())
        <div class="container-fluid d-block" id="Inbx-Empty">
            <div class="row">
                <div class="col">
                    <h2 class="h2 text-center indigo-text">Inbox Empty</h2>
                </div>
            </div>
        </div>
        @else
        <div class="inbox pb-4 position-relative">
            <div class="inbox-content" style="display: block">
            @include('admin.inbox.messages')
            </div>

            <div class="message-view" id="Message-View" style="display: none">
                <div class="message-header border-bottom d-flex" id="Message-Header">
                    <div class="message-close p-3 align-self-center">
                        <i class="fas fa-arrow-left text-muted"></i>
                    </div>
                    <div class="message-info border-left px-3 py-2">
                        <h4 class="h4 title m-0" id="Message-Sender-Name"></h4>
                        <h6 class="h6 m-0 text-muted" id="Message-Sender-Email"></h6>
                        <small id="Message-Date"></small>
                    </div>
                </div>

                <div class="message-body p-4" id="Message-Body"></div>
            </div>
        </div>
        @endif
    </div>
</div>

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