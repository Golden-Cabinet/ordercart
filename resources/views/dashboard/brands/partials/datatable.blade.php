<h4>Brands</h4>
<table id="dashboardBrandsTable" class="ca-dt-bootstrap table table-responsive" style="width: 100%;"></table>

@push('dataSet')
<script>
        var dataSet = [                
            @foreach($brands as $brand)
                ['{{ $brand->name }}',
                'Edit'],            
            @endforeach                
        ];

        $(document).ready(function() {
            $('#dashboardBrandsTable').DataTable( {
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
                    { title: "Brand" },
                    { title: "Edit"}
                ],

            } );
        } );                       
    </script>
@endpush