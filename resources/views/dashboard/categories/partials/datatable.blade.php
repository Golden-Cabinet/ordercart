<h4 class="float-left w-90">Categories</h4>
<a href="/dashboard/categories/create" class="btn btn-sm btn-primary float-right">Add New Category</a>
<table id="dashboardCategoriesTable" class="ca-dt-bootstrap table table-responsive" style="width: 100%;"></table>

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