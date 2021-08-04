<?php 
 header('Content-type: text/html; charset=utf-8');
 header('Content-type: application/vnd.ms-excel');
 header("Content-Disposition: attachment; filename=Left Cars Report(".$_GET['date_from'] ."-". $_GET['date_to'].").xls");   
        
require_once ("../include/initialize.php");
  if (isset($_GET['car'])) {
    $date_from = $_GET['date_from'];
    $date_to = $_GET['date_to'];
    $no =0;
    $stmt = $db->prepare("SELECT * from `park_in` WHERE Date(entre_time) BETWEEN '$date_from' AND '$date_to' AND status = 0 ");                     
    try {
    $stmt->execute();
    if ($stmt->rowCount() > 0)
    
    {
		    
      $output = '<table width="100%">
      <tr><td colspan="25"><b>Left Cars Report From: <b>'.$date_from.' To: '.$date_to.'</b></td></tr>
         
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
                    <th>Amount To Pay</th>
                    <th>Amount Paid</th>
                    <th>Balance</th>
                    <th>Served By</th>
                </tr>
            </thead>';
        $i=0;
        $total_amount = 0;
        
        while($row=$stmt->fetch())
        {
            $i++;
            $pinid=$row['p_in_id'];
            $user=$row['user'];
            $code=$row['card_code'];
        
        
        $sql2="SELECT* FROM park_card WHERE card_code ='$code'";
        $res=$db->prepare($sql2);
        $res->execute();
        $cardtype=$res->fetch();
        
        $sql3="SELECT* FROM tbl_user_access WHERE lst_insert_id ='$user'";
        $usern=$db->prepare($sql3);
        $usern->execute();
        $us=$usern->fetch();
        
        $sql4="SELECT* FROM park_out WHERE p_in_id = '$pinid'";
        $res=$db->prepare($sql4);
        $res->execute();
        $outdata=$res->fetch();
        
        $curr_time = date("Y-m-d H:i:s");
        $diff_time = differenceInTime($row['entre_time'], $curr_time);
        $timeUsed = gmdate('H:i:s', abs($diff_time * 3600));
        // echo $timeUsed;
        
        $tempTotalTime = differenceInHours($row['entre_time'], $curr_time);
        $sql5="SELECT* FROM park_price WHERE price_plan = '$tempTotalTime'";
        $res=$db->prepare($sql5);
        $res->execute();
        $pay=$res->fetch();
        $pay['price'] = $res->rowCount() > 0 ? $pay['price'] : 5000;
        $total_amount += $pay['price'];
        
        $sqlse="SELECT* FROM tbl_staff_gate_op WHERE staff_g_id ='".$us['lst_insert_id']."'";
        $resse=$db->prepare($sqlse);
        $resse->execute();
        $opdata=$resse->fetch();
            
    	
			/*******************************************************/
			$phone = empty($row['phone']) ? '<label class="fa fa-exclamation-circle"> No data</label>' : $row['phone'];
             $output .='
            <tr>
                <th scope="row">'.$i.'</th>
                <td>'.$row['card_code'].'</td>
                <td>'.$phone.'</td>
                <td>'.$row['entre_time'].'</td>
                <td><label class="fa fa-exclamation-circle"> No data</label></td>
                <td>'.number_format($pay['price']).".00".'</td>
                <td>0</td>
                <td>'.number_format($pay['price'] - 0).'.00</td>
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
                            <th>'.number_format($total_amount).'</th>
                            <th>0</th>
                            <th>'.number_format($total_amount - 0).'</th>
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

        function differenceInTime($startdate, $enddate)
        {
            $starttimestamp = strtotime($startdate);
            $endtimestamp = strtotime($enddate);
            $hours = abs($endtimestamp - $starttimestamp) / (60 * 60);
            return $hours;
        }
    ?>