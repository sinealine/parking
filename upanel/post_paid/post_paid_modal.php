<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel2"><i class="fa fa-add-circle"></i> Add</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
        </div>
        
     <div class="x_content">
	  <br />
        <form class="form-label-left input_mask" method="POST" action="">
            <div class="col-md-12 col-sm-12  form-group has-feedback">
				<input type="text" class="form-control" name="names" id="inputSuccess2" placeholder="Names" required>
			</div>
            
            <div class="col-md-12 col-sm-12  form-group has-feedback">
				<input type="text" class="form-control" name="phone" id="inputSuccess2" placeholder="Phone No" required>
			</div>
            
            <div class="col-md-12 col-sm-12  form-group has-feedback">
				<input type="text" class="form-control" name="company" id="inputSuccess2" placeholder="Company" required>
			</div>
            
            <div class="col-md-12 col-sm-12  form-group has-feedback">
				<input type="text" class="form-control" name="office_no" id="inputSuccess2" placeholder="Office No" required>
			</div>
            
            <div class="col-md-12 col-sm-12  form-group has-feedback">
				<input type="text" class="form-control" name="plate_no" id="inputSuccess2" placeholder="License Plate" required>
			</div>
			
			<div class="col-md-12 col-sm-12  form-group has-feedback">
			    <select class="form-control" name="sub_type">
                    <option value="" selected>Subscription Type</option>
			        <?php
			            $select= $conn->prepare("SELECT * FROM tbl_fee_settings WHERE status = 1");
                        $select->execute();
                        while($row_1 = $select->fetch()) {?>
                            <option value = <?php echo $row_1['id']; ?>><?php echo $row_1['subscription_name']; ?></option>
                        <?php
                        }
			        ?>
			    </select>
			</div>
			
			<div class="col-md-12 col-sm-12  form-group has-feedback">
				<input type="date" class="form-control" name="valid_from" min="<?php echo date("Y-m-d"); ?>" id="inputSuccess2" placeholder="Valid From" required>
			</div>
			<div class="col-md-12 col-sm-12  form-group has-feedback">
				<input type="date" class="form-control" name="valid_to" id="inputSuccess2" placeholder="Valid To" required>
			</div>
      </div>    
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="btn-save" class="btn btn-primary">Save</button>
        </div>
        </form>
      </div>
    </div>
  </div>
 <!-- /modals -->