<div class="mb-2">
        <h4 class="float-left w-90"><i class="fas fa-address-card"></i> Patients</h4>
        <a href="/dashboard/patients/create" class="btn btn-sm btn-primary float-right"><i class="far fa-plus-square"></i> Add New Patient</a>
    </div>
<div class="table-responsive">
<table id="dashboardPatientsTable" class="ca-dt-bootstrap table" style="width: 100%;"></table>
</div>
@push('dataSet')
<script>
        var patientDataSet = [                
            @foreach($patients as $patient)
                ['{{ $patient->name }}', 
                '{{ $patient->email }}',
                '<a class="btn btn-warning btn-sm text-dark" href="/dashboard/patients/edit/{{$patient->id}}"><i class="fas fa-pencil-alt"></i> Edit</a>'],
            
            @endforeach                
        ];

        $(document).ready(function() {
            $('#dashboardPatientsTable').DataTable( {
                data: patientDataSet, 
                "bLengthChange": false,
                "pageLength": 10,
                "bInfo" : false,
                "pagingType": "numbers",
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Patients"
                }, 

                columns: [
                    { title: "Patient" },
                    { title: "Email" },
                    { title: "Actions" },
                ],

            } );
        } );                       
    </script>
@endpush