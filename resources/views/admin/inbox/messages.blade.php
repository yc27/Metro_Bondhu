<div class="inbox-header d-flex justify-content-between align-items-end mb-3">
    <div class="select-all-button d-flex align-items-center" style="padding-left: .75rem">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="Select-All-Message">
            <label class="custom-control-label text-primary" for="Select-All-Message">Select All</label>
        </div>
        <button class="btn btn-sm btn-danger p-2 ml-4 delete-all-message">Delete Selected</button>
    </div>

    <div class="search-button">
        <div class="input-group form-sm">
            <input class="form-control my-0 py-1" id="Message-Query" type="text" placeholder="Search" aria-label="Search">

            @if($from_search === true)
            <div class="input-group-append">
                <span class="input-group-text white reset-search-message">
                    <i class="fas fa-times" aria-hidden="true"></i>
                </span>
            </div>
            @endif

            <div class="input-group-append">
                <span class="input-group-text primary-color-dark search-message">
                    <i class="fas fa-search text-white" aria-hidden="true"></i>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="inbox-body">
    <table class="table table-sm border-bottom mb-3 white">
        <tbody>
            @foreach($messages as $message)
            <tr class="{{ $message->is_opened === 0 ? 'unseen-message' : 'seen-message'}}" id="Message-Id-{{ $message->id }}">
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input message-check" id="Message-Check-{{ $message->id}}" data-id="{{ $message->id}}">
                        <label class="custom-control-label" for="Message-Check-{{ $message->id}}"></label>
                    </div>
                </td>
                <td class="message-info" data-id="{{ $message->id }}">
                    {{ $message->name }}
                    <br>
                    <small class="text-muted font-weight-normal">
                        {{ \DateTime::createFromFormat('Y-m-d H:i:s', $message->created_at)->format('F d, Y') }}
                    </small>
                </td>
                <td class="message-body" data-id="{{ $message->id }}">
                    {{ strip_tags( $message->getMessage() ) }}
                </td>
                <td>
                    <i class="fas fa-envelope{{ $message->is_opened === 0 ? '-open' : ''}} text-muted mr-2 mark-message" title="Mark As {{ $message->is_opened === 0 ? 'Seen' : 'Unseen'}}" data-toggle="tooltip" data-id="{{ $message->id }}"></i>

                    <i class="fas fa-trash-alt text-muted delete-message" data-id="{{ $message->id }}" data-toggle="modal" data-target="#Modal-Message-Delete"></i>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $messages->links() }}
</div>