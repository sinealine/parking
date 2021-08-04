<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><small>Parking Exits Lists</small></h3>
            </div>

            <?php include '../inc/search.php'; ?>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>From: <small><?php echo substr($_SESSION['from'], 0, 19); ?> To:
                                <?php echo substr($_SESSION['to'], 0, 19); ?></small></h2>

                        <ul class="nav navbar-right panel_toolbox">
                            <li class="dropdown">
                            <li>
                                <b>Time:</b> <b id="curr-time"></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </li>
                            <li>
                                <?php
                                $select = $conn->prepare("select * from park_in where " . $crit_entre . "");
                                $select->execute();
                                if ($select->rowCount() != 0) {
                                ?>
                                <!-- <a href="pdf_park_entrance.php?criteria=<?php echo $crit_entre; ?>&user=<?php echo $u_id; ?>"
                                    target="_blank">
                                    <span class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Export PDF </span>
                                </a> -->
                                <?php
                                }
                                ?>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <?php
                        if (isset($_REQUEST['action']))
                            if ($_REQUEST['action'] == "Delete") {

                                $sql = $conn->prepare("SELECT * FROM park_out WHERE p_in_id=" . $_REQUEST['id']);
                                $sql->execute();
                                if ($sql->rowCount() == 0) {
                                    $dlt = $conn->prepare("DELETE FROM park_in WHERE p_in_id=" . $_REQUEST['id']);
                                    $dlt->execute();
                                } else die("You are trying to remove data that associated with others");
                            }

                        $select = $conn->prepare("select * from park_in where " . $crit_entre . " AND status = 1");
                        $select->execute();
                        if ($select->rowCount() != 0) {
                        ?>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">

                                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>License Plate</th>
                                                <th>Time In</th>
                                                <th>Time Out</th>
                                                <th>Time Used</th>
                                                <th>Served By</th>
                                                <th>Exited by</th>
                                                <th>Cash Paid</th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            <?php
                                                $i = 0;
                                                $amount = 0;
                                                function getUsedTime($timeused)
                                                {
                                                    $format = 'Y-m-d H:i:s';
                                                    $date = DateTime::createFromFormat($format, $timeused);
                                                    return $date->format('H:i:s');
                                                }

                                                while ($row = $select->fetch()) {
                                                    $i++;
                                                    $pinid = $row['p_in_id'];
                                                    $user = $row['user'];
                                                    $code = $row['card_code'];


                                                    $sql2 = "SELECT* FROM park_in WHERE card_code ='$code'";
                                                    $res = $conn->prepare($sql2);
                                                    $res->execute();
                                                    $cardtype = $res->fetch();

                                                    $sql3 = "SELECT* FROM tbl_user_access WHERE lst_insert_id ='$user'";
                                                    $user = $conn->prepare($sql3);
                                                    $user->execute();
                                                    $us = $user->fetch();

                                                    $sql4 = "SELECT* FROM park_out WHERE p_in_id = '$pinid'";
                                                    $res = $conn->prepare($sql4);
                                                    $res->execute();
                                                    $outdata = $res->fetch();
                                                    $user_exited = $outdata['user'];

                                                    $diff_time = strtotime($row['entre_time']) - strtotime($outdata['exit_time']);
                                                    $timeUsed = gmdate('H:i:s', abs($diff_time));

                                                    $sql_exit = "SELECT* FROM tbl_user_access WHERE lst_insert_id ='$user_exited'";
                                                    $user_exit = $conn->prepare($sql_exit);
                                                    $user_exit->execute();
                                                    $us2 = $user_exit->fetch();
                                                    $user_2 = $us2['lst_insert_id'];

                                                    $sqlse = "SELECT* FROM tbl_staff_gate_op WHERE staff_g_id ='" . $us['lst_insert_id'] . "'";
                                                    $resse = $conn->prepare($sqlse);
                                                    $resse->execute();
                                                    $opdata = $resse->fetch();

                                                    $stmt = "SELECT* FROM tbl_staff_gate_op WHERE staff_g_id ='$user_2'";
                                                    $stmt_QUERY = $conn->prepare($stmt);
                                                    $stmt_QUERY->execute();
                                                    $stmt_fetch = $stmt_QUERY->fetch();

                                                ?>
                                            <tr>
                                                <th scope="row"><?php echo $i; ?></th>
                                                <td><?php echo $row['card_code']; ?></td>
                                                <td><?php echo $row['entre_time']; ?></td>
                                                <td><?php echo $outdata['exit_time']; ?></td>
                                                <td><?php echo $timeUsed; ?></td>
                                                <td><?php echo $opdata['sg_name']; ?></td>
                                                <td><?php echo $stmt_fetch['sg_name']; ?></td>
                                                <td>
                                                    <?php
                                                            $amount = $amount + $outdata['total_paid'];
                                                            echo number_format($outdata['total_paid']) . ".00";
                                                            ?>
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
                                                <th></th>
                                                <th></th>
                                                <th><?php echo number_format($amount) . ".00"; ?></th>
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
</div>
<!-- /page content -->