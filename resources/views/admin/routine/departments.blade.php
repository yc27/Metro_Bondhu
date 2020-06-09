<div id="Departments" style="display: none;">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="lead">Departments</div>
            <button class="btn btn-sm btn-success" id="Btn-Add-Dapartment" data-toggle="modal" data-target="#Modal-Academic-Structure-Form">Add New Department</button>
        </div>
        <div class="card-body">
            <table class="table table-sm table-striped table-hover border border-dark" id="Table-Department">
                <thead class="blue-gradient text-white border-dark">
                    <tr>
                        <th class="align-middle">Dept Name</th>
                        <th class="align-middle">Short Name</th>
                        <th class="align-middle">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($departments as $department)
                    <tr id="Department-Id-{{ $department->id }}">
                        <td class="align-middle">{{ $department->name }}</td>
                        <td class="align-middle">{{ $department->short_name }}</td>
                        <td class="align-middle py-0">
                            <button class="btn btn-danger btn-sm px-2 delete-academic-structure" data-toggle="modal" data-target="#Modal-Academic-Structure-Delete" data-id="{{ $department->id }}" data-table="Department">
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
