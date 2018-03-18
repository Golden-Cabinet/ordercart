<h4 class="float-left w-90">Formulas</h4>
<a href="/dashboard/formulas/create" class="btn btn-sm btn-primary float-right">Add New Formula</a>
<div class="table-responsive">
<table id="dashboardFormulasTable" class="ca-dt-bootstrap table" style="width: 100%;"></table>
</div>
@push('dataSet')
<script>
        var dataSet = [                
            @foreach($formulas as $formula)
                [
                 @if($formula->deleted == 1)
                 '<span class="text-secondary"><em>{{ $formula->name }} - DELETED',
                 @else
                 '{{ $formula->name }}',
                 @endif                
                
                @if($formula->deleted == 1)
                '{{ \App\User::getUserName($formula->users_id) }}</em></span>',
                '<a class="btn btn-warning btn-sm text-dark" href="/dashboard/formulas/edit/{{$formula->id}}">Edit</a> <a class="btn btn-info btn-sm text-white" href="/dashboard/formulas/duplicate/{{$formula->id}}">Duplicate</a>'
                @else
                '{{ \App\User::getUserName($formula->users_id) }}',
                '<a class="btn btn-warning btn-sm text-dark" href="/dashboard/formulas/edit/{{$formula->id}}">Edit</a> <a class="btn btn-info btn-sm text-white" href="/dashboard/formulas/duplicate/{{$formula->id}}">Duplicate</a> <a class="btn btn-danger btn-sm text-white" href="/dashboard/formulas/delete/{{$formula->id}}">Delete</a>'
                @endif                
                ],
           
            @endforeach                
        ];

        $(document).ready(function() {
            $('#dashboardFormulasTable').DataTable( {
                data: dataSet, 
                "bLengthChange": false,
                "pageLength": 10,
                "bInfo" : false,
                "pagingType": "numbers",
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Formulas"
                }, 

                columns: [
                    { title: "Name" },
                    { title: "Creator" },
                    { title: "Actions"}
                ],

            } );
        } );                       
    </script>
@endpush