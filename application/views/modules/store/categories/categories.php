<div class="row">
  <div class="col-xs-12">
    <div class="dashboard_container">
      
          
    <div class="row">
      <div class="col-xs-6">
        <h2 class='dashboard-title pull-left'>Category</h2>
      </div>
      <div class="col-xs-6">
        <div id="newuser">
            <a class="btn-primary btn-sm pull-right" href="<?php echo base_url('store/categories/add');?>" class="buttonPrimary">Add Category</a>
        </div>
      </div>
    </div>
    
    
		<div class="clear"></div>
<?php if(!empty($categories)):?>
    <table id="category-table" class="table table-bordered table-striped table-hover table-condensed">
        <thead>
        <tr>
            <th>Category</th>
            <th>Edit</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($categories as $value):?>
            <tr>
                <td><?php echo $value->name;?></td>
                <td><a href="<?php echo base_url('store/categories/edit') . '/' . $value->id;?>"><i class="fa fa-pencil"></i></a></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <?php else:?>

    <p>There are no categories created.</p>

    <?php endif;?>


  <script type="text/javascript">
    $(function(){
      $('.table').dataTable({ 
        iDisplayLength: 10, 
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