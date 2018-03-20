<h4 class="float-left w-90"><i class="fas fa-box"></i> Brands</h4>
<a href="/dashboard/brands/create" class="btn btn-sm btn-primary float-right"><i class="far fa-plus-square"></i> Add New Brand</a>
<div class="table-responsive">
<table id="dashboardBrandsTable" class="ca-dt-bootstrap table" style="width: 100%;"></table>
</div>

@push('dataSet')
<script>
        var dataSet = [                
            @foreach($brands as $brand)
                ['{{ $brand->name }}',
                '<a class="btn btn-warning btn-sm text-dark" href="/dashboard/brands/edit/{{$brand->id}}"><i class="fas fa-pencil-alt"></i> Edit</a> <a class="btn btn-danger btn-sm text-white" href="/dashboard/brands/delete/{{$brand->id}}"><i class="fas fa-trash"></i> Delete</a>'],            
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
                    { title: "Actions"}
                ],

            } );
        } );                       
    </script>
@endpush