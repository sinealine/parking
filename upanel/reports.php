<?php
    ob_start();
    
    // get date from timestamp
    $date_now = date("Y-m-d H:i:s");
    $date_today = date('Y-m-d', strtotime($date_now));
    
    // get today's entered cars
    $stmt = $conn->prepare("SELECT count(p_in_id) as `total_entered` FROM `park_in` WHERE DATE(entre_time) = '$date_today' ");
	$stmt->execute();
	$total_entered = $stmt->fetch();
	
	// get today's exit cars
    $stmt2 = $conn->prepare("SELECT count(p_in_id) as `total_exit` FROM `park_in` WHERE DATE(entre_time) = '$date_today' AND `status` = 1");
	$stmt2->execute();
	$total_exit = $stmt2->fetch();
	
	// get today's left cars
    $stmt3 = $conn->prepare("SELECT count(p_in_id) as `total_left` FROM `park_in` WHERE DATE(entre_time) = '$date_today' AND `status` = 0");
	$stmt3->execute();
	$total_left = $stmt3->fetch();
	
	// get today's received cash
    $stmt4 = $conn->prepare("SELECT sum(total_paid) as `today_cash` FROM `park_out` WHERE DATE(exit_time) = '$date_today' AND `total_paid` is not null");
	$stmt4->execute();
	$today_cash = $stmt4->fetch();
	if(empty($today_cash['today_cash'])) {
	    $today_cash['today_cash'] = 0;
	}
	
	// get all received cash
    $stmt5 = $conn->prepare("SELECT sum(total_paid) as `all_cash` FROM `park_out` WHERE `total_paid` is not null");
	$stmt5->execute();
	$all_cash = $stmt5->fetch();
	if(empty($all_cash['all_cash'])) {
	    $all_cash['all_cash'] = 0;
	}
    
    ob_end_flush();
?>