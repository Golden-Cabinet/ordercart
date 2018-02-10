<h4 class="float-left w-90">Brands</h4>
<a href="/dashboard/brands/create" class="btn btn-sm btn-primary float-right">Add New Brand</a>
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