<h4 class="float-left w-90">Products</h4>
<a href="/dashboard/products/create" class="btn btn-sm btn-primary float-right">Add New Product</a>
<table id="dashboardProductsTable" class="ca-dt-bootstrap table table-responsive" style="width: 100%;"></table>

@push('dataSet')
<script>
        var dataSet = [                
            @foreach($products as $product)
                ['{{ $product->pinyin }}',
                '{{ $product->common_name }}',
                '{{ $product->brand_id }}',
                '{{ $product->concentration }}',
                '{{ $product->costPerGram }}',
                'Edit'],
            
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
                    searchPlaceholder: "Search Orders"
                }, 

                columns: [
                    { title: "Pinyin" },
                    { title: "Common Name" },
                    { title: "Brand" },
                    { title: "Concentration" },
                    { title: "Cost Per Gram" },
                    { title: "&nbsp;"}
                ],

            } );
        } );                       
    </script>
@endpush