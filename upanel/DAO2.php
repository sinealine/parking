<?php
class DAO2
{

	public function searchData($searchVal)
	{
		try {
			$pdo = new PDO('mysql:host=localhost;dbname=db_parking', 'root', '');
			$stmt = $pdo->prepare("SELECT DISTINCT(card_code), p_in_id, phone FROM `park_in` WHERE `card_code` like :searchVal OR `phone` like :searchVal order by `entre_time` DESC");
			$val = "%$searchVal%";
			$stmt->bindParam(':searchVal', $val, PDO::PARAM_STR);
			$stmt->execute();

			$Count = $stmt->rowCount();

			$result = "";
			if ($Count  > 0) {
				while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$result = $result . '<div class="search-result" id="' . $data['p_in_id'] . '">
				   <div>' . $data['card_code'] . '</div><div>' . $data['phone'] . '</div></div>';
				}
				return $result;
			}
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}
	}
}