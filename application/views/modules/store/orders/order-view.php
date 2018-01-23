<!-- START VIEW FILE -->
<div>

    <h1>
        <?php echo $title; ?>
    </h1>

    <div id="order_view_left">

        <?php

    $auth = new Authentication();

        if ($orderDetails->updated_at == '0000-00-00 00:00:00') {
            $status_updated = "NA";
        } else {
            $status_updated = date("F j, Y, g:i a", strtotime($orderDetails->created_at));
        };
?>

            <strong>Order ID:</strong>
            <?php echo $orderDetails->id ?> <br>
            <strong>Patient:</strong>
            <?php echo $orderDetails->patientFirstName. ' ' . $orderDetails->patientLastName; ?>
            <a href="mailto: <?php echo $orderDetails->patientEmail; ?>" target="_blank"><?php echo $orderDetails->patientEmail; ?></a><br
            />
            <strong>Status:</strong> <span id="current_status"><?php echo $orderDetails->status;?></span> (updated
            <span
                id="date_updated">
                <?php echo $status_updated; ?>)</span><br />
                <strong>Order Date:</strong>
                <?php echo date("F j, Y, g:i a", strtotime($orderDetails->created_at)); ?><br />
                <strong>Dosage:</strong>
                <?php echo $orderDetails->numberOfScoops;?>,
                <?php echo $orderDetails->timesPerDay;?><br />
                <strong>Payment Info:</strong>
                <?php echo $payment;?><br />
                <strong>Shipping Info:</strong>
                <?php echo $shipping['shipping_Address'];?><br />

                <?php if ($orderDetails->notes) { ?>
                <strong>Notes</strong>
                <p>
                    <?php echo $orderDetails->notes;?>
                </p>
                <?php } ?>

                <?php if ($orderDetails->instructions) { ?>
                <strong>Special Instructions:</strong>
                <p>
                    <?php echo $orderDetails->instructions;?>
                </p>
                <?php } ?>
                <?php    if ($auth->is_admin()):?> Practitioner:
                <?php echo $orderDetails->practitionerFirstName . ' ' . $orderDetails->practitionerLastName; ?><br />
                <br />
                <form action="" accept-charset="utf-8" method="post">
                    <span><strong>Update Order Status</strong></span>
                    <select id="selected_status">
            <option value="0" <?php if ($orderDetails->status=="Processing") {echo 'selected="selected"'; } ?>>Processing</option>
            <option value="1" <?php if ($orderDetails->status=="Ready For Pick up") {echo 'selected="selected"'; } ?>>Ready For Pick up</option>
            <option value="2" <?php if ($orderDetails->status=="Completed - Shipped") {echo 'selected="selected"'; } ?>>Completed - Shipped</option>
            <option value="3" <?php if ($orderDetails->status=="Completed - Picked up") {echo 'selected="selected"'; } ?>>Completed - Picked up</option>
            <option value="4" <?php if ($orderDetails->status=="Cancelled") {echo 'selected="selected"'; } ?>>Cancelled</option>
        </select>

                    <input type="hidden" id="order_id" name="order_id" value="<?php echo $orderDetails->id;?>">

                    <input type="button" id="update_status" class="btn btn-primary" value="Update Status"></input>

                </form>


                <?php endif;?>
    </div>
    <div id="order_view_right">
        <strong>Formula:</strong>
        <?php echo $formula['name']; ?>

        <table id="formula-table" class="table table-condensed">
            <thead>
                <th>Pinyin</th>
                <th>$/g</th>
                <th>Grams</th>
                <th>Sub Total</th>
            </thead>
            <tbody>
                <?php 
          $total_grams = 0;
          foreach ($ingredients as $ingredient): ?>
                <tr>
                    <td>
                        <?php echo $ingredient['pinyin']; ?>
                    </td>
                    <td>
                        <?php echo $ingredient['costPerGram']; ?>
                    </td>
                    <td>
                        <?php echo $ingredient['weight']; ?>
                    </td>
                    <td>&#36;
                        <?php echo $ingredient['subtotal'] ; ?>
                    </td>
                </tr>
                <?php 
          $total_grams += ($ingredient['weight']);        
          endforeach; ?>
                <tr>
                    <td><strong>Formula Cost</strong></td>
                    <td></td>
                    <td></td>
                    <td><strong>&#36; <?php echo $formula_cost; ?></strong></td>
                </tr>
                <tr>
                    <td><strong>Discount</strong></td>
                    <td></td>
                    <td></td>
                    <td><strong>&#36; 
								<?php if ($orderDetails->sub_total < $formula_cost) {
									$discount = (float)$orderDetails->sub_total - (float)$formula_cost;
									echo number_format($discount,2); 
								} else {
									echo "0.00";
								} ?>
							</strong></td>
                </tr>
                <tr>
                    <td><strong>Sub Total</strong></td>
                    <td></td>
                    <td></td>
                    <td><strong>&#36; <?php echo $orderDetails->sub_total; ?></strong></td>
                </tr>
                <tr>
                    <td><strong>Shipping</strong></td>
                    <td></td>
                    <td></td>
                    <td><strong>&#36; <?php echo $orderDetails->shipping_cost; ?></strong></td>
                </tr>
                <tr>
                    <td><strong>Totals</strong></td>
                    <td></td>
                    <td>
                        <strong><?php echo $total_grams; ?></strong>
                    </td>
                    <td><strong>&#36; <?php echo $orderDetails->total_cost; ?></strong></td>
                </tr>
                <tr>
                    <td><strong>Dividends Earned</strong></td>
                    <td></td>
                    <td></td>
                    <td><strong>&#36;	<?php if ($orderDetails->dividend > 0) {
							echo $orderDetails->dividend; 
						} else {
							echo "0.00";
						} ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="clear"></div>

    <div class="modal fade" id="status_success_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> Status was successfully
                    updated.
                </div>
                <div class="modal-body" id="required_field_modal_content">
                </div>
            </div>
        </div>

    </div>
    <script>
        $(document).ready(function () {

            $('#formula-table').DataTable({
                "iDisplayLength": 20,
                ordering: false,
                "lengthChange": false,
                "searching": false,
                "paging": false,
                "info": false
            });

            $('input#update_status.btn').on("click", function () {

                var status = $("select#selected_status").val();
                var order_id = $('input#order_id').val();
                var selector = "select#selected_status option[value='" + status + "']";
                var statusText = $(selector).text();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('
                    store / orders / update / status ');?>',
                    data: {
                        order_id: order_id,
                        status: status
                    },
                    success: function (data) {
                        var info = JSON.parse(data);
                        $("span#date_updated").html(info.date);
                        $("span#current_status").html(statusText);
                        $('#status_success_modal').modal('show')
                    }
                });

            });

        }); // end document.ready
    </script>

</div>