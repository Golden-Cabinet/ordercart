<h3>Billing </h3>
<div class="form-group">
    <?php echo form_label('Billing Options', 'billing', array('class' => 'control-label')); ?>
    <div class="controls">
        <select name="billing" id="billing" class="form-control">
            <option value="chargeUserCard">Charge my card on file</option>
            <option value="callInCard">I will call with my credit card information</option>
            <option value="pickUpFormula">I will pay when I pick up the formula</option>
            <option value="patientPay">Patient will pay</option>
        </select>
    </div>
</div>

<div class="form-group text-center">
  <a class="header_highlighted_links btn btn-secondary" href="#" onclick="showLeavePage('orders'); return false;">Cancel</a>&nbsp;&nbsp;&nbsp;
  <a class="btn btn-primary blue"  onclick="orderAdvanceStep('notes', 'shipping'); return false;">Notes <i class="fa fa-arrow-right"></i></a><br />
</div>

<br />

<a href="#" onclick="reviewStep('dosage'); return false;">&#8592; Back to Dosage</a>

<div class="order_navigation_warning">If you hit the "Back" button on your browser, the order will be cancelled.</div>
