<?php
class DAO5{
    
	public function setCarReport($stat, $d1, $d2){
		try {
			$pdo = new PDO('mysql:host=localhost;dbname=db_parking', 'root', '');
            
            $stmt = $pdo->prepare("SELECT sum(total_paid) as total_amount, exit_time from `park_out` GROUP By DATE(exit_time) HAVING exit_time BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY) ");
			$stmt->execute();
			$no = 0;
			$result = "";
			while($fetchStatus = $stmt->fetch()) {
			    $no += 1;
			   $result = $result .'<tr><th scope="row">'. $no .'</th><td>'. $fetchStatus["exit_time"] .'</td><td>'. number_format($fetchStatus["total_amount"]) .'</td></tr>';
			}
		    return $result;
		}
		catch (PDOException $e) {
			echo 'Something Wrong: ' . $e->getMessage();
		}
	}	
	
}