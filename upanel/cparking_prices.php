<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><small>Parking Price Lists</small></h3>
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
                                                <th>Price Plan</th>
                                                <th>Price</th>
                                                <th width="15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                        $i = 0;
                        while ($row = $select->fetch()) {
                          $i++;
                          if ($row['price_plan'] == 1) {

                            $plan = $row['price_plan'] . ' hour';
                          } else {

                            $plan = $row['price_plan'] . ' hours';
                          }

                          if ($row['price_plan'] == -1) {

                            $row['price'] = 'Free';
                            $plan = "Free";
                          }

                          if ($row['price_plan'] == 0) {

                            $plan = "Post paid";
                          }

                        ?>
                                            <tr>
                                                <th scope="row"><?php echo $i; ?></th>
                                                <td><?php echo $plan; ?></td>
                                                <td><?php echo $row['price']; ?></td>
                                                <td><a
                                                        href="index.php?page=prices&newusers&action=Update&id=<?php echo $row['price_id']; ?>"><i
                                                            class="fa fa-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;
                                                    |&nbsp;&nbsp;&nbsp;<a
                                                        href="index.php?page=prices&newusers&action=Delete&id=<?php echo $row['price_id']; ?>"><i
                                                            class="fa fa-trash"></i> Delete</a></td>
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
                                    <strong>Sorry!</strong> Currently no prices.
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