<?php
ob_start();
include "./include/initialize.php";
// alert("login");
if (isset($_REQUEST['loginbtn'])) {
    $sql = $db->prepare("SELECT * FROM tbl_user_access WHERE username='" . $_REQUEST['username'] . "' AND password='" . $_REQUEST['password'] . "' AND `function`=2 ");
    $sql->execute();
    if ($sql->rowCount() != 0) {
        $res = $sql->fetch();

        $_SESSION['u_id'] = $res['u_id'];
        $_SESSION['stn_id'] = $res['u_names'];
        $_SESSION['user_access'] = $res['username'];
        $_SESSION['function'] = $res['function'];
        $_SESSION['names'] = $res['u_names'];
        $_SESSION['email'] = $res['email'];
        $_SESSION['last_ID'] = $res['lst_insert_id'];
        $_SESSION['access'] = true;
        $today = date("Y-m-d H:i:s");

        $login_time = $db->prepare("UPDATE tbl_user_access set last_logged_in=? WHERE u_id=?");
        try {
            // time logged
            $login_time->execute(array($today, $_SESSION['u_id']));
        } catch (PDOException $ex) {
            //Something went wrong rollback!
            echo $ex->getMessage();
        }
        header('Location:upanel/index.php');
    } else {

        $msg = "Your username or password is incorrect!";
        header('Location:index.php?msg=' . $msg);
    }
} else {

    $sql = $db->prepare("SELECT * FROM tbl_user_access WHERE username='guest' AND password= 123 ");
    $sql->execute();
    if ($sql->rowCount() != 0) {
        $res = $sql->fetch();

        $_SESSION['u_id'] = $res['u_id'];
        $_SESSION['stn_id'] = $res['stn_id'];
        $_SESSION['user_access'] = $res['username'];
        $_SESSION['function'] = $res['function'];
        $_SESSION['password'] = $res['password'];
        $_SESSION['names'] = $res['u_names'];
        $_SESSION['email'] = $res['email'];
        $_SESSION['access'] = false;
        header('Location:upanel/index.php');
    }
}

if (isset($_GET['apicall'])) {

    // android app access apis

    $response = array();
    $response['yo'] = "h";

    switch ($_GET['apicall']) {
            //  working api
        case 'new_register':
            if (isTheseParametersAvailable(array('id', 'lplate', 'phone'))) {
                $id = $_POST['id'];
                $lplate = $_POST['lplate'];
                $phone = $_POST['phone'];
                $status = 0;

                $stmt = $db->prepare("SELECT * FROM park_in WHERE card_code = ? AND status = ?");
                $stmt->execute([$lplate, $status]);

                if ($stmt->rowCount() > 0) {
                    $response['error'] = true;
                    $response['message'] = 'Car is already in Parking';
                } else if ($phone == "null") {
                    $response['error'] = false;
                    $response['message'] = 'add phone';
                } else {
                    $date_now = date("Y-m-d H:i:s");
                    $stmt2 = $db->prepare("INSERT INTO park_in (card_code, phone, entre_time, user) VALUES (?, ?, ?, ?)");
                    $stmt2->execute([$lplate, $phone, $date_now, $id]);

                    if ($stmt2) {
                        $id = $db->lastInsertId();
                        $stmt2 = $db->prepare("INSERT into park_out (p_in_id, credit) VALUES (?, ?)");
                        $stmt2->execute([$id, 0]);
                        $response['error'] = false;
                        $response['message'] = 'Car is parked successfully';
                        $response['id'] = $id;
                        if ($phone != "" || !empty($phone)) {
                           
                        }
                    }
                }
            } else {
                $response['error'] = true;
                $response['message'] = 'required parameters are not available';
            }

            break;

        case 'login':

            if (isTheseParametersAvailable(array('username', 'password'))) {

                $username = $_POST['username'];
                $password = $_POST['password'];
                $date_now = date("Y-m-d H:i:s");

                $stmt = $db->prepare("SELECT * FROM tbl_user_access WHERE username='" . $username . "' AND password='" . $password . "' AND `function` = 3");
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $id = $row['lst_insert_id'];
                    $stmt2 = $db->prepare("UPDATE `tbl_user_access` SET `last_logged_in` = '$date_now' WHERE `lst_insert_id` = '$id' AND `function` = 3");
                    $stmt2->execute();

                    $user = array(
                        'id' => $row['lst_insert_id'],
                        'username' => $row['username'],
                    );

                    $response['error'] = false;
                    $response['message'] = 'Login successful';
                    $response['user'] = $user;
                } else {
                    $response['error'] = true;
                    $response['message'] = 'Invalid username or password';
                }
            }
            break;

        case 'add':
            if (isTheseParametersAvailable(array('id', 'lplate', 'phone'))) {
                $id = $_POST['id'];
                $lplate = $_POST['lplate'];
                $phone = $_POST['phone'];
                $date_now = date("Y-m-d H:i:s");
                $stmt = $db->prepare("INSERT INTO park_in (card_code, phone, entre_time, user) VALUES (?, ?, ?, ?)");
                $stmt->execute([$lplate, $phone, $date_now, $id]);

                if ($stmt) {
                    $response['error'] = false;
                    $response['message'] = 'Car is parked successfully';
                    $response['time'] = $date_now;
                }
            } else {
                $response['error'] = true;
                $response['message'] = 'required parameters are not available';
            }
            break;

        case 'carlist':
            $stat = 0;
            $plate = $_POST['lplate'];
            $stmt = $db->prepare("SELECT * FROM park_in WHERE card_code = ? AND status = ? order by entre_time desc");
            $stmt->execute([$plate, $stat]);
            $rowNum = $stmt->rowCount();
            $date_now = date("Y-m-d H:i:s");

            while ($row = $stmt->fetch()) {
                $stmt2 = $db->prepare("SELECT u_names FROM tbl_user_access WHERE lst_insert_id = ? AND function = 3");
                $stmt2->execute([$row['user']]);
                $row2 = $stmt2->fetch();

                $temp = array();
                $temp['id'] = $row['p_in_id'];
                $temp['names'] = $row2['u_names'];
                $temp['plate'] = $row['card_code'];

                $t1 = (new DateTime($row['entre_time']))->format('Y-m-d');
                $t2 = (new DateTime($date_now))->format('Y-m-d');
                if ($t1 != $t2) {
                    $temp['time'] = $row['entre_time'];
                    $temp['timeout'] = $date_now;
                } else {
                    $temp['time'] = getUsedTime($row['entre_time']);
                    $temp['timeout'] = getUsedTime($date_now);
                }
                $temp['phone'] = $row['phone'];

                // calculate used hours
                $time = date($row['entre_time']);
                $diff_time = differenceInTime($row['entre_time'], $date_now);
                $usedTime = gmdate('H:i:s', abs($diff_time * 3600));
                $temp['hours_used'] = $usedTime;
                $amount = differenceInHours($row['entre_time'], $date_now);
                $temp['total_time'] = $amount;

                //         fetch park price
                $stmt3 = $db->prepare("SELECT * FROM park_price WHERE price_plan = ?");
                $stmt3->execute([$amount]);
                $row3 = $stmt3->fetch();
                if ($amount > 5 || ($stmt3->rowCount() < 1)) {
                    $row3['price'] = 5000;
                }
                $temp['pay'] = $row3['price'];
                array_push($response, $temp);
            }
            $response['cars'] = $response;
            $response['rowNums'] = $rowNum;
            break;

        case 'carlist/remove':
            $id = $_POST['id'];
            $phone = $_POST['phone'];
            $hours = $_POST['total_hours'];
            $paid = $_POST['total_paid'];
            $serve = $_POST['served_by'];
            $stmt = $db->prepare("UPDATE `park_in` set status = 1 WHERE `p_in_id`='$id'");

            if ($stmt->execute()) {
                $date_now = date("Y-m-d H:i:s");
                $stmt2 = $db->prepare("UPDATE `park_out` set exit_time = '$date_now', tot_hours = $hours, total_paid = $paid, user = $serve WHERE `p_in_id` = '$id' AND `user` is NULL");

                if ($stmt2->execute()) {
                    $stmt3 = $db->prepare("SELECT * from `park_in` WHERE `p_in_id`='$id'");
                    $stmt3->execute();
                    $row3 = $stmt3->fetch();
                    $timein = $row3['entre_time'];
                    $timein2 = getUsedTime($timein);

                    $stmt4 = $db->prepare("SELECT * from `park_out` WHERE `p_in_id` = '$id'");
                    $stmt4->execute();
                    $row4 = $stmt4->fetch();
                    $timeout = $row4['exit_time'];
                    $timeout2 = getUsedTime($timeout);

                    $diff_time = differenceInTime($timein2, $timeout2);
                    $usedTime = gmdate('H:i:s', abs($diff_time * 3600));
                    if ($phone != "" || !empty($phone)) {
                        $msg = "Thank you for being our valued customer. Time in: " . $timein2 . " Time out: " . $timeout2 . " Time spent: " . $usedTime . " Amount: " . $row4['total_paid'] . ".00 More Info call 0788730582";
                        $data = array(
                            "sender" => '+250780674459',
                            "recipients" => $phone,
                            "message" => $msg,
                        );
                
                        $url = "https://www.intouchsms.co.rw/api/sendsms/.json";
                        $data = http_build_query($data);
                        $username = "julesntare";
                        $password = "ju.jo.123.its";

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                        $result = curl_exec($ch);
                        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        curl_close($ch);

                        $response['error'] = false;
                        $response['message'] = 'removed successful';
                        $response['pin'] = $row3['p_out_id'];
                        $response['statusCode'] = $httpcode;
                    } else {
                        $response['error'] = false;
                        $response['message'] = 'removed successful with no msg';
                    }
                }
            }
            break;

        case 'logout':
            $id = $_POST['id'];
            $date_now = date("Y-m-d H:i:s");
            $stmt2 = $db->prepare("UPDATE `tbl_user_access` SET `last_logged_out` = '$date_now' WHERE `lst_insert_id` = '$id' AND `function` = 3");
            if ($stmt2->execute()) {
                $response['error'] = false;
            } else {
                $response['error'] = true;
            }
            break;

        default:
            $response['error'] = true;
            $response['message'] = 'Invalid Operation Called';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Invalid API Call';
}

echo json_encode($response);

function isTheseParametersAvailable($params)
{

    foreach ($params as $param) {
        if (!isset($_POST[$param])) {
            return false;
        }
    }
    return true;
}

function differenceInHours($startdate, $enddate)
{
    $starttimestamp = strtotime($startdate);
    $endtimestamp = strtotime($enddate);
    $hours = abs($endtimestamp - $starttimestamp) / (60 * 60);
    return ceil($hours);
}

function differenceInTime($startdate, $enddate)
{
    $starttimestamp = strtotime($startdate);
    $endtimestamp = strtotime($enddate);
    $hours = abs($endtimestamp - $starttimestamp) / (60 * 60);
    return $hours;
}

function getUsedTime($timeused)
{
    $format = 'Y-m-d H:i:s';
    $date = DateTime::createFromFormat($format, $timeused);
    return $date->format('H:i:s');
}

ob_end_flush();