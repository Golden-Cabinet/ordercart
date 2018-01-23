<div class="row">
  <div class="col-xs-12 col-md-6">
    <div class="dashboard_container">
  
    <h1 class='dashboard-title'><?php echo $title; ?></h1>
    <hr>

    <?php if (isset($error_messages)): ?>
        <div class="well">
            <?php foreach ($error_messages as $message): ?>
                <p><?php echo $message; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php echo form_open($path, array('class' => 'form-horizontal')); ?>

    <div class="form-group">
        <?php echo form_label('Pinyin', 'pinyin', array('class' => 'control-label col-sm-3')); ?>
        <div class="col-sm-9">
            <?php echo form_input(array('name' => 'pinyin', 'id' => 'pinyin', 'required' => 'required', 'class' => 'form-control'), $product->pinyin); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo form_label('Latin name', 'latin_name', array('class' => 'control-label col-sm-3')); ?>
        <div class="col-sm-9">
            <?php echo form_input(array('name' => 'latin_name', 'id' => 'latin_name', 'class' => 'form-control'), $product->latin_name); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo form_label('Common name', 'common_name', array('class' => 'control-label col-sm-3')); ?>
        <div class="col-sm-9">
            <?php echo form_input(array('name' => 'common_name', 'id' => 'common_name', 'class' => 'form-control'), $product->common_name); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo form_label('Brand', 'brand_id', array('class' => 'control-label col-sm-3')); ?>
        <div class="col-sm-9">
            <select name="brand_id" class="form-control">
              	<option value="" checked="">Choose...</option>
                <?php foreach ($brands as $value): ?>
                    <?php if($product->brand_id == $value->id):?>
                        <option value="<?php echo $value->id; ?>" selected="selected"><?php echo $value->name; ?></option>
                    <?php else:?>
                        <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                    <?php endif;?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- <div class="form-group">
        <?php // echo form_label('Type', 'type_id', array('class' => 'control-label col-sm-3')); ?>
        <div class="col-sm-9">
            <select name="type_id" class="input-xlarge">
              	<option value="" checked="">Choose...</option>
                <?php // foreach ($productTypes as $value): ?>
                    <?php // if($product->type_id == $value->id):?>
                        <option value="<?php //echo $value->id; ?>" selected="selected"><?php //echo $value->name; ?></option>
                    <?php // else:?>
                        <option value="<?php //echo $value->id; ?>"><?php //echo $value->name; ?></option>
                    <?php // endif;?>
                <?php // endforeach; ?>
            </select>
        </div>
    </div> -->
		<input type="hidden" name="type_id" id="type_id" value='1'>

    <div class="form-group">
        <?php echo form_label('Concentration', 'concentration', array('class' => 'control-label col-sm-3')); ?>
        <div class="col-sm-9">
            <?php echo form_input(array('name' => 'concentration', 'id' => 'concentration', 'class' => 'form-control'), $product->concentration); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo form_label('Cost/gram', 'costPerGram', array('class' => 'control-label col-sm-3')); ?>
        <div class="col-sm-9">
            <?php echo form_input(array('name' => 'costPerGram', 'id' => 'costPerGram', 'required' => 'required', 'class' => 'form-control'), $product->costPerGram); ?>
        </div>
    </div>

    <?php if($mode == 'edit'){
        echo form_hidden('id',$product->id);
    }
    ?>




    <div class="form-group text-center">
        <div class="col-xs-12">
           	<a class="header_highlighted_links btn btn-secondary" href="#" onclick="showLeavePage('products'); return false;">Cancel</a>&nbsp;&nbsp;&nbsp;
					  <?php echo form_submit(array('type' => 'submit', 'value' => 'Save', 'class' => 'btn btn-primary blue')); ?>
          
						<?php if ($mode != 'add') { ?>
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="#" class="" onclick="confirmDeleteFormula(); return false;">Delete product</a>
						<?php } ?>
        </div>
    </div>

<?php form_close(); ?>

    </div>

		<?php $this->load->view('modules/includes/confirm-leave-modal.php'); ?>

		
		<div class="modal fade" id="delete_confirmation_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
	            <div class="modal-header">
							  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
						  	<b>Are you sure you want to delete <?php echo $product->common_name; ?>?</b><br />
						<br />
            <!-- <b>You can not undo this.</b> -->
	            </div>
		          <div class="modal-body" id="required_field_modal_content">
								<a href="/store/products/delete/<?php echo $product->id; ?>" class="btn">Delete</a>
								<a href="#" data-dismiss="modal" aria-hidden="true">Cancel</a>
	            </div>
		        </div>
		    </div>

</div>
</div>
</div>
    