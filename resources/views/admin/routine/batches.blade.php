<div id="Batches" style="display: none;">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="lead">Batches</div>
            <button class="btn btn-sm btn-success" id="Btn-Add-Batch" data-toggle="modal" data-target="#Modal-Academic-Structure-Form">Add New Batch</button>
        </div>
        <div class="card-body">
            <table class="table table-sm table-striped border border-dark" id="Table-Batch">
                <thead class="blue-gradient text-white border-dark">
                    <tr>
                        <th class="align-middle">Department</th>
                        <th class="align-middle">Batch No</th>
                        <th class="align-middle">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($batches as $batch)
                    <tr id="Batch-Id-{{ $batch->id }}">
                        <td class="align-middle">{{ $batch->name }}</td>
                        <td class="align-middle">{{ $batch->batch_no }}</td>
                        <td class="align-middle py-0">
                            <button class="btn btn-danger btn-sm px-2 delete-academic-structure" data-toggle="modal" data-target="#Modal-Academic-Structure-Delete" data-id="{{ $batch->id }}" data-table="Batch">
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
