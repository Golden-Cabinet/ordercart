function fillSummaryTable(formula_id) {

	var ajax_data = ''
		
	$.get('/formulas/view/'+formula_id, ajax_data, function(data) {
	
			var content = $(data).find("#formula-view-table")
	  	$('#formula_summary_container').html(content)
			$('#formula-view-table').DataTable({ "iDisplayLength": 10, 
																			ordering:true, 
																			"lengthChange":false,
																			"searching":false,
																			"order":[],
																			"paging":false,
																			"info":false,
																			"columnDefs": [ 
																				{
																				"targets": 2,
																				"visible": false
																				},
																				{
																				 "targets": 3,
																				 "visible": false
																				},
																				{
																				  "targets": 4,
																				  "visible": false
																				},
																				{
																				  "targets": 5,
																				  "visible": false
																				},
																		 		]
																		});
	});
}

function checkFormulaName(formula_id) {
	var formula_name = $('#formula_name').val()
	var ajax_data = {formula_name : formula_name, formula_id : formula_id}
		
	$.post('/formulas/checkname', ajax_data, function(data) {
		if (data==0) {
			$('#formula_name_validation').slideUp()
			$('#save_formula_button').removeAttr('disabled');
		} else {
			$('#formula_name_validation').slideDown()
			$('#save_formula_button').attr('disabled','disabled');
			
		}
	})
	
	return false
	
}

function confirmDeleteFormula() {
	$('#delete_confirmation_modal').modal('show')
}