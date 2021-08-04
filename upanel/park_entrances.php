    <?php
    echo '<' . '?' . 'xml version="1.0" encoding="UTF-8"' . '?' . '>';
    ?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3><small>Parking Entries Lists</small></h3>
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
                                <li>
                                    <b>Time:</b> <b id="curr-time"></b> &nbsp;&nbsp;&nbsp;&nbsp;
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

                            $select = $conn->prepare("select * from park_in where " . $crit_entre . "");
                            $select->execute();
                            if ($select->rowCount() != 0) {
                            ?>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-box table-responsive">

                                        <table id="datatable" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>License Plate</th>
                                                    <th>Phone Number</th>
                                                    <th>Time In</th>
                                                    <th>Served By</th>

                                                </tr>
                                            </thead>


                                            <tbody>
                                                <?php
                                                    $i = 0;

                                                    while ($row = $select->fetch()) {
                                                        $i++;
                                                        $user = $row['user'];
                                                        $code = $row['card_code'];
                                                        $phone = $row['phone'];

                                                        $sql3 = "SELECT* FROM tbl_user_access WHERE lst_insert_id ='$user'";
                                                        $user = $conn->prepare($sql3);
                                                        $user->execute();
                                                        $us = $user->fetch();


                                                        $sql2 = "SELECT* FROM park_in WHERE card_code ='$code'";
                                                        $res = $conn->prepare($sql2);
                                                        $res->execute();
                                                        $cardtype = $res->fetch();

                                                        $sql3 = "SELECT* FROM tbl_staff_gate_op WHERE staff_g_id ='" . $us['lst_insert_id'] . "'";
                                                        $res = $conn->prepare($sql3);
                                                        $res->execute();
                                                        $opdata = $res->fetch();

                                                    ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i; ?></th>
                                                    <td><?php echo $row['card_code']; ?></td>
                                                    <td><?php
                                                                if ($phone == "") {

                                                                ?>
                                                        <label class="fa fa-exclamation-circle"> No data</label>
                                                        <?php
                                                                } else {
                                                                    echo $phone;
                                                                } ?>
                                                    </td>

                                                    <td><?php echo $row['entre_time']; ?></td>
                                                    <td><?php echo $opdata['sg_name']; ?></td>

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
    </div>
    <!-- /page content -->