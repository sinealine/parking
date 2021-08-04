<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><small>Parking Transaction Lists</small></h3>
            </div>
            <?php include '../inc/search.php'; ?>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><small>View | Add</small></h2>

                        <ul class="nav navbar-right panel_toolbox">
                            </li>
                            <li><a href="add" data-toggle="modal" data-target=".bs-example-modal-sm"><i
                                        class="fa fa-plus"></i> Add</a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <?php
            $select = $conn->prepare("select * from park_price");
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
                                                <th>CARD CODE</th>
                                                <th>TYPE</th>
                                                <th>Hour(s)</th>
                                                <th>PRICE</th>
                                                <th>DATE</th>

                                                <th>USER</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                        $i = 0;
                        $tprice = 0;
                        while ($row = mysqli_fetch_array($select)) {

                          $pout = getinfo($con, "park_out", "p_out_id", $row['p_out_id']);
                          $tprice += $row['price'];

                          $i++;
                          $user = $row['user'];
                          $sql3 = "SELECT* FROM fiestauser WHERE u_id ='$user'";
                          $user = $con->query($sql3);
                          $us = mysqli_fetch_assoc($user);


                          //$cat=getinfo($con,"category","id",$row['cat_id']);
                          //	$org=getinfo($con,"organisation","id",$row['org_id']);
                        ?>
                                            <tr>
                                                <th scope="row"><?php echo $i; ?></th>
                                                <td><?php echo $row['card_code']; ?></td>
                                                <td><?php echo $row['t_type']; ?></td>
                                                <td><?php echo $pout['tot_hours']; ?></td>

                                                <td><?php echo $row['price']; ?></td>
                                                <td><?php echo $row['date']; ?></td>
                                                <td><?php echo $us['username']; ?></td>


                                            </tr>
                                            <?php
                        }
                        ?>
                                        </tbody>
                                        <tr>
                                            <th scope="row"></th>
                                            <th>Total</th>
                                            <td></td>

                                            <td></td>
                                            <th><?php echo number_format($tprice, '0', '', ','); ?></th>
                                            <td></td>
                                            <td></td>


                                        </tr>
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
                                    <strong>Sorry!</strong> No Transaction has been made Today.
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


<?php include 'modal/add_price_modal.php'; ?>