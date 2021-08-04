<?php
require_once("../include/initialize.php");

$date_from = $_REQUEST['date_from'];
$date_to = $_REQUEST['date_to'];
$user = $_REQUEST['user'];
?>
<!-- page content -->
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><small>Parking Report</small></h3>
        </div>

        <?php include '../inc/search.php'; ?>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <?php
          $sql3 = "SELECT* FROM tbl_staff_gate_op WHERE staff_g_id ='$user'";
          $userinfo = $conn->prepare($sql3);
          $userinfo->execute();
          $us = $userinfo->fetch();
          ?>
                    <p class="text-muted font-13 m-b-30">
                    <h2>Names: <small><?php echo $us['sg_name']; ?></small> </h2>
                    </p><br>
                    <p class="text-muted font-13 m-b-30">
                    <h2>Tel: <small><?php echo $us['sg_phone']; ?></small> </h2>
                    </p><br>
                    <p class="text-muted font-13 m-b-30">
                    <h2>Date: <small><?php echo $date_from . ' - ' . $date_to; ?></small> </h2>
                    </p>

                    <ul class="nav navbar-right panel_toolbox">
                        <li class="dropdown">
                        <li>
                            <a href="excel_ind.php?date_from=<?php echo $date_from; ?>&date_to=<?php echo $date_to; ?>&user=<?php echo $user; ?>"
                                target="_blank">
                                <label class="btn btn-success text-white"><i class="fa fa-file-excel-o"></i> Export
                                    Excel</label>
                            </a>
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <?php
          $select = $conn->prepare("select * from park_in where user = '$user' AND Date(entre_time) BETWEEN '$date_from' AND  DATE_ADD('$date_to', INTERVAL 1 DAY) ");
          $select->execute();
          if ($select->rowCount() > 0) {
          ?>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">

                                <table id="datatable-buttons" class="table table-striped table-bordered"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Plate No</th>
                                            <th>Tel</th>
                                            <th>Time In</th>
                                            <th>Time Out</th>
                                            <th>Amount To Pay</th>
                                            <th>Amount Paid</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        <?php
                      $i = 0;
                      $tamtp = $amount = 0;
                      while ($row = $select->fetch()) {
                        $i++;
                        $pinid = $row['p_in_id'];
                        $user = $row['user'];
                        $code = $row['card_code'];

                        $sql3 = "SELECT* FROM tbl_user_access WHERE lst_insert_id ='$user'";
                        $user = $conn->prepare($sql3);
                        $user->execute();
                        $us = $user->fetch();

                        $sql4 = "SELECT* FROM park_out WHERE p_in_id = '$pinid'";
                        $res = $conn->prepare($sql4);
                        $res->execute();
                        $outdata = $res->fetch();
                        $user_exited = $outdata['user'];

                        $curr_time = empty($outdata['exit_time']) ? date("Y-m-d H:i:s") : $outdata['exit_time'];

                        $tempTotalTime = differenceInHours($row['entre_time'], $curr_time);

                        $sql5 = "SELECT* FROM park_price WHERE price_plan = '$tempTotalTime'";
                        $res = $db->prepare($sql5);
                        $res->execute();
                        $pay = $res->fetch();
                        $tamtp += $pay['price'];

                        $diff_time = strtotime($row['entre_time']) - strtotime($outdata['exit_time']);
                        $timeUsed = gmdate('H:i:s', abs($diff_time));

                        $sql_exit = "SELECT* FROM tbl_user_access WHERE lst_insert_id ='$user_exited'";
                        $user_exit = $conn->prepare($sql_exit);
                        $user_exit->execute();
                        $us2 = $user_exit->fetch();
                        $user_2 = $us2['lst_insert_id'];


                      ?>
                                        <tr>
                                            <th scope="row"><?php echo $i; ?></th>
                                            <td><?php echo $row['card_code']; ?></td>
                                            <td><?php
                              if ($row['phone'] == "") {

                              ?>
                                                <label class="fa fa-exclamation-circle"> No data</label>
                                                <?php
                              } else {
                                echo $row['phone'];
                              } ?>
                                            </td>
                                            <td><?php echo $row['entre_time']; ?></td>
                                            <td><?php echo $outdata['exit_time']; ?></td>
                                            <td><?php echo number_format($pay['price']); ?></td>
                                            <td>
                                                <?php
                            $amount = $amount + $outdata['total_paid'];
                            echo number_format($outdata['total_paid']) . ".00";
                            ?>
                                            </td>
                                            <td><?php echo number_format($pay['price'] - $outdata['total_paid']); ?>
                                            </td>
                                        </tr>
                                        <?php
                      }
                      ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <th><?php echo $select->rowCount(); ?></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th><?php echo number_format($tamtp) . ".00"; ?></th>
                                            <th><?php echo number_format($amount) . ".00"; ?></th>
                                            <th><?php echo number_format($tamtp - $amount) . ".00"; ?></th>
                                        </tr>
                                    </tfoot>
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
                                <strong>Sorry!</strong> Currently no Entry.
                            </div>

                        </div>
                        <?php
          }
            ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /page content -->

<?php
function getUsedTime($timeused)
{
  $format = 'Y-m-d H:i:s';
  $date = DateTime::createFromFormat($format, $timeused);
  return $date->format('H:i:s');
}

function differenceInHours($startdate, $enddate)
{
  $starttimestamp = strtotime($startdate);
  $endtimestamp = strtotime($enddate);
  $difference = abs($endtimestamp - $starttimestamp) / 3600;
  return ceil($difference);
}
?>