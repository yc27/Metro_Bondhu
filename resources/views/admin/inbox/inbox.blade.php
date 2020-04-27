<!-- Inbox -->
<div id="Inbox" class="tabcontent">
    <div class="container">
        <div class="text-dark title h1">
            Inbox
        </div>
        <div class="py-1 px-2 my-2 mx-0 align-middle rounded warning-color text-dark" style="width: fit-content;">
            Total Unseen Messages:
            <span class="badge primary-color p-2" id="Unseen-Messages-Count">{{ $unseen_messages_count }}</span>
        </div>
        <hr>
        @if($messages->isEmpty())
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="h2 text-center indigo-text">Inbox Empty</h2>
                </div>
            </div>
        </div>
        @else
        @foreach($messages as $message)
        <div class="card mb-3 text-dark" id="Message-Id-{{ $message->id }}">
            <div class="card-header {{ $message->is_opened === 0 ? 'light-blue darken-4' : 'white'}}">
                <div class="row m-0">
                    <div class="col-11 pl-0">
                        <div class="row m-0 d-flex align-items-baseline">
                            <div class="col-md-auto pl-0 header-title h4 message-name {{ $message->is_opened === 0 ? 'custom-blue-1' : 'blue-text'}}">
                                {{ $message->name }}
                            </div>
                            <div class="col-md-auto pl-0 header-title h6 message-email {{ $message->is_opened === 0 ? 'custom-blue-2' : 'blue-gray-text'}}">
                                {{ $message->email }}
                            </div>
                        </div>
                        <p class="small mb-0 message-date {{ $message->is_opened === 0 ? 'text-white' : 'text-black-50'}}">{{ \DateTime::createFromFormat('Y-m-d H:i:s', $message->created_at)->format('D, d F Y, h:i A') }}</p>
                    </div>
                    <div class="col-1 pr-0 border-left d-flex align-items-center justify-content-end">
                        <button class="btn btn-danger btn-sm px-2 delete-message" data-toggle="modal" data-target="#Modal-Message-Delete" data-id={{ $message->id }}>
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{ substr(strip_tags($message->getMessage()), 0, 100) }}{{ strlen(strip_tags($message->getMessage())) > 100 ? "..." : "" }}
            </div>
            <div class="card-footer p-0">
                <div class="row text-center text-muted m-0">
                    <div class="col-6 border-right btn m-0 view-message" data-toggle="modal" data-target="#Modal-Message-View" data-id={{ $message->id }}>
                        <i class="fas fa-expand-arrows-alt mr-2"></i>View Full Message
                    </div>
                    <div class="col-6 btn m-0 mark-message" data-id={{ $message->id }}>
                        <i class="{{ $message->is_opened === 0 ? 'far' : 'fas'}} fa-check-square mr-2"></i>Mark As {{ $message->is_opened === 0 ? 'Seen' : 'Unseen'}}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="card">
            <div class="card-body text-center info-color rounded pt-2 pb-0">
                <div class="mb-2">Showing <b>{{$messages->count()}}</b> out of <b>{{$messages->total()}}</b> Messages</div>
                <div class="mx-auto seen-messages" style="width: fit-content">{{ $messages->links() }}</div>
            </div>
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

<!-- Delete Modal -->
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
<!-- /Delete Modal -->

<!-- Script -->
<script type="text/javascript" src={{ asset('js/inbox.js') }}></script>
<!-- /Inbox -->