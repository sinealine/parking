<?php
include("DAO.php");
include("DAO2.php");
include("DAO3.php");
include("DAO4.php");
include("DAO5.php");
include("DAO6.php");
if(isset($_POST["search-data"])){
	$searchVal = trim($_POST["search-data"]);
	$dao = new DAO2();
	echo $dao->searchData($searchVal);
}

if(isset($_POST["get-data"])){
	$getVal = trim($_POST["get-data"]);
	$dao = new DAO();
	echo $dao->searchData($getVal);
}

if(isset($_POST["id"])){
	$id = $_POST["id"];
	$dao = new DAO3();
	echo $dao->setStatus($id);
}

if(isset($_POST["post-id"])){
	$id = $_POST["post-id"];
	$dao = new DAO4();
	echo $dao->setPostStatus($id);
}

if(isset($_POST["car-stat"])){
	$stat = $_POST["car-stat"];
	$date1 = $_POST["date1"];
	$date2 = $_POST["date2"];
	$dao = new DAO5();
	echo $dao->setCarReport($stat, $date1, $date2);
}

if(isset($_POST["car-op"])){
	$op = $_POST["car-op"];
	$date1 = $_POST["date1"];
	$date2 = $_POST["date2"];
	$dao = new DAO6();
	echo $dao->setOpReport($op, $date1, $date2);
}

?>