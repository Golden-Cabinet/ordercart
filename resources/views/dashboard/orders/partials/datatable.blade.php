<h4>Patients</h4>
<table id="dashboardOrdersTable" class="ca-dt-bootstrap table table-responsive"></table>

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