<h3>Notes</h3>
<div class="form-group">

    <div class="controls">
        <?php echo form_textarea(array('name' => 'notes', 'id' => 'notes', 'class' => 'form-control'), set_value('notes')); ?>
    </div>
</div>
<div class="clear"></div>
<a class="header_highlighted_links" href="#" onclick="showLeavePage('orders'); return false;">Cancel</a>&nbsp;&nbsp;&nbsp;<a class="button blue"  onclick="orderAdvanceStep('review', 'notes'); return false;">Review and Submit <i class="fa fa-arrow-right"></i></a><br />
<br />
<a href="#" onclick="reviewStep('shipping'); return false;">&#8592; Back to Shipping/Billing</a>

<div class="order_navigation_warning">If you hit the "Back" button on your browser, the order will be cancelled.</div>

