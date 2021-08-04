<?php
if (isset($_POST['btn-save'])) {

  try {

    $subname = $_POST['subscription_name'];
    $amount = $_POST['amount'];
    $starting = $_POST['starting_period'];
    $ending = $_POST['ending_period'];
    $user = $u_id;

    //for new user
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = " INSERT INTO tbl_fee_settings(subscription_name, amount, starting_period, ending_period, user) 
			        VALUES ('$subname','$amount','$starting','$ending','$user')";
    $conn->exec($sql);

    $messave = "New Fee Successfully added";
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  echo '<meta http-equiv="refresh"' . 'content="3;URL=index.php?page=fee_settings">';
}

// Updating User Function by select

if (isset($_GET['fee_data'])) {
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

  echo '<meta http-equiv="refresh"' . 'content="3;URL=index.php?page=fee_settings">';
}

// Deleting User

if (isset($_GET['delete_id'])) {
  try {

    $delete_data = $_GET['delete_id'];

    //for Deleting user
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = " DELETE FROM tbl_fee_settings WHERE id='$delete_data' ";
    $conn->exec($sql);

    $delete_msg = " Fee Have Been Deleted Successfuly ";
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  echo '<meta http-equiv="refresh"' . 'content="3;URL=index.php?page=fee_settings">';
}
?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><small>Manage Fee Settings</small></h3>
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
            $select = $conn->prepare("SELECT * FROM tbl_fee_settings");
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
                                                <th>Subscription Name</th>
                                                <th>Amount</th>
                                                <th>Starting Period</th>
                                                <th>Ending Period</th>
                                                <th>User</th>
                                                <th>Status</th>
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
                          $id = $row_1['id'];
                          $sub_name = $row_1['subscription_name'];
                          $amount = $row_1['amount'];
                          $starting = $row_1['starting_period'];
                          $ending = $row_1['ending_period'];
                          $user = $row_1['user'];
                          $status = $row_1['status'];
                          $sql2 = "SELECT* FROM tbl_user_access WHERE u_id ='$user'";
                          $res = $conn->prepare($sql2);
                          $res->execute();
                          $username = $res->fetch();
                          $i++;
                        ?>
                                            <tr>
                                                <th scope="row"><?php echo $i; ?></th>
                                                <td><?php echo $sub_name; ?></td>
                                                <td><?php echo $amount; ?></td>
                                                <td><?php echo $starting; ?></td>
                                                <td><?php echo $ending; ?></td>
                                                <td><?php echo $username['username']; ?></td>
                                                <td>
                                                    <?php
                              if ($status == 1) { ?>
                                                    <div class="switch-container">
                                                        <div class="switch-toggle-btn .switch-toggle-btn active"
                                                            id=<?php echo $id; ?>>
                                                            <div class="circle"></div>
                                                        </div>
                                                    </div>
                                                    <?php
                              } else { ?>
                                                    <div class="switch-container">
                                                        <div class="switch-toggle-btn" id=<?php echo $id; ?>>
                                                            <div class="circle"></div>
                                                        </div>
                                                    </div>
                                                    <?php
                              }
                              ?>
                                                </td>
                                                <?php if ($_SESSION['function'] == "1" || $_SESSION['function'] == "2") { ?>
                                                <td><a
                                                        href="index.php?page=update_fee_settings&fee_data=<?php echo $id; ?>"><i
                                                            class="fa fa-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;
                                                    |&nbsp;&nbsp;&nbsp;<a
                                                        href="index.php?page=fee_settings&delete_id=<?php echo $id; ?>"><i
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


<?php include 'fee_settings/fee_settings_modal.php'; ?>