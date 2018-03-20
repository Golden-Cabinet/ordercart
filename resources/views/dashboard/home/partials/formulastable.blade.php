<div class="mb-2">
    <h4 class="float-left w-90"><i class="fas fa-flask"></i> Formulas</h4>
    <a href="/dashboard/formulas/create" class="btn btn-sm btn-primary float-right"><i class="far fa-plus-square"></i> Add New Formula</a>
</div>    
<div class="table-responsive">
<table id="dashboardFormulasTable" class="ca-dt-bootstrap table" style="width: 100%;"></table>
</div>
@push('dataSet')
<script>
        var formulasDataSet = [                
            @foreach($formulas as $formula)
                ['{{ $formula->name }}',
                '<a class="btn btn-warning btn-sm text-dark" href="/dashboard/formulas/edit/{{$formula->id}}"><i class="fas fa-pencil-alt"></i> Edit</a>'
                
                ],
            
            @endforeach                
        ];

        $(document).ready(function() {
            $('#dashboardFormulasTable').DataTable( {
                data: formulasDataSet,  
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
                    { title: "Actions" },
                ],

            } );
        } );                       
    </script>
@endpush