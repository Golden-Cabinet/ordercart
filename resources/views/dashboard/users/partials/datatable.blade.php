<h4>Users</h4>
<table id="dashboardUsersTable" class="ca-dt-bootstrap table table-responsive" style="width: 100%;"></table>

@push('dataSet')
<script>
        var dataSet = [                
            @foreach($users as $user)
                ['{{ $user->name }}',
                '{{ $user->license_state }}',
                '{{ $user->user_roles_id }}',
                'fix me',
                '{{ $user->email }}',
                'Edit'],            
            @endforeach                
        ];

        $(document).ready(function() {
            $('#dashboardUsersTable').DataTable( {
                data: dataSet, 
                "bLengthChange": false,
                "pageLength": 10,
                "bInfo" : false,
                "pagingType": "numbers",
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Brands"
                }, 

                columns: [
                    { title: "Name" },
                    { title: "State" },
                    { title: "Role" },
                    { title: "Approved" },
                    { title: "Email" },
                    { title: "Actions"}
                ],

            } );
        } );                       
    </script>
@endpush