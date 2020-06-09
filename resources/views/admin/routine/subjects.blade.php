<div id="Subjects" style="display: none;">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="lead">Subjects</div>
            <button class="btn btn-sm btn-success" id="Btn-Add-Subject" data-toggle="modal" data-target="#Modal-Academic-Structure-Form">Add New Subject</button>
        </div>
        <div class="card-body">
            <table class="table table-sm table-striped border border-dark" id="Table-Subject">
                <thead class="blue-gradient text-white border-dark">
                    <tr>
                        <th class="align-middle">Subject Code</th>
                        <th class="align-middle">Subjct Name</th>
                        <th class="align-middle">Short Name</th>
                        <th class="align-middle">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $subject)                    
                    <tr id="Subject-Id-{{ $subject->id }}">
                        <td class="align-middle">{{ $subject->code }}</td>
                        <td class="align-middle">{{ $subject->name }}</td>
                        <td class="align-middle">{{ $subject->short_name }}</td>
                        <td class="align-middle py-0">
                            <button class="btn btn-danger btn-sm px-2 delete-academic-structure" data-toggle="modal" data-target="#Modal-Academic-Structure-Delete" data-id="{{ $subject->id }}" data-table="Subject">
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
