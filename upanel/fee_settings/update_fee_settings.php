<?php
if (isset($_POST['btn-update'])) {

    try {
        $id = $_POST['id'];
        $subname = $_POST['subscription_name'];
        $amount = $_POST['amount'];
        $starting = $_POST['starting_period'];
        $ending = $_POST['ending_period'];

        //for new user
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = " UPDATE tbl_fee_settings SET subscription_name='$subname',amount='$amount',starting_period='$starting',ending_period='$ending' WHERE id='$id' ";
        $conn->exec($sql);

        $messave = " Fee Updated Successfully ";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    echo '<meta http-equiv="refresh"' . 'content="3;URL=index.php?page=fee_settings">';
}
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3><small>Update User Access Data</small></h3>
        </div>
        <?php include '../inc/search.php'; ?>
    </div>

    <div class="clearfix"></div>

    <?php if (isset($messave)) { ?>
    <div class="alert alert-success alert-dismissible " role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <strong>Well done!</strong> <?php echo htmlentities($messave); ?>
    </div>
    <?php } ?>

    <?php

    $fee_data = $_GET['fee_data'];

    $select = $conn->prepare("SELECT * FROM tbl_fee_settings WHERE id = $fee_data ");
    $select->execute();
    while ($row_1 = $select->fetch()) {
        $subname = $row_1['subscription_name'];
        $amount = $row_1['amount'];
        $starting = $row_1['starting_period'];
        $ending = $row_1['ending_period'];
        $user = $row_1['user'];
    ?>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_content">
                    <br />
                    <form class="form-label-left input_mask" method="POST" action="">
                        <div class="item form-group">
                            <label class="col-form-label col-md-2 " for="first-name">Subscription Name <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="id" value="<?php echo $fee_data; ?>"
                                    hidden>
                                <input type="text" class="form-control" name="subscription_name"
                                    value="<?php echo $row_1['subscription_name']; ?>" placeholder="Subscription Name"
                                    required>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-form-label col-md-2 " for="first-name">Amount <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="amount"
                                    value="<?php echo $row_1['amount']; ?>" placeholder="Amount" required>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-form-label col-md-2 " for="first-name">Starting Period <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-9">
                                <input type="date" class="form-control" name="starting_period"
                                    min="<?php echo date("Y-m-d"); ?>" value="<?php echo $row_1['starting_period']; ?>"
                                    placeholder="Email" required>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-form-label col-md-2 " for="first-name">Ending Period <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-9">
                                <input type="date" class="form-control" name="ending_period"
                                    min="<?php echo date("Y-m-d"); ?>" value="<?php echo $row_1['ending_period']; ?>"
                                    placeholder="Phone" required>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><a
                            href="index.php?page=fee_settings" style="color:inherit;">Close</a></button>
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