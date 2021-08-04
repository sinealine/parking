<?php
class DAO6{
    
	public function setOpReport($op, $d1, $d2){
		try {
			$pdo = new PDO('mysql:host=localhost;dbname=db_parking', 'root', '');
            
            $stmt = $pdo->prepare("SELECT sum(total_paid) as total_amount, user from `park_out` WHERE user = '$op' AND exit_time BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY) ");
			$stmt->execute();
			$no = 0;
			$result = "";
			while($fetchStatus = $stmt->fetch()) {
			    $no += 1;
			    $sql3="SELECT* FROM tbl_staff_gate_op WHERE staff_g_id ='$op'";
                $res=$pdo->prepare($sql3);
                $res->execute();
                $opdata=$res->fetch();
			    $result=$result.'<h3>Individual Report</h3><hr><br>
                              <h6>From: '.$d1.'</h6><br>
                              <h6>To: '.$d2.'</h6><br>
                              <h6>Operator: '.$opdata['sg_name'].'</h6><br>
                              <h6>Total Amount Received: '.number_format($fetchStatus["total_amount"]).'</h6><br>';
			}
		    return $result;
		}
		catch (PDOException $e) {
			echo 'Something Wrong: ' . $e->getMessage();
		}
	}	
	
}