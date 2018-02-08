<h4>Categories</h4>
<table id="dashboardCategoriesTable" class="ca-dt-bootstrap table table-responsive"></table>

@push('dataSet')
<script>
        var dataSet = [                
            @foreach($categories as $category)
                ['{{ $category->name }}',
                'Edit'],            
            @endforeach                
        ];

        $(document).ready(function() {
            $('#dashboardCategoriesTable').DataTable( {
                data: dataSet, 
                "bLengthChange": false,
                "pageLength": 10,
                "bInfo" : false,
                "pagingType": "numbers",
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Categories"
                }, 

                columns: [
                    { title: "Name" },
                    { title: "Edit"}
                ],

            } );
        } );                       
    </script>
@endpush