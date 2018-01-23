<div>

    <h2 class='dashboard-title pull-left'>Products</h2>

<?php
$auth = new Authentication();
if(!empty($products)):?>
    <table class="table table-bordered table-striped table-hover table-condensed">
        <thead>
        <tr>
            <th>Pinyin</th>
            <th>Latin name</th>
            <th>Common name</th>
            <th>Brand</th>
            <?php if ($auth->is_logged_in()):?>
            <th>concentration</th>
            <th>Cost Per Gram</th>
            <?php endif;?>
        </tr>
        </thead>
        <tbody>
        <?php foreach($products as $value):?>
            <tr>
                <td><?php echo $value->pinyin;?></td>
                <td><?php echo $value->latin_name;?></td>
                <td><?php echo $value->common_name;?></td>
                <td><?php echo $value->brand_name;?></td>
                <?php
                $auth = new Authentication();
                if ($auth->is_logged_in()):?>
                <td><?php echo $value->concentration;?></td>
                <td><?php echo $value->costPerGram;?></td>
                <?php endif;?>

            </tr>
        <?php endforeach;?>
        </tbody>
    </table>


    <?php echo $links; ?>

    <?php else:?>

    <p>There are no products with this category created.</p>

    <?php endif;?>

</div>