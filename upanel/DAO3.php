<?php
class DAO3{
    
	public function setStatus($id){
		try {
			$pdo = new PDO('mysql:host=localhost;dbname=db_parking', 'root', '');
            
            $stmt = $pdo->prepare("SELECT *from `tbl_fee_settings` WHERE `id` = '$id'");
			$stmt->execute();
			$fetchStatus = $stmt->fetch();
            
            $status= 0;
            if($fetchStatus['status'] == 1) {
                $status = 0;
            }
            else {
                $status = 1;
            }
			$stmt2 = $pdo->prepare("UPDATE `tbl_fee_settings` set `status` = '$status' WHERE `id` = '$id'");
			$stmt2->execute();

		}
		catch (PDOException $e) {
			echo 'Something Wrong: ' . $e->getMessage();
		}
	}	
	
}