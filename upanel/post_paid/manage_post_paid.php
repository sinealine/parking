<?php
if (isset($_POST['btn-save'])) {

  try {
    $names = $_POST['names'];
    $sub_type = $_POST['sub_type'];
    $phone = $_POST['phone'];
    $company = $_POST['company'];
    $office_no = $_POST['office_no'];
    $plate_no = $_POST['plate_no'];
    $valid_from = $_POST['valid_from'];
    $valid_to = $_POST['valid_to'];
    $user = $u_id;

    //for new user
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = " INSERT INTO post_paid_card(fee_id, names, phone, company, office_no, plate_no, valid_from, valid_to, reg_date, user) 
			        VALUES ('$sub_type','$names','$phone','$company','$office_no','$plate_no','$valid_from','$valid_to',CURDATE(),'$user')";
    $conn->exec($sql);

    $messave = "New Record Successfully added";
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  echo '<meta http-equiv="refresh"' . 'content="3;URL=index?page=post_paid">';
}

// Updating User Function by select

if (isset($_GET['post_paid_data'])) {
  try {
    $id = $_GET['fee_data'];
    $subname = $_GET['subscription_name'];
    $amount = $_GET['amount'];
    $starting = $_GET['starting_period'];
    $ending = $_GET['ending_period'];
    $user = $_GET['user'];

    //for Updating fee
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = " UPDATE tbl_fee_settings SET subscription_name = $subname, amount = $amount, starting_period = $starting, starting_period = $ending WHERE id = '$id'; ";
    $conn->exec($sql);

    $messave = " Fee Updated ";
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  echo '<meta http-equiv="refresh"' . 'content="3;URL=index?page=post_paid">';
}

// Deleting User

if (isset($_GET['delete_id'])) {
  try {

    $delete_data = $_GET['delete_id'];

    //for Deleting user
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = " DELETE FROM post_paid_card WHERE pp_id='$delete_data' ";
    $conn->exec($sql);

    $delete_msg = " Record Has Been Deleted Successfuly ";
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  echo '<meta http-equiv="refresh"' . 'content="3;URL=index?page=post_paid">';
}
?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><small>Manage Post Paid</small></h3>
            </div>
            <?php include '../inc/search.php'; ?>
        </div>

        <div class="clearfix"></div>

        <?php if (isset($messave)) { ?>
        <div class="alert alert-success alert-dismissible " role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">×</span>
            </button>
            <strong>Well done!</strong> <?php echo htmlentities($messave); ?>
        </div>
        <?php } ?>

        <?php if (isset($delete_msg)) { ?>
        <div class="alert alert-danger alert-dismissible " role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">×</span>
            </button>
            <strong>Well done!</strong> <?php echo htmlentities($delete_msg); ?>
        </div>
        <?php } ?>

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><small>View | Add new fee</small></h2>

                        <ul class="nav navbar-right panel_toolbox">
                            </li>
                            <li><button class="btn btn-success" data-toggle="modal"
                                    data-target=".bs-example-modal-sm"><i class="fa fa-plus"></i> Add</button>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <?php
            $select = $conn->prepare("SELECT * FROM post_paid_card");
            $select->execute();

            if ($select->rowCount() != 0) {
            ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">

                                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                            <tr>
                                                <th>#</th>
                                                <th>Names</th>
                                                <th>Phone No.</th>
                                                <th>Company</th>
                                                <th>Office No</th>
                                                <th>License Plate</th>
                                                <th>Subscription Name</th>
                                                <th>Valid From</th>
                                                <th>Valid To</th>
                                                <th>Status</th>
                                                <th>Registered On</th>
                                                <th>User</th>
                                                <?php if ($_SESSION['function'] == "1" || $_SESSION['function'] == "2") { ?>
                                                <th>ACTION</th>
                                                <?php } ?>
                                            </tr>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                        $i = 0;
                        while ($row_1 = $select->fetch()) {
                          $id = $row_1['pp_id'];
                          $names = $row_1['names'];
                          $phone = $row_1['phone'];
                          $company = $row_1['company'];
                          $office_no = $row_1['office_no'];
                          $plate_no = $row_1['plate_no'];
                          $fee_id = $row_1['fee_id'];
                          $select1 = $conn->prepare("SELECT * FROM tbl_fee_settings where id = '$fee_id'");
                          $select1->execute();
                          $fetch_fee = $select1->fetch();

                          $valid_from = $row_1['valid_from'];
                          $valid_to = $row_1['valid_to'];
                          $status = $row_1['status'];
                          $reg_on = $row_1['reg_date'];
                          $user = $row_1['user'];
                          $sql2 = "SELECT* FROM tbl_user_access WHERE u_id ='$user'";
                          $res = $conn->prepare($sql2);
                          $res->execute();
                          $username = $res->fetch();
                          $i++;
                        ?>
                                            <tr>
                                                <th scope="row"><?php echo $i; ?></th>
                                                <td><?php echo $names; ?></td>
                                                <td><?php echo $phone; ?></td>
                                                <td><?php echo $company; ?></td>
                                                <td><?php echo $office_no; ?></td>
                                                <td><?php echo $plate_no; ?></td>
                                                <td><?php echo $fetch_fee['subscription_name']; ?></td>
                                                <td><?php echo $valid_from; ?></td>
                                                <td><?php echo $valid_to; ?></td>
                                                <td>
                                                    <?php
                              if ($status == 1) { ?>
                                                    <div class="switch-container">
                                                        <div class="post-paid-btn .switch-toggle-btn active"
                                                            id=<?php echo $id; ?>>
                                                            <div class="circle"></div>
                                                        </div>
                                                    </div>
                                                    <?php
                              } else { ?>
                                                    <div class="switch-container">
                                                        <div class="post-paid-btn post-paid-btn" id=<?php echo $id; ?>>
                                                            <div class="circle"></div>
                                                        </div>
                                                    </div>
                                                    <?php
                              }
                              ?>
                                                </td>
                                                <td><?php echo $reg_on; ?></td>
                                                <td><?php echo $username['username']; ?></td>
                                                <?php if ($_SESSION['function'] == "1" || $_SESSION['function'] == "2") { ?>
                                                <td><a
                                                        href="index.php?page=update_post_paid&post_paid_data=<?php echo $id; ?>"><i
                                                            class="fa fa-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;
                                                    |&nbsp;&nbsp;&nbsp;<a
                                                        href="index?page=post_paid&delete_id=<?php echo $id; ?>"><i
                                                            class="fa fa-trash"></i> Delete</a></td>
                                                <?php } ?>
                                            </tr>
                                            <?php
                        }
                        ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php
            } else {
              ?>
                            <div class="col-sm-12">
                                <div class="alert alert-success alert-dismissible " role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">×</span>
                                    </button>
                                    <strong>Sorry!</strong> Currently no fee available.
                                </div>

                            </div>
                            <?php
            }
              ?>
                        </div>
                        <!--row -->
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- /page content -->


<?php include 'post_paid/post_paid_modal.php'; ?>