<?php 
 header('Content-type: text/html; charset=utf-8');
 header('Content-type: application/vnd.ms-excel');
 header("Content-Disposition: attachment; filename=All Cars Report(".$_GET['date_from'] ."-". $_GET['date_to'].").xls");   
        
require_once ("../include/initialize.php");
  if (isset($_GET['car'])) {
    $date_from = $_GET['date_from'];
    $date_to = $_GET['date_to'];
    $no =0;
    $stmt = $db->prepare("SELECT * from `park_in` where Date(`entre_time`) BETWEEN '$date_from' AND DATE_ADD('$date_to', INTERVAL 1 DAY) ");                     
    try {
    $stmt->execute();
    if ($stmt->rowCount() > 0)
    
    {
		    
      $output = '<table width="100%">
      <tr><td colspan="25"><b>All Cars Report From: <b>'.$date_from.' To: '.$date_to.'</b></td></tr>
         
      </table><br><br>';
		    
		    
         $output.='
         
          <table border="1" cellspacing="0" cellpadding="3">
        
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
            </thead>';
        $i=0;
        $tamp = 0;
        $tamtp = 0;
		while($row = $stmt->fetch()) {
            $i++;
            $pid = $row['p_in_id'];
            $user = $row['user'];
            $code = $row['card_code'];
            $phone = $row['phone'];
            
            $sqlpo="SELECT* FROM park_out WHERE p_in_id ='$pid'";
            $qpout=$db->prepare($sqlpo);
            $qpout->execute();
            $fpout = $qpout->fetch();
            $tamp += $fpout['total_paid'];
            
            $sql3="SELECT* FROM tbl_user_access WHERE lst_insert_id ='$user'";
            $user=$db->prepare($sql3);
            $user->execute();
            $us=$user->fetch();
            
            $curr_time = empty($fpout['exit_time']) ? date("Y-m-d H:i:s") : $fpout['exit_time'];
            
            $tempTotalTime = differenceInHours($row['entre_time'], $curr_time);
            
            $sql5="SELECT* FROM park_price WHERE price_plan = '$tempTotalTime'";
            $res=$db->prepare($sql5);
            $res->execute();
            $pay=$res->fetch();
            $tamtp += $pay['price'];
            
            $sql3="SELECT* FROM tbl_staff_gate_op WHERE staff_g_id ='".$us['lst_insert_id']."'";
            $res=$db->prepare($sql3);
            $res->execute();
            $opdata=$res->fetch();
            
    	
			/*******************************************************/
			$phone = empty($phone) ? '<label class="fa fa-exclamation-circle"> No data</label>' : $phone;
			$fpout['exit_time'] = empty($fpout['exit_time']) ? '<label class="fa fa-exclamation-circle"> No data</label>' : $fpout['exit_time'];
			$fpout['total_paid'] = empty($fpout['total_paid']) ? '<label class="fa fa-exclamation-circle"> No data</label>' : $fpout['total_paid']; 
             $output .='
            <tr>
                <th scope="row">'.$i.'</th>
                <td>'.$code.'</td>
                <td>'.$phone.'</td>
                <td>'.$row['entre_time'].'</td>
                <td>'.$fpout['exit_time'].'</td>
                <td>'.number_format($pay['price']).".00".'</td>
                <td>'.number_format($fpout['total_paid']).'.00</td>
                <td>'.number_format($pay['price'] - $fpout['total_paid']).'.00</td>
                <td>'.$opdata['sg_name'].'</td>

            </tr>';
		    
             }
         
     $output .='	<tfoot>
                        <tr>
                            <th>Total</th>
                            <th>'.$stmt->rowCount().'</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>'.number_format($tamtp).'</th>
                            <th>'.number_format($tamp).'</th>
                            <th>'.number_format($tamtp - $tamp).'</th>
                            <th></th>
                        </tr>
                    </tfoot>';

        $output .='</table>';
        
          $output .='
         <table>
         <tr>
         <td>
         <p>Prapared From: 
             <br/>
             <b>Cparking System</b>
             <br/>
              Approved 
             </p>
             
             </td>
             </tr>
             </table>
             ';
         
         echo $output;
          
		}
		
        }
    catch (PDOException $ex) {
      echo $ex->getMessage();
    }
  }
  ?>
  
  <?php                                               
        function getUsedTime($timeused) {
            $format = 'Y-m-d H:i:s';
            $date = DateTime::createFromFormat($format, $timeused);
            return $date->format('H:i:s');
    	}
    	
    	function differenceInHours($startdate,$enddate) {
    		$starttimestamp = strtotime($startdate);
    		$endtimestamp = strtotime($enddate);
    		$difference = abs($endtimestamp - $starttimestamp)/3600;
    		return ceil($difference);
    	}
    ?>