<?php
require_once("../include/initialize.php");
if ($u_id == '' or $names == '') {
	echo "<script>window.location.replace('../index.php')</script>";
}

if (isset($_SESSION['from'])) {

	$crit_entre = "entre_time >='" . $_SESSION['from'] . "' and entre_time <='" . $_SESSION['to'] . "'";
	$crit_exit = "exit_time >='" . $_SESSION['from'] . "' and exit_time <='" . $_SESSION['to'] . "' and tot_hours!=0";
	$crit_moneytoday = "`date`>='" . $_SESSION['from'] . "' and `date`<='" . $_SESSION['to'] . "'";
} else if (isset($_REQUEST['date_from'])) {
	$from = $_REQUEST['date_from'] . " 00:00:00";
	$to = $_REQUEST['date_to'] . " 23:59:59";
	$_SESSION['from'] = $from;
	$_SESSION['to'] = $to;
	$crit_entre = "entre_time >='" . $_SESSION['from'] . "' and entre_time <='" . $_SESSION['to'] . "'";
	$crit_exit = "exit_time >='" . $_SESSION['from'] . "' and exit_time <='" . $_SESSION['to'] . "' and tot_hours!=0";
	$crit_moneytoday = "`date`>='" . $_SESSION['from'] . "' and `date`<='" . $_SESSION['to'] . "'";
} else {
	$from = date('Y-m-d', time()) . " 00:00:00";
	$to = date('Y-m-d', time()) . " 23:59:59";
	$crit_entre = "entre_time>='" . date('Y-m-d', time()) . " 00:00:00'";
	$_SESSION['from'] = $from;
	$_SESSION['to'] = $to;
	$crit_entre = "entre_time >='" . $_SESSION['from'] . "' and entre_time <='" . $_SESSION['to'] . "'";
	$crit_exit = "exit_time >='" . $_SESSION['from'] . "' and exit_time <='" . $_SESSION['to'] . "' and tot_hours!=0";
	$crit_moneytoday = "`date`>='" . $_SESSION['from'] . "' and `date`<='" . $_SESSION['to'] . "'";
}


$content = 'dashboard.php';
$view = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : '';

switch ($view) {

	case 'home':
		$title = "Dashboard";
		$content = 'dashboard.php';
		break;

	case 'entrances':
		$title = "Parking Entrances";
		$content = 'park_entrances.php';
		break;

	case 'exit':
		$title = "Parking Exit";
		$content = 'park_exit.php';
		break;

	case 'left':
		$title = "Parking Left";
		$content = 'park_left.php';
		break;

	case 'todaycash':
		$title = "Parking Today Cash";
		$content = 'parking_today_cash.php';
		break;

	case 'allcash':
		$title = "Parking All Cash";
		$content = 'parking_all_cash.php';
		break;

	case 'prices':
		$title = "Parking price";
		$content = 'cparking_prices.php';
		break;

	case 'transactions':
		$title = "Parking Transaction Lists";
		$content = 'transactions.php';
		break;

	case 'fee_settings':
		$title = "Fees Settings";
		$content = 'fee_settings/manage_fee_settings.php';
		break;

	case 'update_fee_settings':
		$title = "Update Fee Settings";
		$content = 'fee_settings/update_fee_settings.php';
		break;

	case 'post_paid':
		$title = "Cash Paid Monthly";
		$content = 'post_paid/manage_post_paid.php';
		break;

	case 'update_post_paid':
		$title = "Update Cash Paid Monthly";
		$content = 'post_paid/update_post_paid.php';
		break;

	case 'users':
		$title = "Manage User Access";
		$content = 'SuperAdmin/manage_users.php';
		break;

	case 'updateuser':
		$title = "Update User Access";
		$content = 'SuperAdmin/update_user.php';
		break;

	case 'profile':
		$title = "My Profile";
		$content = 'profile.php';
		break;

	case 'srch':
		$title = "Car Status";
		$content = 'car-search.php';
		break;

		// 		case 'rpt_ind' :
		//      $title="Parking Report";	
		// 		$content='rpt-generate-ind.php';		
		// 		break;

	case 'rpt_indv':
		$title = "Individual Report";
		$content = 'rpt_indv_all.php';
		break;

	case 'rpt_all':
		$title = "Parking Report";
		$content = 'rpt-generate-all.php';
		break;

	case 'operator':
		$title = "Gate Operator";
		$content = 'gate_oprt.php';
		break;

	default:
		$title = "Home";
		$content = 'dashboard.php';
}

require_once("../inc/container.php");