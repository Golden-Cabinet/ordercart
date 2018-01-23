<div>

    <h2 class='dashboard-title pull-left'>Messages</h2>

    <?php $this->load->view('modules/messages/message');?>

    <?php if(!empty($messages)):?>
        <table class="table table-bordered table-striped table-hover table-condensed">
            <thead>
            <tr>
                <th>Date</th>
                <th>Name</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($messages as $value):?>
                <tr>
                    <td><?php echo $value->created_at;?></td>
                    <td><?php echo $value->firstName . ' ' . $value->lastName;?></td>
                    <td><a href="<?php echo base_url('contact/message') . '/' . $value->id;?>"><i class="fa fa-eye"></i> View</a></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>

        <?php echo $links; ?>
    <?php else:?>

        <p>There are no messages.</p>

    <?php endif;?>

</div>