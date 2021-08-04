<?php 
 header('Content-type: text/html; charset=utf-8');
 header('Content-type: application/vnd.ms-excel');
 header("Content-Disposition: attachment; filename=Exit Cars Report(".$_GET['date_from'] ."-". $_GET['date_to'].").xls");   
        
require_once ("../include/initialize.php");
  if (isset($_GET['car'])) {
    $date_from = $_GET['date_from'];
    $date_to = $_GET['date_to'];
    $no =0;
    $stmt = $db->prepare("SELECT * from `park_out` where Date(`exit_time`) BETWEEN '$date_from' AND '$date_to' ");
    try {
    $stmt->execute();
    if ($stmt->rowCount() > 0)
    
    {
		    
      $output = '<table width="100%">
      <tr><td colspan="25"><b>Exit Cars Report From: <b>'.$date_from.' To: '.$date_to.'</b></td></tr>
         
      </table><br><br>';
		    
		    
         $output.='
         
          <table border="1" cellspacing="0" cellpadding="3">
        
            <thead>
                <tr>
                    <th>#</th>
                    <th>Plate No</th>
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
        while($row=$stmt->fetch())
        {
            $i++;
            $pinid=$row['p_in_id'];
            $user=$row['user'];
            
            $sql3="SELECT* FROM tbl_user_access WHERE lst_insert_id ='$user'";
            $userac=$db->prepare($sql3);
            $userac->execute();
            $us=$userac->fetch();
            
            $sql4="SELECT* FROM park_in WHERE p_in_id = '$pinid'";
            $res=$db->prepare($sql4);
            $res->execute();
            $indata=$res->fetch();
            $user_exited = $indata['user'];
            
            $diff_time = strtotime($indata['entre_time']) - strtotime($row['exit_time']);
            $timeUsed = gmdate('H:i:s', abs($diff_time));
            
            $curr_time = empty($row['exit_time']) ? date("Y-m-d H:i:s") : $row['exit_time'];
            $tempTotalTime = differenceInHours($indata['entre_time'], $curr_time);
            
            $sql5="SELECT* FROM park_price WHERE price_plan = '$tempTotalTime'";
            $res=$db->prepare($sql5);
            $res->execute();
            $pay=$res->fetch();
            $pay['price'] = empty($pay['price']) ? '5000' : $pay['price'];
            $tamtp += $pay['price'];
            
            $sql_exit="SELECT* FROM tbl_user_access WHERE lst_insert_id ='$user_exited'";
            $user_exit=$db->prepare($sql_exit);
            $user_exit->execute();
            $us2=$user_exit->fetch();
            $user_2=$us2['lst_insert_id'];
            
            $sqlse="SELECT* FROM tbl_staff_gate_op WHERE staff_g_id ='".$us2['lst_insert_id']."'";
            $resse=$db->prepare($sqlse);
            $resse->execute();
            $opdata=$resse->fetch();
            
            $stmtop="SELECT* FROM tbl_staff_gate_op WHERE staff_g_id ='$user'";
            $stmt_QUERY=$db->prepare($stmtop);
            $stmt_QUERY->execute();
            $stmt_fetch=$stmt_QUERY->fetch();
        
            
    	
			/*******************************************************/
			$amount=$amount+$outdata['total_paid'];
             $output .='
            <tr>
                <th scope="row">'.$i.'</th>
                <td>'.$indata['card_code'].'</td>
                <td>'.$indata['entre_time'].'</td>
                <td>'.$row['exit_time'].'</td>
                <td>'.$pay['price'].'</td>
                <td>'.number_format($row['total_paid']).".00".'</td>
                <td>'.number_format($pay['price'] - $row['total_paid']).'</td>
                <td>'.$stmt_fetch['sg_name'].'</td>

            </tr>';
		    
             }
         
     $output .='	<tfoot>
                        <tr>
                            <th>Total</th>
                            <th>'.$stmt->rowCount().'</th>
                            <th></th>
                            <th></th>
                            <th>'.$tamtp.'</th>
                            <th>'.number_format($amount).'</th>
                            <th>'.number_format($tamtp - $amount).'</th>
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