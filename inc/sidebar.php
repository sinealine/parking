<div class="col-md-3 left_col">
    <div class="left_col scroll-view">

        <div class="navbar nav_title" style="border: 0;">
            <a href="" class="site_title"><img src="../img/logo_white.png" width="60%"></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="../img/profile.png" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $names; ?></h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />
        <?php
        if ($_SESSION['function'] == 1) {
        ?>
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>Main Navigation</h3>
                <ul class="nav side-menu">
                    <li><a href="?page=home"><i class="fa fa-home"></i> Dashboard</a></li>

                    <li><a><i class="fa fa-wrench"></i> Control Panel <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="?page=users">Manage Users</a></li>
                        </ul>
                    </li>

                </ul>
            </div>

        </div>
        <!-- /sidebar menu -->
        <?php
        } else	if ($_SESSION['function'] == 2) {
        ?>
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>Main Navigation</h3>
                <ul class="nav side-menu">
                    <li><a href="?page=home"><i class="fa fa-home"></i> Dashboard</a></li>

                    <li><a><i class="fa fa-cab"></i> Manage Parking <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="?page=entrances">Entrance</a></li>
                            <li><a href="?page=exit">Exits</a></li>
                            <li><a href="?page=left">Left</a></li>
                        </ul>
                    </li>

                    <li><a href="?page=srch"><i class="fa fa-search"></i> Parking Status</a></li>

                    <li><a><i class="fa fa-dollar"></i> Invoicing<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="?page=prices">Parking Price</a></li>
                            <!-- <li><a href="?page=transactions">Transaction</a></li> -->
                        </ul>
                    </li>

                    <!-- <li><a><i class="fa fa-cog"></i> Subscription <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="?page=fee_settings">Fee Settings</a></li>
                            <li><a href="?page=post_paid">Cars Paid Monthly</a></li>
                        </ul>
                    </li> -->

                    <li><a><i class="fa fa-wrench"></i> Control Panel <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="?page=operator">Manage Users</a></li>
                        </ul>
                    </li>

                    <li><a><i class="fa fa-file"></i>Reports <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="?page=rpt_indv">Individual rpt</a></li>
                            <li><a href="?page=rpt_all">Generate rpt</a></li>
                        </ul>
                    </li>
                </ul>
            </div>


        </div>
        <!-- /sidebar menu -->

        <?php
        }
        ?>
        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="../logout.php">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>