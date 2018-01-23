<!-- START VIEW FILE -->
<div id="view_formula_container">

    <h1><?php echo $title; ?></h1>

    <hr>  

    <h3 class="dashboard_headers"><?php echo $formula->name; ?></h3>
    <br>
    <p>
      <?php if ($currentUserId == $formula->creator_id || $is_admin) { ?>
      <a href="<?php echo base_url('formulas/edit') . "/$formula->id" ;?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit Formula </a>
      <?php } ?>
      <a href="<?php echo base_url('formulas/edit') . "/$formula->id/?duplicate=true" ;?>" class="btn btn-primary"><i class="fa fa-copy"></i> Duplicate Formula </a>
      <?php if ($is_admin) { ?>
      <a href="<?php echo base_url('formulas/share') . "/$formula->id";?>" class="btn btn-primary"><i class="fa fa-share"></i> Share Formula with Practitioners</a>
      <?php } ?>
    </p>
  
    <div class="clear"></div>
    <h3>Ingredients</h3>

    <table id="formula-view-table" class="table table-condensed">
        <thead>
        <th>Pinyin</th>
        <th>Common Name</th>
        <th>Latin Name</th>
        <th>Brand</th>
        <th>Concentration</th>
        <th>$/g</th>
        <th>Grams</th>
        <th>Subtotal</th>
        </thead>
        <tbody>
        <?php foreach ($ingredients as $ingredient): ?>
        <tr>
            <td><?php echo $ingredient->pinyin;?></td>
            <td><?php echo $ingredient->common_name;?></td>
            <td><?php echo $ingredient->latin_name;?></td>
            <td><?php echo $ingredient->brand_name;?></td>
            <td><?php echo $ingredient->concentration;?></td>
            <td><?php echo $ingredient->costPerGram;?></td>
            <td><?php echo round($ingredient->weight * $ratio, 1);?></td>
            <td>$<?php echo money_format('%#1.2n', $ingredient->subtotal * $ratio);?></td>
        </tr>
        <?php endforeach; ?>
				<?php if (!$hide) {?>
        <tr>
            <td><strong>Total</strong></td>
						<td> </td>
          	<td> </td>
						<td> </td>
						<td> </td>
						<td> </td>
						<td> </td>
					  <td><strong>&#36; <?php echo $cost;?></strong></td>
					</tr>
				<?php } ?>
        </tbody>
    </table>
</div>