<h4 class="float-left w-90"><i class="fas fa-flask"></i> Formulas</h4>
<a href="/dashboard/formulas/create" class="btn btn-sm btn-primary float-right"><i class="far fa-plus-square"></i> Add New Formula</a>
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
                '<a class="btn btn-warning btn-sm text-dark" href="/dashboard/formulas/edit/{{$formula->id}}"><i class="fas fa-pencil-alt"></i> Edit</a> <a class="btn btn-info btn-sm text-white" href="/dashboard/formulas/duplicate/{{$formula->id}}"><i class="fas fa-copy"></i> Duplicate</a>'
                @else
                '{{ \App\User::getUserName($formula->users_id) }}',
                '<a class="btn btn-warning btn-sm text-dark" href="/dashboard/formulas/edit/{{$formula->id}}"><i class="fas fa-pencil-alt"></i> Edit</a> <a class="btn btn-info btn-sm text-white" href="/dashboard/formulas/duplicate/{{$formula->id}}"><i class="fas fa-copy"></i> Duplicate</a> <a class="btn btn-danger btn-sm text-white" href="/dashboard/formulas/delete/{{$formula->id}}"><i class="fas fa-trash"></i> Delete</a>'
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