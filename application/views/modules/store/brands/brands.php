<div class="row">
  <div class="col-xs-12">
    <div class="dashboard_container">


    <div class="row">
      <div class="col-xs-6">
        <h2 class='dashboard-title pull-left'>Brands</h2>
      </div>
      <div class="col-xs-6">
        <div id="newuser">
            <a href="<?php echo base_url('store/brands/add');?>" class="btn-primary btn-sm pull-right">Add a new brand</a>
        </div>
      </div>
    </div>

<?php if(!empty($brands)):?>
    <table class="table table-bordered table-striped table-hover table-condensed">
        <thead>
        <tr>
            <th>Brand</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($brands as $value):?>
            <tr>
                <td><?php echo $value->name;?></td>
                <td><a href="<?php echo base_url('store/brands/edit') . '/' . $value->id;?>"><i class="fa fa-pencil"></i></a></td>
                <td><a href="<?php echo base_url('store/brands/delete') . '/' . $value->id;?>"><i class="fa fa-remove trash"></i></a></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <?php else:?>

    <p>There are no brands created.</p>

    <?php endif;?>

</div>
</div>
</div>