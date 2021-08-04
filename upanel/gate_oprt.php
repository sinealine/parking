<?php
if (isset($_POST['btn-save'])) {

  try {

    $u_names = $_POST['u_names'];
    $u_email = $_POST['u_email'];
    $u_phone = $_POST['u_phone'];
    $fnct = $_POST['fnct'];
    $creat_date = date("Y-m-d");

    $pwd = rand(10000, 99999);

    try {
      //for new user
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "INSERT INTO `tbl_staff_gate_op` (`sg_name`, `sg_phone`,`sg_email`, `sg_status`, `reg_date`,`park_id`) 
			VALUES ('$u_names','$u_phone','$u_email','1', '$creat_date','$last_ID')";
      $conn->exec($sql);
      $lastId = $conn->lastInsertId();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    try {
      $sql = " INSERT INTO tbl_user_access(u_names, username, password, email, phone, function,lst_insert_id, status, date) 
			        VALUES ('$u_names','$u_phone',ENCODE('" . htmlspecialchars($pwd, ENT_QUOTES) . "','itecltd'),'$u_email','$u_phone','$fnct','$lastId','Active','$creat_date')";
      $conn->exec($sql);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    $messave = "New User Successfully added";

    $msg = " Dear $u_names you have Accesss to KCT Parking System. Login USN: $u_phone PWD: $pwd. More info,Tel :0788261153.";
    $data = array(
      "sender" => 'ITEC Ltd',
      "recipients" => "$u_phone",
      "message" => "$msg",
    );

    $url = "https://www.intouchsms.co.rw/api/sendsms/.json";
    $data = http_build_query($data);
    $username = "twagiramungus";
    $password = "M00dle!!";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  echo '<meta http-equiv="refresh"' . 'content="3;URL=index?page=operator">';
}

// Updating User Function by select

if (isset($_GET['user_data'])) {
  try {

    $user_data = $_GET['user_data'];
    $user_funct = $_GET['user_funct'];
    $old_funct = $_GET['old_funct'];
    $new_funct = $_GET['new_funct'];
    $user_name = $_GET['user_name'];

    //for Updating user
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = " UPDATE tbl_user_access SET function = '$user_funct' WHERE u_id = '$user_data'; ";
    $conn->exec($sql);
    $lastId = $conn->lastInsertId();

    $messave = " $user_name Function Changed To $new_funct From $old_funct ";
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  echo '<meta http-equiv="refresh"' . 'content="3;URL=index?page=operator">';
}

// Deleting User

if (isset($_GET['delete_id'])) {
  try {

    $delete_data = $_GET['delete_id'];
    $user_name = $_GET['user_name'];

    //for Deleting user
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = " DELETE FROM tbl_user_access WHERE lst_insert_id='$delete_data' AND function=3 ";
    $conn->exec($sql);

    $sql = " DELETE FROM tbl_staff_gate_op WHERE staff_g_id='$delete_data' ";
    $conn->exec($sql);

    $delete_msg = " $user_name Have Been Deleted Successfuly ";
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  echo '<meta http-equiv="refresh"' . 'content="3;URL=index?page=operator">';
}
?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><small>Manage User Access</small></h3>
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
                        <h2><small>View | Add new user </small></h2>

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
            $select = $conn->prepare("SELECT * FROM tbl_user_access,tbl_function WHERE tbl_user_access.function=tbl_function.fnct_id  AND tbl_user_access.function =3");
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
                                                <th>NAMES</th>
                                                <th>USERNAME</th>
                                                <th>PHONE</th>
                                                <th>EMAIL</th>
                                                <th>FUNCTION</th>
                                                <th>STATUS</th>
                                                <!--<?php if ($_SESSION['function'] == "1" || $_SESSION['function'] == "2") { ?>-->
                                                <!--                           <th>ACTION</th>-->
                                                <!--<?php } ?>-->
                                            </tr>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                        $i = 0;
                        while ($row_1 = $select->fetch()) {
                          $fnct_ID = $row_1['fnct_id'];
                          $user_id = $row_1['u_id'];
                          $fnct_full_name = $row_1['fnct_full_name'];
                          $user_function = $row_1['function'];
                          $user_name = $row_1['username'];
                          $i++;
                        ?>
                                            <tr>
                                                <th scope="row"><?php echo $i; ?></th>
                                                <td><?php echo $row_1['u_names']; ?></td>
                                                <td><?php echo $row_1['username']; ?></td>
                                                <td><?php echo $row_1['phone']; ?></td>
                                                <td><?php echo $row_1['email']; ?></td>
                                                <td>
                                                    <select
                                                        onchange="location = this.options[this.selectedIndex].value;"
                                                        class="form-control select2" name="user_funct" id="user_funct"
                                                        style="width: 100%">

                                                        <option
                                                            value="index?page=users&user_data=<?php echo $user_id; ?>&user_funct=<?php echo $fnct_ID; ?>">
                                                            <?php echo $fnct_full_name ?>
                                                        </option>

                                                        <?php
                                $stmt = $db->query(" SELECT * FROM tbl_function WHERE fnct_id=3 AND fnct_id!='$user_function' ORDER BY fnct_id ASC");

                                try {
                                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                                        <option value="index?page=users&user_data=<?php echo $user_id; ?>&user_funct=<?php echo $row['fnct_id']; ?>&old_funct=<?php echo $fnct_full_name ?>&new_funct=<?php echo $row['fnct_full_name']; ?>&user_name=<?php echo $user_name; ?>
                                                                        ">
                                                            <?php echo $row['fnct_full_name']; ?>
                                                        </option>
                                                        <?php
                                  }
                                } catch (PDOException $ex) {
                                  //Something went wrong rollback!
                                  echo $ex->getMessage();
                                }
                                ?>
                                                    </select>
                                                </td>
                                                <td><?php echo $row_1['status']; ?></td>

                                                <!--<?php if ($_SESSION['function'] == "1" || $_SESSION['function'] == "2") { ?>-->
                                                <!--                              <td><a href="index.php?page=updateuser&user_data=<?php echo $row_1['u_id']; ?>"><i class="fa fa-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;-->
                                                <!--                              |&nbsp;&nbsp;&nbsp;<a href="index?page=operator&delete_id=<?php echo $row_1['lst_insert_id']; ?>&user_name=<?php echo $user_name; ?>" onclick="if(!confirm('Do you really want to Remove this User?'))return false;else return true;"><i class="fa fa-trash"></i> Delete</a></td>-->
                                                <!--<?php } ?>-->
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
                                    <strong>Sorry!</strong> Currently no Users available.
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


<?php include 'gate_oprt_modal.php'; ?>