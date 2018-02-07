<h4>Patients</h4>
<table id="dashboardPatientsTable" class="ca-dt-bootstrap table table-responsive"></table>

@push('dataSet')
<script>
        var dataSet = [                
            @foreach($patients as $patient)
                ['{{ $patient->user()->name }}'],
                ['{{ $patient->user()->email }}'],
                ['get the practitioner'],
                ['Edit'],
            
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
                    { title: "Practitioner" },
                    { title: "Edit" },
                ],

            } );
        } );                       
    </script>
@endpush