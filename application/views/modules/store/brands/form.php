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
        <?php echo form_label('Name', 'name', array('class' => 'control-label col-sm-2')); ?>
        <div class="col-sm-10">
            <?php echo form_input(array('name' => 'name', 'id' => 'name', 'required' => 'required', 'class' => 'form-control'), $brand->name); ?>
        </div>
    </div>

    <div class="form-group text-center">
        <div class="controls">
            <?php echo form_submit(array('type' => 'submit', 'value' => 'Submit', 'class' => 'btn btn-primary blue')); ?>
        </div>
    </div>

<?php form_close(); ?>
</div>
</div>
</div>