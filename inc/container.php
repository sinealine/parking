<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../img/logo.jpg" type="image/ico" />

    <style type="text/css">
    .search-result {
        display: flex;
        align-content: center;
        justify-content: space-around;
        background: #fff;
        width: 100%;
        min-height: 100%;
        border-bottom: 1px solid #777;
    }

    .search-result>div {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        flex-wrap: wrap;
        width: 50%;
        height: 40px;
    }

    .search-result.whole>div {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        width: 100%;
        height: 40px;
    }

    .search-result.whole>div:nth-child(1) {
        border: none;
    }

    .search-result>div:nth-child(1) {
        border-right: 2px solid #777;
    }

    .search-result>div:nth-child(2) {
        justify-content: flex-end;
    }

    .search-result:not(.whole):hover {
        background: #777;
        color: #fff;
        cursor: pointer;
    }

    .search-result>div span {
        width: 50%;
    }

    .switch-container {
        position: relative;
        top: 10px;
        left: 30px;
        transform: translate(-40%, -40%);
    }

    .switch-toggle-btn,
    .post-paid-btn {
        width: 50px;
        height: 20px;
        background: gray;
        border-radius: 30px;
        transition: all 400ms ease-in-out;
    }

    .switch-toggle-btn>.circle,
    .post-paid-btn>.circle {
        width: 20px;
        height: 20px;
        background: white;
        border-radius: 50%;
        transition: all 400ms ease-in-out;
        cursor: pointer;
    }

    .switch-toggle-btn.active,
    .post-paid-btn.active {
        background: green;
    }

    .switch-toggle-btn.active>.circle,
    .post-paid-btn.active>.circle {
        margin-left: 30px;
    }
    </style>

    <title><?php echo $title; ?> | <?php include('title.php'); ?> </title>
    <?php include('links.php'); ?>
</head>

<body onload="startTime()" class="nav-md">
    <div class="container body">
        <div class="main_container">

            <!-- Sidebar -->
            <?php include('sidebar.php'); ?>
            <!-- /Sidebar -->


            <!-- top navigation -->
            <?php include('topbar.php'); ?>
            <!-- /top navigation -->

            <!-- page content -->
            <?php
            require_once $content;
            ?>
            <!-- /page content -->

            <!-- footer content -->
            <?php include('footer.php'); ?>
            <!-- /footer content -->

            <?php include('script.php'); ?>
            <?php include('template_end.php'); ?>