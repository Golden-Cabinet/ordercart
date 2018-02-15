<h4 class="float-left w-90">Patients</h4>
<a href="/dashboard/orders/create" class="btn btn-sm btn-primary float-right">Add New Order</a>
<div class="table-responsive">
<table id="dashboardOrdersTable" class="ca-dt-bootstrap table" style="width: 100%;"></table>
</div>
@push('dataSet')
<script>
        var dataSet = [                
            @foreach($orders as $order)
                ['{{ $order->id }}',
                '{{ $order->patient()->name }}',
                '{{ $order->formula()->name }}',
                '{{ $order->status }}',
                'Edit'],
            
            @endforeach                
        ];

        $(document).ready(function() {
            $('#dashboardOrdersTable').DataTable( {
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
                    { title: "Order Id" },
                    { title: "Patient" },
                    { title: "Formula Name" },
                    { title: "Order Status" },
                    { title: "View Order Details" },
                ],

            } );
        } );                       
    </script>
@endpush