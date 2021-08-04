<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <nav class="nav navbar-nav">
            <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown"
                        data-toggle="dropdown" aria-expanded="false">
                        <img src="../img/profile.png" alt=""><?php echo $names; ?>
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="index?page=profile"> Profile</a>
                        <!--<a class="dropdown-item"  href="javascript:;">-->
                        <!--    <span class="badge bg-red pull-right">50%</span>-->
                        <!--    <span>Settings</span>-->
                        <!--</a>-->
                        <a class="dropdown-item" href="../logout.php"><i class="fa fa-sign-out pull-right"></i> Log
                            Out</a>
                    </div>
                </li>

                <li role="presentation" class="nav-item dropdown open">
                    <?php include '../inc/topbar_search.php'; ?>
                </li>

            </ul>
            </li>
            </ul>
        </nav>
    </div>
</div>