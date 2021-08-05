<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel2"><i class="fa fa-add-circle"></i> Add</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span>
                </button>
            </div>

            <div class="x_content">
                <br />
                <form class="form-label-left input_mask" method="POST" action="">
                    <div class="col-md-12 col-sm-12  form-group has-feedback">
                        <input type="text" class="form-control" name="u_names" id="inputSuccess2" placeholder="Names"
                            required>
                    </div>

                    <div class="col-md-12 col-sm-12  form-group has-feedback">
                        <input type="email" class="form-control" name="u_email" id="inputSuccess2" placeholder="Email">
                    </div>
                    <div class="col-md-12 col-sm-12  form-group has-feedback">
                        <input type="number" class="form-control" name="u_phone" id="inputSuccess2" placeholder="Phone"
                            required>
                    </div>
                    <div class="col-md-12 col-sm-12  form-group has-feedback">
                        <select class="form-control select2" name="fnct" data-placeholder=" Function "
                            style="width:100%;" required>
                            <!--<option></option>-->
                            <?php
              $stmt = $db->query('SELECT * FROM tbl_function WHERE fnct_id=3 ORDER BY fnct_id ASC');

              try {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              ?>
                            <option value="<?php echo $row['fnct_id']; ?>"><?php echo $row['fnct_full_name']; ?>
                            </option>
                            <?php
                }
              } catch (PDOException $ex) {
                //Something went wrong rollback!
                echo $ex->getMessage();
              }
              ?>
                        </select>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="btn-save" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- /modals -->