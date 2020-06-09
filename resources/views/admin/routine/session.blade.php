<div id="Session" style="display: none;">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="lead">Session</div>
            <button class="btn btn-sm btn-success" id="Btn-Add-Session" data-toggle="modal" data-target="#Modal-Academic-Structure-Form">Add New Session</button>
        </div>
        <div class="card-body">
            <table class="table table-sm table-striped border border-dark" id="Table-Session">
                <thead class="blue-gradient text-white border-dark">
                    <tr>
                        <th class="align-middle">Session</th>
                        <th class="align-middle">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sessions as $session)                    
                    <tr id="Session-Id-{{ $session->id }}">
                        <td class="align-middle">{{ $session->session }}</td>
                        <td class="align-middle py-0">
                            <button class="btn btn-danger btn-sm px-2 delete-academic-structure" data-toggle="modal" data-target="#Modal-Academic-Structure-Delete" data-id="{{ $session->id }}" data-table="Session">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
