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
                            <form id="gen_rpt">
                          <div class="item form-group">
                                <div class="col-md-4">
    								Operator <span class="required">*</span>
    								<div class="col-md-12">
    								    <select class="form-control select2" name="car_op" id="car_op" data-placeholder="Choose one" style="width:100%;" required>
                        		            <option value = "">Choose One...</option>
    								        <?php
                                                $sql3="SELECT* FROM `tbl_staff_gate_op` WHERE sg_status=1";
                                                $res=$conn->prepare($sql3);
                                                $res->execute();
                                                while($opdata=$res->fetch()) {
                                                    ?>
                                		            <option value = "<?php echo $opdata['staff_g_id']; ?>"><?php echo $opdata['sg_name']; ?></option>
                                            <?php
                                                }
    								        ?>
                                		</select>
    								</div>
                                </div>
							
                                <div class="col-md-4">
                                    Date Range
                                    <fieldset>
                                        <div class="control-group ">
                                          <div class="controls">
                                            <div class="input-prepend input-group">
                                              <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                              <input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value="01/01/2020 - 10/06/2020" />
                                            </div>
                                          </div>
                                        </div>
                                  </fieldset>
                                </div>
                                
                                <div class="col-md-2 my-auto">
									<div class="col-md-12 my-auto">
										<button type="submit" id="gen_btn" class="btn btn-success mt-3 has-spinner">Go</button>
									</div>
								</div>
						</div>
                            </form>
							
                      </div><!-- col -->
                     </div> <!-- row -->
                  </div>
                  
                  
                  <div class="x_title" id="x_title">
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" id="x_content">
                      
                      <div class="row">
                          <div class="col-md-5 center" id="indiv_repo">
                          </div>
                          <div class="col-md-3 center">
                              <button type="button" class="btn btn-success mt-3" id="print_rpt">Print</button>
                          </div>
                      </div>
                    </div>
                  
                </div>
              </div>
            </div>
          </div>
        
        </div>
    <!-- /page content -->
  
<script type="text/javascript">
$(document).ready(function() {
    $('#x_title').hide();
    $('#x_content').hide();
    $('#reservation').daterangepicker(
        {
            startDate: moment().subtract(29, 'days'),
            maxDate: moment()
        });

$(document).on("submit", "#gen_rpt" , function(e) {
    e.preventDefault();
    var op = $('#car_op').val();
    var date_range = $('#reservation').val();
    var split_range = date_range.split('-');
    var date1 = formatDate(split_range[0]);
    var date2 = formatDate(split_range[1]);
    $("#gen_btn").buttonLoader('start');
    $.post('live_search_controller.php',{'car-op': op, 'date1': date1, 'date2': date2}, function(data){
        $('#indiv_repo').html(data);
    	
        $("#gen_btn").buttonLoader('stop');
        $('#x_title').show();
        $('#x_content').show();
    });
    
});

$(document).on("click", "#print_rpt" , function() {
    var prtContent = $('#indiv_repo');
    var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
    WinPrint.document.write(prtContent.html());
    WinPrint.focus();
    WinPrint.print();
    // WinPrint.close();
});

function formatDate(date) {
     var d = new Date(date),
         month = '' + (d.getMonth() + 1),
         day = '' + d.getDate(),
         year = d.getFullYear();

     if (month.length < 2) month = '0' + month;
     if (day.length < 2) day = '0' + day;

     return [year, month, day].join('-');
 }

});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.0/jQuery.print.js"></script>