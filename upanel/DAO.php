<?php
class DAO
{
	public function searchData($searchVal)
	{
		try {
			$pdo = new PDO('mysql:host=localhost;dbname=db_parking', 'root', '');
			$stmt = $pdo->prepare("SELECT * FROM `park_in` WHERE `p_in_id` = $searchVal");
			$stmt->execute();

			$Count = $stmt->rowCount();

			$result = "";
			if ($Count  > 0) {
				$curr_time = date("Y-m-d H:i:s");

				function differenceInHours($startdate, $enddate)
				{
					$starttimestamp = strtotime($startdate);
					$endtimestamp = strtotime($enddate);
					$difference = abs($endtimestamp - $starttimestamp) / 3600;
					return ceil($difference);
				}

				while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$diff_time = strtotime($data['entre_time']) - strtotime($curr_time);
					$timeUsed = gmdate('H:i:s', abs($diff_time));
					if ($data['entre_time']) {

						$username = $data['user'];

						$sql5 = "SELECT* FROM `tbl_user_access` WHERE `function` = 3 and `lst_insert_id` = '$username'";
						$res = $pdo->prepare($sql5);
						$res->execute();
						$user = $res->fetch();
					}
					$result = $result . '<div class="search-result whole" style="display:flex; flex-direction: column; background: #fff; width:100%; min-height: 100%;">
				   <div><span>License Plate:</span> <span>' . $data['card_code'] . "
				   </span></div><div><span>Phone Number:</span> <span>" . $data['phone'] . "</span></div> <div><span>Time In:</span> <span>" . $data['entre_time'] . "</span></div> <div><span> Time Used:</span>
				   <span>" . $timeUsed . "</span></div> <div><span> Served By:</span> <span>" . $user['u_names'] . "</span>" . '</div></div>';
				}
				return $result;
			}
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}
	}
}