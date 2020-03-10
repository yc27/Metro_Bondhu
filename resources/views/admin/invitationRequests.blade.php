<div id="Invite" class="tabcontent">
    <div class="container">
        <div class="text-dark title h1">
            Invitation Requests
        </div>
        <div class="py-1 px-2 my-2 mx-0 align-middle rounded warning-color text-dark" style="width: fit-content;">
            Pending Requests
            <span class="badge primary-color p-2" id="Pending-Requests"></span>
        </div>
        <hr>
        <div class="request-table p-0">
            <table class="table table-striped text-center" id="Request-Table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Email</th>
                        <th>Invitation Token</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    var requestTable;
    $(function() {
        $.noConflict();
        window.requestTable = $('#Request-Table').DataTable({
            processing: true,
            serverSide: true,
            order: [[ 3, "asc" ]],
            pagingType: "full_numbers",
            ajax: '{{ route('requests.show') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'email', name: 'email' },
                { data: 'invitation_token', name: 'invitation_token' },
                { data: 'created_at', name: 'created_at' },
            ],
            columnDefs: [
                {
                    targets: 0,
                    visible: false,
                    searchable: false
                },
                {
                    targets: 3,
                    render: function(data, type, row, meta){
                        var d = new Date(row.created_at);
                        return formateDate(d);
                    }
                },
                { 
                    targets: 4,
                    render: function(data, type, row, meta){
                            return "<button type=\"button\" class=\"btn btn-sm btn-warning\">Generate Token</button><button type=\"button\" class=\"btn btn-sm btn-success\">Send Mail</button><button type=\"button\" class=\"btn btn-sm btn-danger\">Delete Request</button>";
                    },
                    searchable: false,
                    orderable: false
                },
                {
                    targets: "_all",
                    className: "align-middle"
                }
            ],
            language: {
                lengthMenu: "Display _MENU_ records per page",
                zeroRecords: "No Data Found",
                info: "Showing page _PAGE_ of _PAGES_",
                infoEmpty: "No records available",
                infoFiltered: "(Filtered from _MAX_ total records)"
            },
            drawCallback: function( settings ) {
                pendingRequests();
            }
        });
    });

    // Fromate Date
    function formateDate(d) {
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        function leadingZero(n) { return n < 10 ? '0'+n : n }

        var hh = d.getHours();
        return (hh%12 === 0 ? 12 : hh%12) + ':' + leadingZero(d.getMinutes()) + (hh>11 ?  'pm, \n' : 'am, \n')
            + leadingZero(d.getDate()) + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
    }

    // Update No of Pending Requests
    function pendingRequests() {
        var json = window.requestTable.ajax.json();
        $('#Pending-Requests').text(json.pendingRequests);
    }
</script>
