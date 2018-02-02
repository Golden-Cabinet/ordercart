function orderAdvanceStep(target, previous) {

	$('.order_validation_message_container').css('display', 'none')

	if (previous == 'patient') {
		if ($('#patient_id').val() == 'none') {
			$('#patient_validation').slideToggle();
			$('#patient_id').focus()
			return false
		}
		if ($('#formula').val() == 'none') {
			$('#formula_validation').slideToggle();
			$('#formula_id').focus()
			return false
		}
	}

	// shipping
	if (previous == 'dosage') {
		if ($('#timesPerDay').val() == '') {
			$('#times_per_day_validation').slideToggle();
			$('#timesPerDay').focus()
			return false
		}

		if ($('#numberOfScoops').val() == 'default') {
			$('#scoop_validation').slideToggle();
			$('#timesPerDay').focus()
			return false
		}

		// take the select patient's name to personalize drop-down for pickup options
		var patient_name = $('#patient_id option:selected').text();
		$('#howPickup option:first').text(patient_name + ' will pick up');

	}

	if (target == 'review') {
		reviewOrder();
	}

	var container = '#order_' + target + '_container';
	var breadcrumb_next = '#order_' + target + '_breadcrumb';
	var breadcrumb_previous = '#order_' + previous + '_breadcrumb';
	var breadcrumb_arrow_next = '#order_' + target + '_breadcrumb_arrow';
	var breadcrumb_arrow_previous = '#order_' + previous + '_breadcrumb_arrow';

	$('.order_form_container').css('display', 'none');
	$(container).css('display', 'block');
	if (container == "#order_review_container") {
		$('#order_review_formula_container').css('display', 'block');
	}
	$(breadcrumb_next).addClass('order_form_breadcrumb_active')
	$(breadcrumb_arrow_next).addClass('order_form_breadcrumb_arrow_active')
	$('.order_form_breadcrumb_previous').removeClass('order_form_breadcrumb_previous').addClass('order_form_breadcrumb_completed')
	$('.order_form_breadcrumb_arrow_previous').removeClass('order_form_breadcrumb_arrow_previous').addClass('order_form_breadcrumb_arrow_completed')
	$(breadcrumb_previous).removeClass('order_form_breadcrumb_active').addClass('order_form_breadcrumb_previous')
	$(breadcrumb_arrow_previous).removeClass('order_form_breadcrumb_arrow_active').addClass('order_form_breadcrumb_arrow_previous')
	$(breadcrumb_previous).click(function () {
		reviewStep(previous);
	})

	$('html,body').animate({
		scrollTop: 71
	});


}

function reviewStep(target) {
	$('.order_form_container').css('display', 'none');
	var container = '#order_' + target + '_container';
	$(container).css('display', 'block');
	if (container == "#order_review_container") {
		$('#order_review_formula_container').css('display', 'block');
	}
}

function reviewOrder() {

	$('#order_review_patient').html($('#patient_id option:selected').text())
	$('#order_review_formula').html($('#formula option:selected').text())
	$('#order_review_shipping').html('$' + $('#shipping_cost').val())
	$('#order_review_total').html('$' + $('#real_formula_total').val())
	$('#order_review_formula_cost').html('$' + $('#formula_cost').val())
	$('#order_review_discount').html('-$' + $('#discount_amount').val())

	$('#order_review_scoops').html($('#numberOfScoops option:selected').text())
	$('#order_review_frequency').html($('#timesPerDay').val())
	if ($('#special_instructions').val() == '') {
		$('#order_review_instructions').html('none')
	} else {
		$('#order_review_instructions').html($('#special_instructions').val())
	}
	$('#order_review_refills').html($('#refills').val())

	var shipping_type = $('input:radio[name=ship]:checked').val()

	if (shipping_type == 1) {
		$('#order_review_shipping_type').html('Ship')
		$('#order_review_shipping_options').html($('#howShip option:selected').text())
	} else {
		$('#order_review_shipping_type').html('Pickup')
		$('#order_review_shipping_options').html($('#howPickup option:selected').text())

	}

	$('#order_review_billing').html($('#billing option:selected').text())
	if ($('#notes').val() == '') {
		$('#order_review_notes').html('none')
	} else {
		$('#order_review_notes').html($('#notes').val())
	}

	var formula_id = $('#formula').val()

	var ajax_data = ''

	var ratio = parseFloat($('#formulaAdjustTotalWeight').val()) / parseFloat($('#formulaAdjustTotalWeight').data('original-weight'));
	$('#orderRatio').val(ratio);

	$.get('/formulas/view/' + formula_id + '?hide=true&ratio=' + ratio, ajax_data, function (data) {

		var content = $(data).find("#formula-view-table")
		$('#order_review_formula_table_container').html(content)
		$('#formula-view-table').DataTable({
			"iDisplayLength": 10,
			ordering: true,
			"lengthChange": false,
			"searching": false,
			"paging": false,
			"info": false,
			"order": [],
			"columnDefs": [{
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
				}
			]
		});
	});

}

function showLeavePage(target) {
	$('#confirm-leave-page').modal('show')
	$('#leave_page_button').click(function () {
		if (target == 'formulas' || target == 'patients' || target == 'users') {
			window.location = '/' + target;
		} else if ((target == 'orders') || (target == 'products') || (target == 'categories')) {
			window.location = '/store/' + target
		} else {
			if (target.indexOf('build') == -1 && target.indexOf('add') == -1) {
				window.location = '/' + target + '/add';
			} else {
				window.location = '/' + target
			}
		}
	})
	$('#leave_page_button').focus();
}

function toggleOtherAddress(target) {
	if (target == 'shipUserOther' || target == 'shipPatientOther') {
		$('#shipping_other_address_container').slideDown();
	} else {
		$('#shipping_other_address_container').slideUp();
	}
}

function showOrderConfirmation(email) {
	$('#confirmation_email').html(email)

	$('#order_confirmation_modal').modal('show')
}