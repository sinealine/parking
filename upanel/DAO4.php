<?php
class DAO4{
    
	public function setPostStatus($id){
		try {
			$pdo = new PDO('mysql:host=localhost;dbname=db_parking', 'root', '');
            
            $stmt = $pdo->prepare("SELECT *from `post_paid_card` WHERE `pp_id` = '$id'");
			$stmt->execute();
			$fetchStatus = $stmt->fetch();
            
            $status= 0;
            if($fetchStatus['status'] == 1) {
                $status = 0;
            }
            else {
                $status = 1;
            }
			$stmt2 = $pdo->prepare("UPDATE `post_paid_card` set `status` = '$status' WHERE `pp_id` = '$id'");
			$stmt2->execute();

		}
		catch (PDOException $e) {
			echo 'Something Wrong: ' . $e->getMessage();
		}
	}	
	
}