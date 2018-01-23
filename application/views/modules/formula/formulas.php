<div class="row">
  <div class="col-xs-12">
    <div class="dashboard_container">


      <div class="row">
        <div class="col-xs-6">
          <h2 class='dashboard-title pull-left'>Formulas</h2>
        </div>
        <div class="col-xs-6">
          <div id="newuser" class="pull-right">
            <?php if ($is_admin) { ?>
              <a class="btn-default btn btn-sm" href="<?php echo base_url('formulas/share');?>">Share Formulas</a>
            <?php } ?>
              <a class="btn-primary btn btn-sm" href="<?php echo base_url('formulas/build');?>">New Formula</a>
          </div>
        </div>
      </div>


    <table id="formulas-table" class="table table-bordered table-striped table-hover table-condensed">
        <thead>
        <tr>
            <th>Name</th>
            <?php if ($is_admin) { ?>
            <th>Creator</th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach($formulas as $value):?>
            <tr>
                <td>
                  <a href="<?php echo base_url('formulas/view') . '/' . $value->id;?>"><?php echo $value->name;?></a>
                </td>
            <?php if ($is_admin) { ?>
                <td>
                  <?php if ($value->user_id != $currentUserId) {?>
                  <a href="/settings/users/edit/<?php echo $value->user_id ?>">
                  <?php }else{ ?>
                  <a href="/profile">
                  <?php } ?>
                    <?php echo "$value->firstName $value->lastName"; ?>
                  </a>
                  </td>
            <?php } ?>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

	
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