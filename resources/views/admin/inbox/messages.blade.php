@foreach($messages as $message)
<div class="card mb-3 text-dark" id="Message-Id-{{ $message->id }}">
    <div class="card-header {{ $message->is_opened === 0 ? 'light-blue darken-4' : 'white'}}">
        <div class="row m-0">
            <div class="col-10 col-sm-11 pl-0">
                <div class="row m-0 d-flex align-items-baseline">
                    <div class="col-md-auto pl-0 header-title h4 message-name {{ $message->is_opened === 0 ? 'custom-blue-1' : 'blue-text'}}">
                        {{ $message->name }}
                    </div>
                    <div class="col-md-auto pl-0 header-title h6 message-email {{ $message->is_opened === 0 ? 'custom-blue-2' : 'blue-grey-text'}}">
                        {{ $message->email }}
                    </div>
                </div>
                <p class="small mb-0 message-date {{ $message->is_opened === 0 ? 'text-white' : 'text-black-50'}}">{{ \DateTime::createFromFormat('Y-m-d H:i:s', $message->created_at)->format('D, d F Y, h:i A') }}</p>
            </div>
            <div class="col-2 col-sm-1 pr-0 border-left d-flex align-items-center justify-content-end">
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
            <div class="col-sm-6 border-right btn m-0 view-message" data-toggle="modal" data-target="#Modal-Message-View" data-id={{ $message->id }}>
                <i class="fas fa-expand-arrows-alt mr-2"></i>View Full Message
            </div>
            <div class="col-sm-6 btn m-0 mark-message" data-id={{ $message->id }}>
                <i class="{{ $message->is_opened === 0 ? 'far' : 'fas'}} fa-check-square mr-2"></i>Mark As {{ $message->is_opened === 0 ? 'Seen' : 'Unseen'}}
            </div>
        </div>
    </div>
</div>
@endforeach
@if($messages->hasPages())
<div class="card">
    <div class="card-body text-center info-color rounded py-2">
        <div class="mx-auto" style="width: fit-content">{{ $messages->links() }}</div>
    </div>
</div>
@endif