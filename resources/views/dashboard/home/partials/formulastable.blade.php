<div class="mb-2">
    <h4 class="float-left w-90">Formulas</h4>
    <button class="btn btn-sm btn-primary float-right">Add New Formula</button>
</div>    

<table id="dashboardFormulasTable" class="ca-dt-bootstrap table table-responsive"></table>

@push('dataSet')
<script>
        var dataSet = [                
            @foreach($formulas as $formula)
                ['{{ $formula->name }}'],
            
            @endforeach                
        ];

        $(document).ready(function() {
            $('#dashboardFormulasTable').DataTable( {
                data: dataSet,  
                "bLengthChange": false,
                "pageLength": 25,
                "bInfo" : false,
                "pagingType": "numbers",
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Formulas"
                },
                columns: [
                    { title: "Name" },
                ],

            } );
        } );                       
    </script>
@endpush