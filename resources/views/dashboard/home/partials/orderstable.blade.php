<div class="mb-2"> 
        <h4 class="float-left w-90">Orders</h4>
        <a href="/dashboard/orders/create" class="btn btn-sm btn-primary float-right">Add New Order</a>
    </div> 
<div class="table-responsive">    
<table id="dashboardOrdersTable" class="ca-dt-bootstrap table" style="width: 100%;"></table>
</div>
@push('dataSet')
<script>
        var ordersDataSet = [                
            @foreach($orders as $order)
                ['{{ $order->id }}','{{ $order->patient()->name }}','{{ $order->created_date }}','{{ $order->status }}','View'],
            
            @endforeach                
        ];

        $(document).ready(function() {
            $('#dashboardOrdersTable').DataTable( {
                data: ordersDataSet,  
                "bLengthChange": false,
                "pageLength": 10,
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