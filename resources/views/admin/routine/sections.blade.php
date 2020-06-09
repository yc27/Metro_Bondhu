<div id="Sections" style="display: none;">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="lead">Sections</div>
            <button class="btn btn-sm btn-success" id="Btn-Add-Section" data-toggle="modal" data-target="#Modal-Academic-Structure-Form">Add New Section</button>
        </div>
        <div class="card-body">
            <table class="table table-sm table-striped border border-dark" id="Table-Section">
                <thead class="blue-gradient text-white border-dark">
                    <tr>
                        <th class="align-middle">Department</th>
                        <th class="align-middle">Batch No</th>
                        <th class="align-middle">Section No</th>
                        <th class="align-middle">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($sections as $section)
                    <tr id="Section-Id-{{ $section->id }}">
                        <td class="align-middle">{{ $section->name }}</td>
                        <td class="align-middle">{{ $section->batch_no }}</td>
                        <td class="align-middle">{{ $section->section_no }}</td>
                        <td class="align-middle py-0">
                            <button class="btn btn-danger btn-sm px-2 delete-academic-structure" data-toggle="modal" data-target="#Modal-Academic-Structure-Delete" data-id="{{ $section->id }}" data-table="Section">
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
