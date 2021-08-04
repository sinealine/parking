<?php 
    if(ISSET($_POST['btn-update'])){
		
		try{
		    
		    $u_data = $_POST['u_data'];
			$u_names = $_POST['u_names'];
			$user_name = $_POST['user_name'];
			$u_password = $_POST['u_password'];
			$u_email = $_POST['u_email'];
			$u_phone = $_POST['u_phone'];
			
			if(!empty($u_password)){
			    //for Updating user with new password
    			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    			$sql = " UPDATE tbl_user_access SET u_names='$u_names',username='$user_name',password=ENCODE('".htmlspecialchars($_POST['u_password'],ENT_QUOTES)."','itecltd'),email='$u_email',phone='$u_phone' WHERE u_id='$u_data' ";
    			$conn->exec($sql);
    			$lastId = $conn->lastInsertId();
    			
    			$messave=" $user_name Your Profile Have Been Successfully Updated ";
			}else{
			    //for Updating user with out new password
    			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    			$sql = " UPDATE tbl_user_access SET u_names='$u_names',username='$user_name',email='$u_email',phone='$u_phone' WHERE u_id='$u_data' ";
    			$conn->exec($sql);
    			$lastId = $conn->lastInsertId();
    			
    			$messave=" $user_name Your Profile Have Been Successfully Updated ";
			}
			
			

		}catch(PDOException $e){
			echo $e->getMessage();
		}
		
		echo'<meta http-equiv="refresh"'.'content="3;URL=index?page=users">'; 
    }
?>
<!-- page content -->
    <div class="right_col" role="main">
        <div class="page-title">
          <div class="title_left">
            <h3><small>My Profile Data</small></h3>
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
        
            $user_data = $u_id;
            
            $select= $conn->prepare("SELECT * FROM tbl_user_access,tbl_function WHERE tbl_user_access.function=tbl_function.fnct_id AND tbl_user_access.u_id='$user_data' ");
            $select->execute();
            while($row_1 = $select->fetch())
            {
                $fnct_ID = $row_1['fnct_id'];
                $user_id = $row_1['u_id'];
                $fnct_full_name = $row_1['fnct_full_name'];
                $user_function = $row_1['function'];
                $user_name = $row_1['username'];
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
									<input type="hidden" class="form-control" name="u_data" value="<?php echo $row_1['u_id'];?>" placeholder="Names" required>
                				    <input type="text" class="form-control" name="u_names" value="<?php echo $row_1['u_names'];?>" placeholder="Names" required>
								</div>
							</div>
            			    
            			    <div class="item form-group">
								<label class="col-form-label col-md-2 " for="first-name">Username <span class="required">*</span>
								</label>
								<div class="col-md-9">
								    <input type="text" class="form-control" name="user_name" value="<?php echo $row_1['username'];?>" placeholder="Username" required>
								</div>
							</div>
							
							<div class="item form-group">
								<label class="col-form-label col-md-2 " for="first-name">Password <span class="required">*</span>
								</label>
								<div class="col-md-9">
								    <input type="text" class="form-control" name="u_password" placeholder="Password" >
								</div>
							</div>
							
            			    <div class="item form-group">
								<label class="col-form-label col-md-2 " for="first-name">Email <span class="required">*</span>
								</label>
								<div class="col-md-9">
								    <input type="email" class="form-control" name="u_email" value="<?php echo $row_1['email'];?>" placeholder="Email" required>
								</div>
							</div>
							
							<div class="item form-group">
								<label class="col-form-label col-md-2 " for="first-name">Phone <span class="required">*</span>
								</label>
								<div class="col-md-9">
								    <input type="number" class="form-control" name="u_phone" value="<?php echo $row_1['phone'];?>" placeholder="Phone" required>
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