<?php
require_once("include/initialize.php");
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Control - Pub Parking </title>

    <link rel="icon" href="img/logo.jpg" type="image/ico" />

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">
    <section class="site-section-light site-section-top themed-background-default">

        <div class="container">
            <h3 class="text-center animation-slideDown"><i class="fa fa-user"></i>
                <center><strong style="color: #b4b3b3;">Logout</strong></center>
            </h3>

        </div>
    </section>


    <section class="site-content site-section">
        <div class="container">
            <?php
            $tm = date("Y-m-d H:i:s");

            if (isset($_SESSION['u_id']) and isset($_SESSION['names'])) {

                $logout_user = $db->prepare("UPDATE tbl_user_access SET last_logged_out=? WHERE u_id=?");
                try {
                    // insert into tbl_personal_ug
                    $logout_user->execute(array($tm, $_SESSION['u_id']));
                    // end to update
                    $name = strtoupper($_SESSION['names']);


                    session_unset();
                    session_destroy();



                    echo "<br /><br /><center><font style='color: #b4b3b3;' face='Verdana' size='2' >Dear <b>" . $name . "</b>, You have successfully logged out. <br /><br /><br /></font></center>";

                    echo "<br /><br /><center><font style='color: #b4b3b3;' face='Verdana' size='2' > <a href='index.php'>Go to!</a><br /><br /><br /></font></center>";
                } catch (PDOException $ex) {
                    //Something went wrong rollback!			
                    echo $ex->getMessage();
                }
            } else {
                echo "<br><center> <font face='Verdana' size='2' color=red>No User Data. Use your login and try!. <br/><br/><br/> </center><br><center><input type='button' value='Retry' onClick='history.go(-1)'></font></center>";
            }

            ?>
            <br>
            <!-- END form Content -->
        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br>

        <?php
        echo '<meta http-equiv="refresh"' . 'content="3;URL=index.php">';
        ?>
    </section>
</body>

</html>