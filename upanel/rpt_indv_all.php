<script type="text/javascript">
$(document).ready(function() {
    $("#P_OP").change(function() {
        $(this).after(
            '<div id="loader"><img src="img/ajax_loader.gif" alt="loading...." width="30" height="30" /></div>'
            );
        $.get('load_user.php?P_OP=' + $(this).val(), function(data) {
            // replace dates
            var galimg = $('#display_from');
            var nodes = galimg.parent().contents();
            var idx = nodes.index(galimg);

            nodes.slice(idx + 1).remove();

            // replace table
            var galimg = $('.display_report');
            var nodes = galimg.parent().contents();
            var idx = nodes.index(galimg);

            nodes.slice(idx + 1).remove();

            $("#display_from").after(data);
            $('#loader').slideUp(910, function() {
                $(this).remove();
            });
        });
    });

});
</script>

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
                        <h2><small><i class="fa fa-refresh"></i> Generate report</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <!-- Right side list -->
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 ">
                                <form class="display_report" id="gen_rpt">
                                    <div class="item form-group">
                                        <div class="col-md-4" id="display_from">
                                            <div class="col-md-12">
                                                <select class="form-control select2" name="P_OP" id="P_OP"
                                                    data-placeholder="Select Operator" style="width:100%;" required>
                                                    <option value=""></option>
                                                    <?php
                          $sql3 = "SELECT* FROM `tbl_staff_gate_op` WHERE sg_status=1";
                          $res = $conn->prepare($sql3);
                          $res->execute();
                          while ($opdata = $res->fetch()) {
                          ?>
                                                    <option value="<?php echo $opdata['staff_g_id']; ?>">
                                                        <?php echo $opdata['sg_name']; ?></option>
                                                    <?php
                          }
                          ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </form>

                            </div><!-- col -->
                        </div> <!-- row -->
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<!-- /page content -->