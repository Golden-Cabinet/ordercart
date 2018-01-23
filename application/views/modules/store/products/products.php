<div class="row">
  <div class="col-xs-12">
    <div class="dashboard_container">

          
    <div class="row">
      <div class="col-xs-6">
        <h2 class='dashboard-title pull-left'>Products</h2>
      </div>
      <div class="col-xs-6">
        <div id="newuser">
            <a class="btn-primary btn-sm pull-right" href="<?php echo base_url('store/products/add'); ?>" class="buttonPrimary">Add Product</a>
        </div>
      </div>
    </div>


    <?php if (!empty($products)): ?>
        <table id="product-table" class="tablesorter table table-bordered table-striped table-hover table-condensed">
            <thead>
            <tr>
                <th>Pinyin</th>
                <th class="hidden-xs hidden-sm">Latin name</th>
                <th>Common name</th>
                <th>Brand</th>
                <th class="hidden-xs hidden-sm">concentration</th>
                <th>Cost Per Gram</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $value): ?>
                <tr>
                    <td><?php echo $value->pinyin; ?></td>
                    <td class="hidden-xs hidden-sm"><?php echo $value->latin_name; ?></td>
                    <td><?php echo $value->common_name; ?></td>
                    <td><?php echo $value->brand_name; ?></td>
                    <td class="hidden-xs hidden-sm"><?php echo $value->concentration; ?></td>
                    <td><?php echo $value->costPerGram; ?></td>

                    <td><a href="<?php echo base_url('store/products/edit') . '/' . $value->id; ?>"><i class="fa fa-pencil"></i></a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>

        <p>There are no products created.</p>

    <?php endif; ?>

  <script type="text/javascript">
    $(function(){
      $('.table').dataTable({ 
        iDisplayLength: 20, 
        ordering:true, 
        lengthChange:false,
        language: {
              search: "_INPUT_",
              zeroRecords: "Nothing to show"
            } 
        });
  
      $('input[type=search]').attr('placeholder', 'Search');    
    })      
  </script>        


</div>
</div>
</div>