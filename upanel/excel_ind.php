<?php 
 header('Content-type: text/html; charset=utf-8');
 header('Content-type: application/vnd.ms-excel');
 header("Content-Disposition: attachment; filename= Individual Report (".$_GET['date_from'] ."-". $_GET['date_to'].").xls");   
        
require_once ("../include/initialize.php");
  if (isset($_GET['user'])) {
    $user = $_GET['user'];
    $date_from = $_GET['date_from'];
    $date_to = $_GET['date_to'];
    $no =0;
    $stmt=$conn->prepare("select * from park_in where user = '$user' AND Date(entre_time) BETWEEN '$date_from' AND  DATE_ADD('$date_to', INTERVAL 1 DAY) ");
    try {
    $stmt->execute();
    if ($stmt->rowCount() > 0)
    
    {
        
        $stmtop="SELECT* FROM tbl_staff_gate_op WHERE staff_g_id ='$user'";
        $stmt_QUERY=$db->prepare($stmtop);
        $stmt_QUERY->execute();
        $stmt_fetch=$stmt_QUERY->fetch();
      $output = '<table width="100%">
      <tr><th colspan="10"><b>Individual Report</th></tr>
      <tr><td><b>Names: </b> '.$stmt_fetch['sg_name'].'</td></tr>
      <tr><td><b>Tel: </b> '.$stmt_fetch['sg_phone'].'</td></tr>
      <tr><td><b>Date: </b> '.$date_from.' To: '.$date_to.'</td></tr>
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
                </tr>
            </thead>';
        $i=0;
        $tamtp = 0;
        while($row=$stmt->fetch())
        {
            $i++;
            $pinid=$row['p_in_id'];
            $user=$row['user'];
            $code=$row['card_code'];
        
        $sql3="SELECT* FROM tbl_user_access WHERE lst_insert_id ='$user'";
        $user=$conn->prepare($sql3);
        $user->execute();
        $us=$user->fetch();
        
        $sql4="SELECT* FROM park_out WHERE p_in_id = '$pinid'";
        $res=$conn->prepare($sql4);
        $res->execute();
        $outdata=$res->fetch();
        $user_exited = $outdata['user'];
        
        $curr_time = empty($outdata['exit_time']) ? date("Y-m-d H:i:s") : $outdata['exit_time'];
    					                
        $tempTotalTime = differenceInHours($row['entre_time'], $curr_time);
        
        $sql5="SELECT* FROM park_price WHERE price_plan = '$tempTotalTime'";
        $res=$db->prepare($sql5);
        $res->execute();
        $pay=$res->fetch();
        $tamtp += $pay['price'];
        
        $diff_time = strtotime($row['entre_time']) - strtotime($outdata['exit_time']);
        $timeUsed = gmdate('H:i:s', abs($diff_time));
        
        $sql_exit="SELECT* FROM tbl_user_access WHERE lst_insert_id ='$user_exited'";
        $user_exit=$conn->prepare($sql_exit);
        $user_exit->execute();
        $us2=$user_exit->fetch();
        $user_2=$us2['lst_insert_id'];
        
    	
			/*******************************************************/
			$row['phone'] = empty($row['phone']) ? '<label class="fa fa-exclamation-circle"> No data</label>' : $row['phone'];
            $amount=$amount+$outdata['total_paid'];
            
            $output .='
            <tr>
                <th scope="row">'.$i.'</th>
                <td>'.$code.'</td>
                <td>'.$row['phone'].'</td>
                <td>'.$row['entre_time'].'</td>
                <td>'.$outdata['exit_time'].'</td>
                <td>'.$pay['price'].'</td>
                <td>'.number_format($outdata['total_paid']).".00".'</td>
                <td>'.number_format($pay['price'] - $outdata['total_paid']).'</td>

            </tr>';
		    
             }
         
     $output .='	<tfoot>
                        <tr>
                            <th>Total</th>
                            <th>'.$stmt->rowCount().'</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>'.$tamtp.'</th>
                            <th>'.number_format($amount).'</th>
                            <th>'.number_format($tamtp - $amount).'</th>
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