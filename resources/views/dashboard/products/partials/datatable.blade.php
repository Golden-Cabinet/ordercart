<h4 class="float-left w-90"><i class="fab fa-pagelines"></i> Products</h4>
<a href="/dashboard/products/create" class="btn btn-sm btn-primary float-right"><i class="far fa-plus-square"></i> Add New Product</a>
<div class="table-responsive">
<table id="dashboardProductsTable" class="ca-dt-bootstrap table"></table>
</div>

@push('dataSet')
<script>
        var dataSet = [                
            @foreach($products as $product)
                ['{{ $product->pinyin }}',
                '{{ $product->common_name }}',
                '{{ \App\Brand::getBrandName($product->brands_id) }}',
                '<a class="btn btn-warning btn-sm text-dark" href="/dashboard/products/edit/{{$product->id}}"><i class="fas fa-pencil-alt"></i> Edit</a> <a class="btn btn-danger btn-sm text-white" href="/dashboard/products/delete/{{$product->id}}"><i class="fas fa-trash"></i> Delete</a>'],
            
            @endforeach                
        ];

        $(document).ready(function() {
            $('#dashboardProductsTable').DataTable( {
                data: dataSet, 
                "bLengthChange": false,
                "pageLength": 10,
                "bInfo" : false,
                "pagingType": "numbers",
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Products"
                }, 

                columns: [
                    { title: "Pinyin" },
                    { title: "Common Name" },
                    { title: "Brand" },
                    { title: "Actions"}
                ],

            } );
        } );                       
    </script>
@endpush