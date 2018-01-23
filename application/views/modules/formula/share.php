<div class="row">
  <div class="col-xs-12">
    <div class="dashboard_container">

      <div class="row">
        <div class="col-xs-12">
          <h2 class='dashboard-title'>Share Formulas</h2>
          <p>
            You can share formulas with practitioners through this page. Choose the formulas you wish to share from the <strong>Choose Formulas</strong> section and the practitioners you wish to share them with from the <strong>Choose Practitioners</strong> section below. The selected formulas will be <strong>copied</strong> to those practitioners account.
          </p>
        </div>
      </div>
      
      <form action="" method="post">
        <div class="row">        
          <div class="col-xs-12 col-md-4">
            <h3>Choose Formulas</h3>
            <select name="formulas[]" id="selected-formulas" multiple class='form-control' style='height:28em'>
            <?php foreach ($formulas as $formula) { ?>
              <option value="<?php echo $formula->id; ?>" <?php if ($selected_formula == $formula->id) echo " selected"; ?>>
                <?php echo "$formula->name &mdash; $formula->firstName $formula->lastName";?>
              </option>
            <?php }?>  
            </select>
            <p class='text-center'>
              <br>
              <button class='btn btn-default' data-select-all="#selected-formulas">Select All</button>
              <button class='btn btn-default' data-select-none="#selected-formulas">Select None</button>
            </p>
          
            <p class='text-center'>
              <small>Hold down Ctrl/Cmd to select multiple options</small>            
            </p>
          
          </div>
        
          <div class="col-md-4 text-center" style='margin-top:10em'>
              <p>
                Share <strong id="selected-formulas-count">Selected Formulas</strong> with <strong id="selected-users-count">Selected Practitioners</strong>
              </p>
              <p>
                <button id="share-submit" class="btn btn-primary" disabled><i class="fa fa-share"></i> Share</button>
              </p>
          </div>
        
          <div class="col-xs-12 col-md-4">
            <h3>Choose Practitioners</h3>
            <select name="users[]" id="selected-users" multiple class='form-control' style='height:28em'>
            <?php foreach ($users as $practitioner) { ?>
              <option value="<?php echo $practitioner->id; ?>"><?php echo "$practitioner->firstName $practitioner->lastName ($practitioner->email)";?></option>
            <?php }?>  
            </select>
            <p class='text-center'>
              <br>
              <button class='btn btn-default' data-select-all="#selected-users">Select All</button>
              <button class='btn btn-default' data-select-none="#selected-users">Select None</button>
            </p>
          
            <p class='text-center'>
              <small>Hold down Ctrl/Cmd to select multiple options</small>            
            </p>
          
          </div>
        </div>
      </form>
      
      <h2>Shared Formulas</h2>
      <p>
        The following formulas have already been shared with one or more practitioner. You may unshare a formula, but doing so will unshare that formual with <strong>all</strong> practitioners. There is no way around this at the moment.
      </p>
      
      <table id="share-table" class="table table-bordered table-striped table-hover table-condensed">
          <thead>
          <tr>
              <th>Formula</th>
              <th># of Practitioners Shared With</th>
              <th></th>
          </tr>
          </thead>
          <tbody>
            <?php foreach ($shared_formulas as $shared_formula) { ?>
              <tr>
                <td><a href="/formulas/view/<?php echo $shared_formula->id ?>"><?php echo $shared_formula->name ?></a></td>
                <td><?php echo $shared_formula->shares?></td>
                <td><a href="/formulas/unshare/<?php echo $shared_formula->reference_id ?>" class=""><i class="fa fa-undo"></i> Unshare</a></td>
              </tr>
            <?php }?>
          </tbody>
      </table>
      </div>
    </div>
</div>

<script>
  (function(){
    var $formulas = $('#selected-formulas'),
        $users = $('#selected-users'),
        $share_submit = $("#");

    $formulas.on("change", recalculate_counts);
    $users.on("change", recalculate_counts);
    
    // Select All/None
    $('[data-select-all],[data-select-none]').on('click', function(e){
      var data = $(this).data(),
          target = data.selectAll || data.selectNone || false,
          state = data.selectAll ? true : false;
          
      if (target) {
        $(target).find("option").prop("selected", state);
        recalculate_counts();        
      }
      
      e.preventDefault();
    });
    
    function recalculate_counts() {
      var formulas = $formulas.val() ? $formulas.val().length : 0;
      var users = $users.val() ? $users.val().length : 0;
      $('#selected-formulas-count').text(formulas  + " formula" + (formulas == 1 ? "" : "s") );
      $('#selected-users-count').text(users  + " practitioner" + (users == 1 ? "" : "s") );
      
      if (formulas > 0 && users > 0) {
        console.log("yes")
        $("#share-submit").attr("disabled",false);
      }else{
        console.log("no")
        $("#share-submit").attr("disabled",true);        
      }      
    }    
    
    recalculate_counts();  
        
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
        
  })();
</script>