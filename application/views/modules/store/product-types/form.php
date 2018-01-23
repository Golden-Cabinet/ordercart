<div>
    <h1><?php echo $title;?></h1>
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
        <?php echo form_label('Name', 'name', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo form_input(array('name' => 'name', 'id' => 'name', 'required' => 'required', 'class' => 'form-control'), $productType->name); ?>
        </div>
    </div>


    <?php if($mode == 'edit'){
        echo form_hidden('id',$productType->id);
    }
    ?>

    <div class="form-group">
        <div class="controls">
            <?php echo form_submit(array('type' => 'submit', 'value' => 'Submit', 'class' => 'btn')); ?>
        </div>
    </div>

<?php form_close(); ?>