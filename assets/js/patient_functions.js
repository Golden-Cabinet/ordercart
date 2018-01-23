function confirmDeletePatient() {
	$('#delete_confirmation_modal').modal('show')
}

function confirmReactivatePatient() {
	$('#reactivate_confirmation_modal').modal('show')
}

function hideInactivePatients(e) {
  var status = $(e).data('inactive-patients-hidden') == 'true' ? true : false;
  $('tr:contains(Inactive)').toggle();  

  if (status == false) {
    $(e).text("Show " + $('tr:contains(Inactive)').length + " Inactive Patients");    
    $(e).data('inactive-patients-hidden', "true");
    console.log("false?");
  }else{    
    $(e).text("Hide Inactive Patients");    
    $(e).data('inactive-patients-hidden', "false");
    console.log("true");
  }
}