<div class="row">
  <div class="col-xs-12">
    <div class="dashboard_container">
      
      <div class="row">
        <div class="col-xs-6">
          <h2 class='dashboard-title pull-left'>Users</h2>
        </div>
        <div class="col-xs-6">
    	    <div id="newuser">
    		    <a href="<?php echo base_url('settings/users/add');?>" class="btn-primary btn-sm pull-right">New user</a>
    	    </div>          
        </div>
      </div>
      


    <table class="table table-bordered table-striped table-hover table-condensed" id="users_table">
        <thead>
        <tr>
            <th>Name</th>
            <th class="hidden-xs hidden-sm">State</th>
            <th class="hidden-xs hidden-sm">Role</th>
            <th>Approved</th>
            <th class="hidden-xs hidden-sm">Email</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($users as $value):?>
        <tr>
            <td><?php echo $value->firstName . ' ' . $value->lastName;?></td>
            <td class="hidden-xs hidden-sm"><?php echo $value->state_name;?></td>
            <td class="hidden-xs hidden-sm"><?php echo $value->role_name;?></td>
            <td><?php echo $value->status;?></td>
            <td class="hidden-xs hidden-sm"><?php echo $value->email;?></td>
            <td><a href="<?php echo base_url('settings/users/edit') . '/' . $value->id;?>"><i class="fa fa-pencil"></i></a></td>
            </tr>
<?php endforeach;?>
        </tbody>
    </table>

    <?php echo $links; ?>

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
