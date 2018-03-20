<h4 class="float-left w-90"><i class="fas fa-address-card"></i> Patients</h4>
<a href="/dashboard/patients/create" class="btn btn-sm btn-primary float-right"><i class="far fa-plus-square"></i> Add New Patient</a>
<div class="table-responsive">
<table id="dashboardPatientsTable" class="ca-dt-bootstrap table" style="width: 100%;"></table>
</div>

@push('dataSet')
<script>
        var dataSet = [                
            @foreach($patients as $patient)
                ['{{ $patient->name }}',
                '{{ $patient->email }}',
                'get the practitioner',
                '<a class="btn btn-warning btn-sm text-dark" href="/dashboard/patients/edit/{{$patient->id}}">Edit</a>'],
            
            @endforeach                
        ];

        $(document).ready(function() {
            $('#dashboardPatientsTable').DataTable( {
                data: dataSet, 
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
                    { title: "Practitioner" },
                    { title: "Edit" },
                ],

            } );
        } );                       
    </script>
@endpush