<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><small>All Cash Lists</small></h3>
              </div>

              <?php include '../inc/search.php'; ?>
            </div>
           
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>From: <small><?php echo substr($_SESSION['from'],0,19);?> To: <?php echo substr($_SESSION['to'],0,19);?></small></h2>
                   
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <b>Time:</b> <b id="curr-time"></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </li>
                            <li>
                                <a href="pdf_park_allcash.php?criteria=<?php echo $crit_exit;?>&user=<?php echo $u_id;?>" target="_blank"> 
                                     <span class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Export PDF </span>
                                </a>
                            </li>
                        </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      
                      <?php
                        if(isset($_REQUEST['action']))
                        	if($_REQUEST['action']=="Delete"){
                        		
                        $sql= $conn->prepare("SELECT * FROM park_out WHERE p_in_id=".$_REQUEST['id']);
                        $sql->execute();
                        if($sql->rowCount()==0)
                        {
                        $dlt=$conn->prepare("DELETE FROM park_in WHERE p_in_id=".$_REQUEST['id']);
                        $dlt->execute();
                       } else die("You are trying to remove data that associated with others");
                        		
                        	}
                        	
                        $select=$conn->prepare("select * from park_out where total_paid is not null");
                        $select->execute();
                        $selecttotal=$conn->prepare("select sum(total_paid) as totalcash from park_out where total_paid is not null");
                        $selecttotal->execute();
                        $totalCash = $selecttotal->fetch();
                        if($select->rowCount()!=0){
                        ?>
                      
                      <div class="row">
                          <div class="col-sm-12">
                            <div class="card-box table-responsive">
                    
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>License Plate</th>
                                  <th>Entry Time</th>
                                  <th>Exit Time</th>
                                  <th>Time Spend</th>
                                  <th>Barrier Gate-Operator </th>
                                  <th>Amount</th>
                                  <?php
									if($_SESSION['function']=="Super Admin" || $_SESSION['function']=="Admin"){
									?>
                                    <!--th>Action</th-->
									<?php
									}
									?>
                                </tr>
                              </thead>
        
        
                              <tbody>
                                <?php
                                    $i=0;
                                    function getUsedTime($timeused) {
                                        $format = 'Y-m-d H:i:s';
                                        $date = DateTime::createFromFormat($format, $timeused);
                                        return $date->format('H:i:s');
                                	}
                                    while($row=$select->fetch())
                                    {
                                        $i++;
                                        $user=$row['user'];
                                        $code=$row['card_code'];
                                    
                                    $sql3="SELECT* FROM tbl_user_access WHERE u_id ='$user'";
                                    $user=$conn->prepare($sql3);
                                    $user->execute();
                                    $us=$user->fetch();
                                    
                                    $select1=$conn->prepare("select * from park_in where p_in_id = '".$row['p_in_id']."'");
                                    $select1->execute();
                                    $rowPin = $select1->fetch();
                                    $timein = getUsedTime($rowPin['entre_time']);
                                    
                                    $diff_time = strtotime($timein) - strtotime($row['exit_time']);
					                $wholeTime = gmdate('H:i:s', abs($diff_time));
                                    
                                    $sql2="SELECT* FROM park_card WHERE card_code ='$code'";
                                    $res=$conn->prepare($sql2);
                                    $res->execute();
                                    $cardtype=$res->fetch();
                                    
                                    ?>
                                     <tr>
                                        <th scope="row"><?php echo $i;?></th>
                                        <td><?php echo $rowPin['card_code'];?></td>
                                        <td><?php echo $rowPin['entre_time'];?></td>
                                        <td><?php echo $row['exit_time'];?></td>
                                        <td><?php echo $wholeTime;?></td>
                                         <td><?php echo $us['username'];?></td>
                                        <td><?php echo number_format($row['total_paid']).".00";?></td>
                                       
                                        <!--td><a href="index.php?page=park_entrances&action=Delete&id=<?php echo $row['p_in_id'];?>&date_from=<?php echo $from;?>&date_to=<?php echo $to;?>">Remove</a></td-->
                                        
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
                                    <th><?php echo number_format($totalCash['totalcash']).".00"; ?></th>
                                  </tr>
                            </tfoot>
                            </table>
                          </div>
                          </div>
                          
                          <?php
                            }else{
                            ?>
                            <div class="col-sm-12">
                              <div class="alert alert-success alert-dismissible " role="alert">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
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