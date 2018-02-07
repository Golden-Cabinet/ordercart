<div class="mb-2">
        <h4 class="float-left w-90">Orders</h4>
        <button class="btn btn-sm btn-primary float-right">Add New Order</button>
    </div> 
<table id="dashboardOrdersTable" class="ca-dt-bootstrap table table-responsive"></table>

@push('dataSet')
<script>
        var dataSet = [                
            @foreach($orders as $order)
                ['{{ $order->id }}','{{ $order->patient()->name }}','{{ $order->created_date }}','{{ $order->status }}','View'],
            
            @endforeach                
        ];

        $(document).ready(function() {
            $('#dashboardOrdersTable').DataTable( {
                data: dataSet,  
                "bLengthChange": false,
                "pageLength": 25,
                "bInfo" : false,
                "pagingType": "numbers",
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Orders"
                },
                columns: [
                    { title: "OrderID" },
                    { title: "Patient" },
                    { title: "Date" },
                    { title: "Status" },
                    { title: "View" },
                ],

            } );
        } );                       
    </script>
@endpush