<div>
    <?php if (isset($error_messages)):?>
        <div class="modal hide fade">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Error Messages</h3>
            </div>
            <div class="modal-body">
                <?php foreach($error_messages as $message):?>
                    <p><?php echo $message;?></p>
                <?php endforeach;?>
            </div>
        </div>
    <?php endif;?>

    <?php echo form_open($path, array('class' => 'form-horizontal')); ?>

    <div class="form-group">
        <?php echo form_label('Subject', 'subject', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo form_input(array('name' => 'subject', 'id' => 'subject', 'required' => 'required', 'class' => 'form-control'), $response->subject); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo form_label('Response', 'response', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo form_textarea(array('name' => 'response', 'id' => 'response', 'required' => 'required', 'class' => 'form-control'), $response->response); ?>
        </div>
    </div>

    <?php
    echo form_hidden('message_id', $message->id);
    echo form_hidden('email', $message->email);
    ?>

    <div class="form-group">
        <div class="controls">
            <?php echo form_submit(array('type' => 'submit', 'value' => 'Send', 'class' => 'btn btn-primary')); ?>
        </div>
    </div>

    <?php form_close(); ?>

    <table class="table table-bordered table-striped table-hover table-condensed">
        <tr>
            <th>Name</th>
            <td><?php echo $message->firstName . ' ' . $message->lastName; ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo $message->email; ?></td>
        </tr>
        <tr>
            <th>Date</th>
            <td><?php echo $message->created_at; ?></td>
        </tr>
        <tr>
            <th>Question</th>
            <td><?php echo $message->question; ?></td>
        </tr>
    </table>
</div>