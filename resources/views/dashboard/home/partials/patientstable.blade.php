<div class="mb-2">
        <h4 class="float-left w-90">Patients</h4>
        <button class="btn btn-sm btn-primary float-right">Add New Patient</button>
    </div> 
<table id="dashboardPatientsTable" class="ca-dt-bootstrap table table-responsive"></table>

@push('dataSet')
<script>
        var dataSet = [                
            @foreach($patients as $patient)
                ['{{ $patient->user()->name }}',
                '{{ $patient->user()->email }}',
                'Edit'],
            
            @endforeach                
        ];

        $(document).ready(function() {
            $('#dashboardPatientsTable').DataTable( {
                data: dataSet, 
                "bLengthChange": false,
                "pageLength": 25,
                "bInfo" : false,
                "pagingType": "numbers",
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Patients"
                }, 

                columns: [
                    { title: "Patient" },
                    { title: "Email" },
                    { title: "Edit" },
                ],

            } );
        } );                       
    </script>
@endpush