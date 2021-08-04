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
				<input type="text" class="form-control" name="subscription_name" id="inputSuccess2" placeholder="Subscription Name" required>
			</div>
            
            <div class="col-md-12 col-sm-12  form-group has-feedback">
				<input type="text" class="form-control" name="amount" id="inputSuccess2" placeholder="Amount" required>
			</div>
			
			<div class="col-md-12 col-sm-12  form-group has-feedback">
				<input type="date" class="form-control" name="starting_period" min="<?php echo date("Y-m-d"); ?>" id="inputSuccess2" placeholder="Starting Period" required>
			</div>
			<div class="col-md-12 col-sm-12  form-group has-feedback">
				<input type="date" class="form-control" name="ending_period" id="inputSuccess2" placeholder="Ending Period" required>
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