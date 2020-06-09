<div id="Teachers" style="display: none;">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="lead">Teachers</div>
            <button class="btn btn-sm btn-success" id="Btn-Add-Teacher" data-toggle="modal" data-target="#Modal-Academic-Structure-Form">Add New Teacher</button>
        </div>
        <div class="card-body">
            <table class="table table-sm table-striped border border-dark" id="Table-Teacher">
                <thead class="blue-gradient text-white border-dark">
                    <tr>
                        <th class="align-middle">Full Name</th>
                        <th class="align-middle">Code Name</th>
                        <th class="align-middle">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $teacher)                    
                    <tr id="Teacher-Id-{{ $teacher->id }}">
                        <td class="align-middle">{{ $teacher->name }}</td>
                        <td class="align-middle">{{ $teacher->short_name }}</td>
                        <td class="align-middle py-0">
                            <button class="btn btn-danger btn-sm px-2 delete-academic-structure" data-toggle="modal" data-target="#Modal-Academic-Structure-Delete" data-id="{{ $teacher->id }}" data-table="Teacher">
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
