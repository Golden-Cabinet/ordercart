<h4 class="float-left w-90"><i class="fas fa-users"></i> Users</h4>
<a href="/dashboard/users/create" class="btn btn-sm btn-primary float-right"><i class="far fa-plus-square"></i> Add New User</a>
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
                'Activated',
                @else 
                'Deactivated',
                @endif                
                '{{ $user->email }}',
                '<a class="btn btn-warning btn-sm text-dark" href="/dashboard/users/edit/{{$user->id}}"><i class="fas fa-pencil-alt"></i> Edit</a>'],            
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
                    searchPlaceholder: "Search Users"
                }, 

                columns: [
                    { title: "Name" },
                    { title: "State" },
                    { title: "Role" },
                    { title: "Active" },
                    { title: "Email" },
                    { title: "Actions"}
                ],

            } );
        } );                       
    </script>
@endpush