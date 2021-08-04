<?php
$dt = date("Y-m-d");
$tim = date("H:i:s");
?>
<!DOCTYPE html>
<html lang="en">

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

    <!-- Custom Theme Style -->
    <link href="build/css/custom.css" rel="stylesheet">
</head>

<body class="login">
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form action="auth.php" method="POST">
                        <h1>&bullet; Public Parking Control &bullet;</h1>
                        <?php
                        if (isset($_REQUEST['msg'])) {
                        ?>
                        <TABLE align='center'>
                            <TR>
                                <TD>
                                    <FONT SIZE="3" COLOR="red"><strong><?php echo $_REQUEST['msg']; ?></strong></FONT>
                                </TD>
                            </TR>
                        </TABLE>
                        <?php
                        }
                        ?>
                        <div>
                            <input type="text" class="form-control" name="username" placeholder="Username"
                                required="" />
                        </div>
                        <div>
                            <input type="password" class="form-control" name="password" placeholder="Password"
                                required="" />
                        </div>
                        <div>
                            <button type="submit" name="loginbtn" class="btn btn-default"><i class="fa fa-sign-in"></i>
                                Log in</button>
                            <a class="reset_pass" href="./parking_apk/parkin.apk"><i class="fa fa-android"></i> Android
                                App</a>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <div class="clearfix"></div>
                            <br />
                            <div>
                                <p>Copyright &copy; <script>
                                    document.write(new Date().getFullYear());
                                    </script> All Rights Reserved. <br /> <a href="#">Developer, Tel: (+250)
                                        788-888-888</a></p>
                            </div>

                        </div>
                    </form>
                </section>
            </div>

        </div>
    </div>
</body>

</html>