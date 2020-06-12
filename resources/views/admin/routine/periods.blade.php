<div id="Periods" style="display: none;">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="lead">Periods</div>
            <button class="btn btn-sm btn-success" id="Btn-Add-Period" data-toggle="modal" data-target="#Modal-Academic-Structure-Form">Add New Period</button>
        </div>
        <div class="card-body">
            <table class="table table-sm table-striped border border-dark" id="Table-Period">
                <thead class="blue-gradient text-white border-dark">
                    <tr>
                        <th class="align-middle">Start Time</th>
                        <th class="align-middle">End Time</th>
                        <th class="align-middle">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($periods as $period)
                    <tr id="Period-Id-{{ $period->id }}">
                        <td class="align-middle">
                            {{ \Carbon\Carbon::parse($period->start_time)->format('h:ia') }}
                        </td>
                        <td class="align-middle">
                            {{ \Carbon\Carbon::parse($period->end_time)->format('h:ia') }}
                        </td>
                        <td class="align-middle py-0">
                            <button class="btn btn-danger btn-sm px-2 delete-academic-structure" data-toggle="modal" data-target="#Modal-Academic-Structure-Delete" data-id="{{ $period->id }}" data-table="Period">
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
