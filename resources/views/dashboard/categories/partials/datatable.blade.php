<h4 class="float-left w-90"><i class="fas fa-list"></i> Categories</h4>
<a href="/dashboard/categories/create" class="btn btn-sm btn-primary float-right"><i class="far fa-plus-square"></i> Add New Category</a>
<div class="table-responsive">
<table id="dashboardCategoriesTable" class="ca-dt-bootstrap table" style="width: 100%;"></table>
</div>
@push('dataSet')
<script>
        var dataSet = [                
            @foreach($categories as $category)
                ['{{ $category->name }}',
                '<a class="btn btn-warning btn-sm text-dark" href="/dashboard/categories/edit/{{$category->id}}"><i class="fas fa-pencil-alt"></i> Edit</a> <a class="btn btn-danger btn-sm text-white" href="/dashboard/categories/delete/{{$category->id}}"><i class="fas fa-trash"></i> Delete</a>'],            
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