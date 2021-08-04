<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><small><i class="fa fa-car"></i> Control Parking System</small></h3>
            </div>
            <?php include '../inc/search.php'; ?>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><small><i class="fa fa-download"></i> Generate report</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <!-- Right side list -->
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 ">
                                <form method="post" action="#" id="gen_rpt">
                                    <div class="item form-group">
                                        <div class="col-md-3">
                                            Mode <span class="required">*</span>
                                            <div class="col-md-12">
                                                <select class="form-control select2" name="car_status" id="car_status"
                                                    data-placeholder="Choose one" style="width:100%;" required>
                                                    <option value="1">All</option>
                                                    <option value="2">Exit</option>
                                                    <option value="3">Left</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            Date From <span class="required">*</span>
                                            <div class="col-md-12">
                                                <input name="input_from" class="date-picker form-control"
                                                    placeholder="dd-mm-yyyy" type="date" required="required">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            Date To <span class="required">*</span>
                                            <div class="col-md-12">
                                                <input name="input_to" class="date-picker form-control"
                                                    placeholder="dd-mm-yyyy" type="date" required="required">
                                            </div>
                                        </div>

                                        <div class="col-md-2 my-auto">
                                            <div class="col-md-12 my-auto">
                                                <button type="submit" name="gen_rpt"
                                                    class="btn btn-success mt-3">Go</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div><!-- col -->
                        </div> <!-- row -->
                    </div>

                    <!-- table report start -->
                    <?php
                    if (isset($_POST['gen_rpt'])) {
                        $stat = $_POST["car_status"];
                        $d1 = $_POST["input_from"];
                        $d2 = $_POST["input_to"];

                        if ($stat == 1) {
                            try {
                                $stmt = $db->prepare("SELECT * from `park_in` where Date(`entre_time`) BETWEEN '$d1' AND '$d2' ");
                                $stmt->execute();
                                if ($stmt->rowCount() > 0) {
                    ?>
                    <div class="">
                        <div class="page-title">
                            <div class="title_left">
                                <h3><small>All Cars Report</small></h3>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 ">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>From: <small><?php echo $d1; ?> To: <?php echo $d2; ?></small></h2>

                                        <ul class="nav navbar-right panel_toolbox">
                                            <li>
                                                <b>Time:</b> <b id="curr-time"></b> &nbsp;&nbsp;&nbsp;&nbsp;
                                            </li>
                                            <li>
                                                <a href="excel_entries.php?date_from=<?php echo $d1; ?>&date_to=<?php echo $d2; ?>&car=<?php echo $stat; ?>"
                                                    target="_blank">
                                                    <span class="btn btn-success text-white"><i
                                                            class="fa fa-file-excel-o"></i> Export Excel </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card-box table-responsive">

                                                    <table id="datatable" class="table table-striped table-bordered"
                                                        style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Plate No</th>
                                                                <th>Tel</th>
                                                                <th>Time In</th>
                                                                <th>Time Out</th>
                                                                <th>Amount to Pay</th>
                                                                <th>Amount Paid</th>
                                                                <th>Balance</th>
                                                                <th>Served By</th>
                                                            </tr>
                                                        </thead>


                                                        <tbody>
                                                            <?php
                                                                            $i = 0;
                                                                            $tamp = 0;
                                                                            $tamtp = 0;
                                                                            while ($row = $stmt->fetch()) {
                                                                                $i++;
                                                                                $pid = $row['p_in_id'];
                                                                                $user = $row['user'];
                                                                                $code = $row['card_code'];
                                                                                $phone = $row['phone'];

                                                                                $sqlpo = "SELECT* FROM park_out WHERE p_in_id ='$pid'";
                                                                                $qpout = $db->prepare($sqlpo);
                                                                                $qpout->execute();
                                                                                $fpout = $qpout->fetch();
                                                                                $fpout['total_paid'] = empty($fpout['total_paid']) ? 0 : $fpout['total_paid'];
                                                                                $tamp += $fpout['total_paid'];

                                                                                $sql3 = "SELECT* FROM tbl_user_access WHERE lst_insert_id ='$user'";
                                                                                $user = $db->prepare($sql3);
                                                                                $user->execute();
                                                                                $us = $user->fetch();

                                                                                $curr_time = empty($fpout['exit_time']) ? date("Y-m-d H:i:s") : $fpout['exit_time'];

                                                                                $tempTotalTime = differenceInHours($row['entre_time'], $curr_time);

                                                                                $sql5 = "SELECT* FROM park_price WHERE price_plan = '$tempTotalTime'";
                                                                                $res = $db->prepare($sql5);
                                                                                $res->execute();
                                                                                $pay = $res->fetch();
                                                                                $tamtp += $pay['price'];

                                                                                $sql3 = "SELECT* FROM tbl_staff_gate_op WHERE staff_g_id ='" . $us['lst_insert_id'] . "'";
                                                                                $res = $db->prepare($sql3);
                                                                                $res->execute();
                                                                                $opdata = $res->fetch();

                                                                            ?>
                                                            <tr>
                                                                <th scope="row"><?php echo $i; ?></th>
                                                                <td><?php echo $code; ?></td>
                                                                <td><?php
                                                                                        if ($phone == "") {

                                                                                        ?>
                                                                    <label class="fa fa-exclamation-circle"> No
                                                                        data</label>
                                                                    <?php
                                                                                        } else {
                                                                                            echo $phone;
                                                                                        } ?>
                                                                </td>

                                                                <td><?php echo $row['entre_time']; ?></td>
                                                                <td><?php
                                                                                        if (empty($fpout['exit_time'])) {

                                                                                        ?>
                                                                    <label class="fa fa-exclamation-circle"> No
                                                                        data</label>
                                                                    <?php
                                                                                        } else {
                                                                                            echo $fpout['exit_time'];
                                                                                        } ?>
                                                                </td>
                                                                <td><?php echo number_format($pay['price']) . ".00"; ?>
                                                                </td>
                                                                <td><?php echo number_format($fpout['total_paid']) . ".00"; ?>
                                                                </td>
                                                                <td><?php echo number_format($pay['price'] - $fpout['total_paid']) . ".00"; ?>
                                                                </td>
                                                                <td><?php echo $opdata['sg_name']; ?></td>
                                                                <!--td><a href="index.php?page=park_entrances&action=Delete&id=<?php echo $row['p_in_id']; ?>&date_from=<?php echo $from; ?>&date_to=<?php echo $to; ?>">Remove</a></td-->

                                                            </tr>
                                                            <?php
                                                                            }
                                                                            ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Total</th>
                                                                <th><?php echo $stmt->rowCount(); ?></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th><?php echo number_format($tamtp); ?></th>
                                                                <th><?php echo number_format($tamp); ?></th>
                                                                <th><?php echo number_format($tamtp - $tamp); ?></th>
                                                                <th></th>
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
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close"><span aria-hidden="true">×</span>
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
                    <?php
                                } catch (PDOException $e) {
                                    echo 'Something Wrong: ' . $e->getMessage();
                                }
                            } else if ($stat == 2) {
                                try {
                                    $stmt = $db->prepare("SELECT * from `park_out` where Date(`exit_time`) BETWEEN '$d1' AND '$d2' ");
                                    $stmt->execute();
                                    if ($stmt->rowCount() > 0) {
                                    ?>
                    <div class="">
                        <div class="page-title">
                            <div class="title_left">
                                <h3><small>Parking Exits Report</small></h3>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 ">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>From: <small><?php echo $d1; ?> To: <?php echo $d2; ?></small></h2>

                                        <ul class="nav navbar-right panel_toolbox">
                                            <li class="dropdown">
                                            <li>
                                                <b>Time:</b> <b id="curr-time"></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </li>
                                            <li>
                                                <a href="excel_exits.php?date_from=<?php echo $d1; ?>&date_to=<?php echo $d2; ?>&car=<?php echo $stat; ?>"
                                                    target="_blank">
                                                    <span class="btn btn-success text-white"><i
                                                            class="fa fa-file-excel-o"></i> Export Excel </span>
                                                </a>
                                            </li>

                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card-box table-responsive">

                                                    <table id="datatable" class="table table-striped table-bordered"
                                                        style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Plate No</th>
                                                                <th>Time In</th>
                                                                <th>Time Out</th>
                                                                <th>Amount To Pay</th>
                                                                <th>Amount Paid</th>
                                                                <th>Balance</th>
                                                                <th>Served By</th>
                                                            </tr>
                                                        </thead>


                                                        <tbody>
                                                            <?php
                                                                                $i = 0;
                                                                                $tamp = 0;
                                                                                $tamtp = 0;
                                                                                $amount = 0;
                                                                                while ($row = $stmt->fetch()) {
                                                                                    $i++;
                                                                                    $pinid = $row['p_in_id'];
                                                                                    $user = $row['user'];

                                                                                    $sql3 = "SELECT* FROM tbl_user_access WHERE lst_insert_id ='$user'";
                                                                                    $userac = $db->prepare($sql3);
                                                                                    $userac->execute();
                                                                                    $us = $userac->fetch();

                                                                                    $sql4 = "SELECT* FROM park_in WHERE p_in_id = '$pinid'";
                                                                                    $res = $db->prepare($sql4);
                                                                                    $res->execute();
                                                                                    $indata = $res->fetch();
                                                                                    $user_exited = $indata['user'];

                                                                                    $diff_time = strtotime($indata['entre_time']) - strtotime($row['exit_time']);
                                                                                    $timeUsed = gmdate('H:i:s', abs($diff_time));

                                                                                    $curr_time = empty($row['exit_time']) ? date("Y-m-d H:i:s") : $row['exit_time'];
                                                                                    $tempTotalTime = differenceInHours($indata['entre_time'], $curr_time);

                                                                                    $sql5 = "SELECT* FROM park_price WHERE price_plan = '$tempTotalTime'";
                                                                                    $res = $db->prepare($sql5);
                                                                                    $res->execute();
                                                                                    $pay = $res->fetch();
                                                                                    $pay['price'] = empty($pay['price']) ? '5000' : $pay['price'];
                                                                                    $tamtp += $pay['price'];

                                                                                    $sql_exit = "SELECT* FROM tbl_user_access WHERE lst_insert_id ='$user_exited'";
                                                                                    $user_exit = $db->prepare($sql_exit);
                                                                                    $user_exit->execute();
                                                                                    $us2 = $user_exit->fetch();
                                                                                    $user_2 = $us2['lst_insert_id'];

                                                                                    $sqlse = "SELECT* FROM tbl_staff_gate_op WHERE staff_g_id ='" . $us2['lst_insert_id'] . "'";
                                                                                    $resse = $db->prepare($sqlse);
                                                                                    $resse->execute();
                                                                                    $opdata = $resse->fetch();

                                                                                    $stmtop = "SELECT* FROM tbl_staff_gate_op WHERE staff_g_id ='$user'";
                                                                                    $stmt_QUERY = $db->prepare($stmtop);
                                                                                    $stmt_QUERY->execute();
                                                                                    $stmt_fetch = $stmt_QUERY->fetch();

                                                                                ?>
                                                            <tr>
                                                                <th scope="row"><?php echo $i; ?></th>
                                                                <td><?php echo $indata['card_code']; ?></td>
                                                                <td><?php echo $indata['entre_time']; ?></td>
                                                                <td><?php echo $row['exit_time']; ?></td>
                                                                <td><?php echo $pay['price']; ?></td>
                                                                <td>
                                                                    <?php
                                                                                            $amount = $amount + $row['total_paid'];
                                                                                            echo number_format($row['total_paid']) . ".00";
                                                                                            ?>
                                                                </td>
                                                                <td><?php echo number_format($pay['price'] - $row['total_paid']); ?>
                                                                </td>
                                                                <td><?php echo $stmt_fetch['sg_name']; ?></td>
                                                            </tr>
                                                            <?php
                                                                                }
                                                                                ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Total</th>
                                                                <th><?php echo $stmt->rowCount(); ?></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th><?php echo $tamtp; ?></th>
                                                                <th><?php echo number_format($amount) . ".00"; ?></th>
                                                                <th><?php echo number_format($tamtp - $amount); ?></th>
                                                                <th></th>
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
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close"><span aria-hidden="true">×</span>
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
                    <?php
                                    } catch (PDOException $e) {
                                        echo 'Something Wrong: ' . $e->getMessage();
                                    }
                                } else {
                                    try {
                                        $stmt = $db->prepare("SELECT * from `park_in` WHERE Date(entre_time) BETWEEN '$d1' AND '$d2' AND status = 0 ");
                                        $stmt->execute();
                                        if ($stmt->rowCount() > 0) {
                                        ?>
                    <div class="">
                        <div class="page-title">
                            <div class="title_left">
                                <h3><small>Parking Left Report</small></h3>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 ">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>From: <small><?php echo $d1; ?> To:
                                                <?php echo $d2; ?></small></h2>

                                        <ul class="nav navbar-right panel_toolbox">
                                            <li>
                                                <b>Time:</b> <b id="curr-time"></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </li>
                                            <li>
                                                <a href="excel_left.php?date_from=<?php echo $d1; ?>&date_to=<?php echo $d2; ?>&car=<?php echo $stat; ?>"
                                                    target="_blank">
                                                    <span class="btn btn-success text-white"><i
                                                            class="fa fa-file-excel-o"></i> Export Excel </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card-box table-responsive">

                                                    <table id="datatable" class="table table-striped table-bordered"
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
                                                                <th>Served By</th>
                                                                <?php
                                                                                        if ($_SESSION['function'] == "Super Admin" || $_SESSION['function'] == "Admin") {
                                                                                        ?>
                                                                <!--th>Action</th-->
                                                                <?php
                                                                                        }
                                                                                        ?>
                                                            </tr>
                                                        </thead>


                                                        <tbody>
                                                            <?php
                                                                                    $i = 0;
                                                                                    $total_amount = 0;

                                                                                    while ($row = $stmt->fetch()) {
                                                                                        $i++;
                                                                                        $pinid = $row['p_in_id'];
                                                                                        $user = $row['user'];
                                                                                        $code = $row['card_code'];

                                                                                        $sql3 = "SELECT* FROM tbl_user_access WHERE lst_insert_id ='$user'";
                                                                                        $usern = $db->prepare($sql3);
                                                                                        $usern->execute();
                                                                                        $us = $usern->fetch();

                                                                                        $sql4 = "SELECT* FROM park_out WHERE p_in_id = '$pinid'";
                                                                                        $res = $db->prepare($sql4);
                                                                                        $res->execute();
                                                                                        $outdata = $res->fetch();

                                                                                        $curr_time = date("Y-m-d H:i:s");
                                                                                        $diff_time = differenceInTime($row['entre_time'], $curr_time);
                                                                                        $timeUsed = gmdate('H:i:s', abs($diff_time * 3600));
                                                                                        // echo $timeUsed;

                                                                                        $tempTotalTime = differenceInHours($row['entre_time'], $curr_time);
                                                                                        $sql5 = "SELECT* FROM park_price WHERE price_plan = '$tempTotalTime'";
                                                                                        $res = $db->prepare($sql5);
                                                                                        $res->execute();
                                                                                        $pay = $res->fetch();
                                                                                        $pay['price'] = $res->rowCount() > 0 ? $pay['price'] : 5000;
                                                                                        $total_amount += $pay['price'];

                                                                                        $sqlse = "SELECT* FROM tbl_staff_gate_op WHERE staff_g_id ='" . $us['lst_insert_id'] . "'";
                                                                                        $resse = $db->prepare($sqlse);
                                                                                        $resse->execute();
                                                                                        $opdata = $resse->fetch();

                                                                                    ?>
                                                            <tr>
                                                                <th scope="row"><?php echo $i; ?></th>
                                                                <td><?php echo $row['card_code']; ?></td>
                                                                <td><?php
                                                                                                if ($row['phone'] == "") {

                                                                                                ?>
                                                                    <label class="fa fa-exclamation-circle"> No
                                                                        data</label>
                                                                    <?php
                                                                                                } else {
                                                                                                    echo $row['phone'];
                                                                                                } ?>
                                                                </td>
                                                                <td><?php echo $row['entre_time']; ?></td>
                                                                <td><label class="fa fa-exclamation-circle"> No
                                                                        data</label></td>
                                                                <td><?php echo number_format($pay['price']) . ".00"; ?>
                                                                </td>
                                                                <td>0</td>
                                                                <td><?php echo number_format($pay['price'] - 0) . ".00"; ?>
                                                                </td>
                                                                <td><?php echo $opdata['sg_name']; ?></td>
                                                            </tr>
                                                            <?php
                                                                                    }
                                                                                    ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Total</th>
                                                                <th><?php echo $stmt->rowCount(); ?></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th><?php echo number_format($total_amount) . ".00"; ?>
                                                                </th>
                                                                <th>0</th>
                                                                <th><?php echo number_format($total_amount - 0); ?></th>
                                                                <th></th>
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
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close"><span aria-hidden="true">×</span>
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
                    <?php
                                    } catch (PDOException $e) {
                                        echo 'Something Wrong: ' . $e->getMessage();
                                    }
                                }
                            }
                                ?>
                    <!-- table report end -->

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

function differenceInTime($startdate, $enddate)
{
    $starttimestamp = strtotime($startdate);
    $endtimestamp = strtotime($enddate);
    $hours = abs($endtimestamp - $starttimestamp) / (60 * 60);
    return $hours;
}
?>