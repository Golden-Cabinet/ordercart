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
        <?php echo form_label('Name', 'name', array('class' => 'control-label col-sm-3')); ?>
        <div class="col-sm-9">
            <?php echo form_input(array('name' => 'name', 'id' => 'name', 'required' => 'required', 'class' => 'form-control'), $category->name); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo form_label('Parent Category', 'parent_id', array('class' => 'control-label col-sm-3'));?>
        <div class="col-sm-9">
            <select name="parent_id" class="form-control">
                <?php foreach ($categories as $value): ?>
                    <?php if($category->parent_id == $value->id):?>
                        <option value="<?php echo $value->id; ?>" selected><?php echo $value->name; ?></option>
                    <?php else:?>
                    <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                    <?php endif;?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <?php echo form_label('Description', 'description', array('class' => 'control-label col-sm-3')); ?>
        <div class="col-sm-9">
            <?php echo form_textarea(array('name' => 'description', 'id' => 'description' , 'class' => 'form-control'), $category->description); ?>
        </div>
    </div>

    <?php if($mode == 'edit'){
        echo form_hidden('id',$category->id);
    }
    ?>

    <div class="form-group text-center">
        <div class="controls">
           	<a class="header_highlighted_links btn btn-secondary" href="#" onclick="showLeavePage('categories'); return false;">Cancel</a>&nbsp;&nbsp;&nbsp; <?php echo form_submit(array('type' => 'submit', 'value' => 'Save', 'class' => 'btn btn-primary blue')); ?>
        </div>
    </div>

<?php form_close(); ?>
</div>
</div>
</div>
<?php $this->load->view('modules/includes/confirm-leave-modal.php'); ?>
