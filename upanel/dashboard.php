<?php
if ($_SESSION['function'] == 1) {
?>

<div class="right_col" role="main">
    <!-- top tiles -->
    <div class="row" style="display: inline-block;width:100%;">
        <div class="tile_count">
            <div class="demo-container" style="height:280px">
                <div id="chart_plot_02" class="demo-placeholder"></div>
            </div>
        </div>
    </div>
    <!-- /top tiles -->
</div>

<?php
} else if ($_SESSION['function'] == 2) {

  include('reports.php');
?>
<div class="right_col" role="main">
    <!-- top tiles -->
    <div class="row" style="display: inline-block;width:100%;">
        <div class="tile_count">
            <a href="?page=entrances&date_from=<?php echo substr($_SESSION['from'], 0, 19); ?>&date_to=<?php echo substr($_SESSION['to'], 0, 19); ?>"
                style="text-decoration:none;">
                <div class="col-md-4 col-sm-4  tile_stats_count">
                    <span class="count_top"><i class="fa fa-arrow-circle-down"></i> Today Entered</span>
                    <div class="count"><small><?php echo number_format($total_entered['total_entered']); ?></small>
                    </div>
                </div>
            </a>
            <a href="?page=exit&date_from=<?php echo substr($_SESSION['from'], 0, 19); ?>&date_to=<?php echo substr($_SESSION['to'], 0, 19); ?>"
                style="text-decoration:none;">
                <div class="col-md-4 col-sm-4  tile_stats_count">
                    <span class="count_top"><i class="fa fa-arrow-circle-up"></i> Today Exited</span>
                    <div class="count"><small><?php echo number_format($total_exit['total_exit']); ?></small></div>
                </div>
            </a>
            <a href="?page=left&date_from=<?php echo substr($_SESSION['from'], 0, 19); ?>&date_to=<?php echo substr($_SESSION['to'], 0, 19); ?>"
                style="text-decoration:none;">
                <div class="col-md-4 col-sm-4  tile_stats_count">
                    <span class="count_top"><i class="fa fa-car"></i> Today Left</span>
                    <div class="count green"><small><?php echo number_format($total_left['total_left']); ?></small>
                    </div>
                </div>
            </a>
            <a href="?page=todaycash&date_from=<?php echo substr($_SESSION['from'], 0, 19); ?>&date_to=<?php echo substr($_SESSION['to'], 0, 19); ?>"
                style="text-decoration:none;">
                <div class="col-md-4 col-sm-4  tile_stats_count">
                    <span class="count_top"><i class="fa fa-money"></i> Today Money Collected</span>
                    <div class="count"><small><?php echo number_format($today_cash['today_cash']) . ".00"; ?></small>
                    </div>
                </div>
            </a>
            <!-- <div class="col-md-4 col-sm-4  tile_stats_count">
              <span class="count_top"><i class="fa fa-check-circle-o"></i> Valid Post</span>
              <div class="count"><small>0</small></div>
            </div> -->
            <a href="?page=allcash&date_from=<?php echo substr($_SESSION['from'], 0, 19); ?>&date_to=<?php echo substr($_SESSION['to'], 0, 19); ?>"
                style="text-decoration:none;">
                <div class="col-md-4 col-sm-4  tile_stats_count">
                    <span class="count_top"><i class="fa fa-money"></i> All Money</span>
                    <div class="count"><small><?php echo number_format($all_cash['all_cash']) . ".00"; ?></small></div>
                </div>
            </a>
        </div>
    </div>
    <!-- /top tiles -->
</div>

<?php
}
?>
<?php
//  echo'<meta http-equiv="refresh"'.'content="15;URL=?page=home">';
?>