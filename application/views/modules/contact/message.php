<div>
    <a href="<?php echo base_url('contact/respond') . '/' . $message->id;?>" class="btn btn-primary">Answer</a>
    |
    <a href="<?php echo base_url('contact/delete') . '/' . $message->id;?>" class="btn btn-danger">Delete</a>
    <br>
    <br>
<table class="table table-bordered table-striped table-hover table-condensed">
    <tr>
        <th>Name</th>
        <td><?php echo $message->firstName . ' ' . $message->lastName;?></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?php echo $message->email;?></td>
    </tr>
    <tr>
        <th>Date</th>
        <td><?php echo $message->created_at;?></td>
    </tr>
    <tr>
        <th>Question</th>
        <td><?php echo $message->question;?></td>
    </tr>
</table>
</div>