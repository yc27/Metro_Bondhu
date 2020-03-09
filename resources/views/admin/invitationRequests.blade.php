<div id="Invite" class="tabcontent">
    <div class="container">
        <div class="text-dark title h1">
            Invitation Requests
        </div>
        <div class="py-1 px-2 my-2 mx-0 rounded warning-color text-dark" style="width: fit-content;">
            Pending Requests
            <span class="badge primary-color">{{ $pendingRequests }}</span>
        </div>
        <hr>
        <div class="request-table p-0">
            @if (!empty($invitations))
            <table class="mt-4 table table-responsive table-striped text-center">
                <thead class="border primary-color-dark white-text">
                    <tr>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Token</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="border white">
                    @foreach ($invitations as $invitation)
                    <tr>
                        <td>
                            <a href="mailto:{{ $invitation->email }}">{{ $invitation->email }}</a>
                        </td>
                        <td>{{ $invitation->created_at }}</td>
                        <td>abcdefghijklmnopqrtuvwxyz</td>
                        <td>
                            <button class="btn btn-warning btn-sm">Generate Token</button>
                            <button class="btn btn-success btn-sm">Send Mail</button>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $invitations->links() }}
            @else
            <p>No invitation requests!</p>
            @endif
        </div>
    </div>
</div>
