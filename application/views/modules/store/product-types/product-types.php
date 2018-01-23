<div>

    <h2 class='dashboard-title pull-left'>Product Types</h2>

    <div id="newuser">
        <a href="<?php echo base_url('store/product-types/add');?>" class="buttonPrimary">Add a new Product Type</a>
    </div>

    <?php if(!empty($productTypes)):?>
        <table class="table table-bordered table-striped table-hover table-condensed">
            <thead>
            <tr>
                <th>Name</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($productTypes as $value):?>
                <tr>
                    <td><?php echo $value->name;?></td>
                    <td><a href="<?php echo base_url('store/product-types/edit') . '/' . $value->id;?>"><i class="fa fa-pencil"></i></a></td>
                    <td><a href="<?php echo base_url('store/product-types/delete') . '/' . $value->id;?>"><i class="fa fa-remove trash"></i></a></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>

    <?php else:?>

        <p>There are no product types created.</p>

    <?php endif;?>

</div>