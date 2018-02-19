<h4 class="float-left w-90">Users</h4>
<a href="/dashboard/users/create" class="btn btn-sm btn-primary float-right">Add New User</a>
<div class="table-responsive">
<table id="dashboardUsersTable" class="ca-dt-bootstrap table" style="width: 100%;"></table>
</div>
@push('dataSet')
<script>
        var dataSet = [                
            @foreach($users as $user)
                ['{{ $user->name }}',
                '{{ \App\AddressState::getStateName($user->license_state) }}',
                '{{ \App\UserRole::getRole($user->user_roles_id) }}',
                @if( $user->is_approved == 1)
                'Approved',
                @else 
                'Not Approved',
                @endif                
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