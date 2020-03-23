@foreach($seen_messages as $message)
<div class="card mb-3 text-dark">
    <div class="card-header">
        <div class="row m-0">
            <div class="col-11 pl-0">
                <div class="row m-0 d-flex align-items-baseline">
                    <div class="col-md-auto pl-0 header-title h4 blue-text">
                        {{ $message->name }}
                    </div>
                    <div class="col-md-auto pl-0 header-title h6 blue-gray-text">
                        {{ $message->email }}
                    </div>
                </div>
                <p class="small text-black-50 mb-0">{{ \DateTime::createFromFormat('Y-m-d H:i:s', $message->created_at)->format('D, d F Y, h:i A') }}</p>
            </div>
            <div class="col-1 pr-0 border-left d-flex align-items-center justify-content-end">
                <button class="btn btn-danger btn-sm px-2 delete-message" data-toggle="modal" data-target="#Modal-Message-Delete" data-id={{ $message->id }}>
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{ $message->getMessage() }}
    </div>
</div>
@endforeach
<div class="card">
    <div class="card-body text-center info-color rounded pt-2 pb-0">
        <div class="mb-2">Showing <b>{{$seen_messages->count()}}</b> out of <b>{{$seen_messages->total()}}</b> Messages</div>
        <div class="mx-auto seen-messages" style="width: fit-content">{{ $seen_messages->links() }}</div>
    </div>
</div>