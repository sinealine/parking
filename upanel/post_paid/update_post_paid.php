<?php 
    if(ISSET($_POST['btn-update'])){
		
		try{
		    $id = $_POST['id'];
		    $sub_type = $_POST['sub_type'];
			$names = $_POST['names'];
			$phone = $_POST['phone'];
			$company = $_POST['company'];
			$office_no = $_POST['office_no'];
			$plate_no = $_POST['plate_no'];
			$valid_from = $_POST['valid_from'];
			$valid_to = $_POST['valid_to'];
			
			//for new user
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = " UPDATE post_paid_card SET fee_id='$sub_type',names='$names',phone='$phone',company='$company',office_no='$office_no',valid_from='$valid_from',valid_to='$valid_to' WHERE pp_id='$id' ";
			$conn->exec($sql);
			
			$messave=" Record Updated Successfully ";

		}catch(PDOException $e){
			echo $e->getMessage();
		}
		
		echo'<meta http-equiv="refresh"'.'content="3;URL=index?page=post_paid">'; 
    }
?>
<!-- page content -->
    <div class="right_col" role="main">
        <div class="page-title">
          <div class="title_left">
            <h3><small>Update Post Paid</small></h3>
          </div>
          <?php include '../inc/search.php'; ?>
        </div>
       
        <div class="clearfix"></div>
        
        <?php if($messave){?>
            <div class="alert alert-success alert-dismissible " role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <strong>Well done!</strong> <?php echo htmlentities($messave); ?> 
            </div>
        <?php } ?>
        
        <?php
        
            $post_paid_data = $_GET['post_paid_data'];
            
            $select= $conn->prepare("SELECT * FROM post_paid_card WHERE pp_id = $post_paid_data ");
            $select->execute();
            while($row_1 = $select->fetch())
            {
        ?>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_content">
                        <br />
            	        <form class="form-label-left input_mask" method="POST" action="">
							<div class="item form-group">
								<label class="col-form-label col-md-2 " for="first-name">Names <span class="required">*</span>
								</label>
								<div class="col-md-9">
								    <input type="text" class="form-control" name="id" value="<?php echo $post_paid_data;?>" hidden>
								    <input type="text" class="form-control" name="names" value="<?php echo $row_1['names'];?>" placeholder="Names" required>
								</div>
							</div>
							
							<div class="item form-group">
								<label class="col-form-label col-md-2 " for="first-name">Phone <span class="required">*</span>
								</label>
								<div class="col-md-9">
								    <input type="text" class="form-control" name="phone" value="<?php echo $row_1['phone'];?>" placeholder="Phone No" required>
								</div>
							</div>
							
							<div class="item form-group">
								<label class="col-form-label col-md-2 " for="first-name">Company <span class="required">*</span>
								</label>
								<div class="col-md-9">
								    <input type="text" class="form-control" name="company" value="<?php echo $row_1['company'];?>" placeholder="Company" required>
								</div>
							</div>
							
							<div class="item form-group">
								<label class="col-form-label col-md-2 " for="first-name">Office No <span class="required">*</span>
								</label>
								<div class="col-md-9">
								    <input type="text" class="form-control" name="office_no" value="<?php echo $row_1['office_no'];?>" placeholder="Office No" required>
								</div>
							</div>
							
            			    <div class="item form-group">
								<label class="col-form-label col-md-2 " for="first-name">Subscription Type. <span class="required">*</span>
								</label>
								<div class="col-md-9">
								    <select class="form-control" name="sub_type">
								        <?php
								            $feeid = $row_1['fee_id'];
								            $select1= $conn->prepare("SELECT * FROM tbl_fee_settings WHERE id = $feeid");
                                            $select1->execute();
                                            $row_2 = $select1->fetch();
                                            ?>
                                        <option value="<?php echo $row_2['fee_id'];?>" selected><?php echo $row_2['subscription_name'];?></option>
                                        ?>
                    			        <?php
                    			            $select2= $conn->prepare("SELECT * FROM tbl_fee_settings WHERE status = 1 and id != $feeid");
                                            $select2->execute();
                                            while($row_3 = $select2->fetch()) {?>
                                                <option value = <?php echo $row_3['id']; ?>><?php echo $row_3['subscription_name']; ?></option>
                                            <?php
                                            }
                    			        ?>
                    			    </select>
								</div>
							</div>
							
							<div class="item form-group">
								<label class="col-form-label col-md-2 " for="first-name">License Plate <span class="required">*</span>
								</label>
								<div class="col-md-9">
								    <input type="text" class="form-control" name="plate_no" value="<?php echo $row_1['plate_no'];?>" placeholder="License Plate" required>
								</div>
							</div>
							
            			    <div class="item form-group">
								<label class="col-form-label col-md-2 " for="first-name">Valid From <span class="required">*</span>
								</label>
								<div class="col-md-9">
								    <input type="date" class="form-control" name="valid_from" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $row_1['valid_from'];?>" placeholder="Valid From" required>
								</div>
							</div>
							
            			    <div class="item form-group">
								<label class="col-form-label col-md-2 " for="first-name">Valid To <span class="required">*</span>
								</label>
								<div class="col-md-9">
								    <input type="date" class="form-control" name="valid_to" value="<?php echo $row_1['valid_to'];?>" placeholder="Valid To" required>
								</div>
							</div>
                			
                		</div>    
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" name="btn-update" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
        ?>
    </div>
<!-- /page content -->