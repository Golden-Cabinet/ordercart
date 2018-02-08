<h4>Products</h4>
<table id="dashboardProductsTable" class="ca-dt-bootstrap table table-responsive"></table>

@push('dataSet')
<script>
        var dataSet = [                
            @foreach($products as $product)
                ['{{ $product->pinyin }}',
                '{{ $product->common_name }}',
                '{{ $product->brand()->name }}',
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