<div class="mb-2"> 
        <h4 class="float-left w-90"><i class="fas fa-clipboard-check"></i> Orders</h4>
        <a href="/dashboard/orders/create" class="btn btn-sm btn-primary float-right"><i class="far fa-plus-square"></i> Add New Order</a>
    </div> 
<div class="table-responsive">    
<table id="dashboardOrdersTable" class="ca-dt-bootstrap table" style="width: 100%;"></table>
</div>
@push('dataSet')
<script>
        var ordersDataSet = [                
            @foreach($orders as $order)
                ['{{ $order->id }}','{{ $order->patient()->name }}','{{ $order->created_date }}','{{ $order->status }}',
                '<a class="btn btn-warning btn-sm text-dark" href="/dashboard/orders/edit/{{$order->id}}"><i class="fas fa-pencil-alt"></i> Edit</a>'],
            
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
                    { title: "Order ID" },
                    { title: "Patient" },
                    { title: "Date" },
                    { title: "Status" },
                    { title: "Actions" },
                ],

            } );
        } );                       
    </script>
@endpush