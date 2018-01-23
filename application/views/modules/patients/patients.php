<?php $auth = new Authentication(); ?>
<div class="row">
  <div class="col-xs-12">
    <div class="dashboard_container">


      <div class="row">
        <div class="col-xs-6">
          <h2 class='dashboard-title pull-left'>Patients</h2>
        </div>
        <div class="col-xs-6">
          <div id="newuser">
              <a href="<?php echo base_url('patients/add');?>" class="btn-primary btn-sm pull-right">New Patient</a>
              <a href="#" class="btn-secondary btn-sm pull-right" id='hide-inactive-patients' onclick='hideInactivePatients(this)' data-inactive-patients-hidden='false'>Hide Inactive Patients</a>
          </div>          
        </div>
      </div>

    
    
    
		<div id="patient_main_table_container">
    <?php if(!empty($patients)):?>
        <table id="patient-table" class="table table-bordered table-striped table-hover table-condensed">
            <thead>
            <tr>
                <th>Patient Name</th>
                <th class="hidden-xs hidden-sm">Email</th>
<?php if ($auth->is_admin()) { ?>
                <th class="hidden-xs hidden-sm">Practitioner</th>
<?php } ?>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($patients as $value):?>
                <tr>
                    <td>
                      <a href="/patients/view/<?php echo $value->id; ?>"><?php echo $value->firstName . ' ' . $value->lastName;?></a><?php if ($value->deleted != 0): ?> <span class='inactive-label'>Inactive</span><?php endif; ?>
                      </td>
                    <td class="hidden-xs hidden-sm"><a href="mailto: <?php echo $value->email;?>"><?php echo $value->email;?></a></td>
                		<?php if ($auth->is_admin()) { ?>
								    <td class="hidden-xs hidden-sm"><?php echo $value->practitionerFirstName . ' ' . $value->practitionerLastName;?></td>
              			<?php } ?>
							      <td><a href="<?php echo base_url('patients/edit') . '/' . $value->id;?>"><i class="fa fa-pencil"></i></a></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>

    <?php else:?>

      <table id="patient-table" class="table table-bordered table-striped table-hover table-condensed"><thead>
        <tr>
            <th>Patient Name</th>
            <th>Email</th>
<?php if ($auth->is_admin()) { ?>
            <th>Practitioner</th>
<?php } ?>
            <th>Edit</th>
        </tr>
      </thead>
			<tbody>
			</tbody>
      </table>

    <?php endif;?>
		</div>

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