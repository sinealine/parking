    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3><small>Manage User Access</small></h3>
                </div>
                <?php include '../inc/search.php'; ?>
            </div>

            <div class="clearfix"></div>
            <div class="row">

                <div class="col-md-12 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" id="search-data" class="form-control" placeholder="license plate or tel ...">
                        <span class="input-group-btn">
                            <button class="btn btn-secondary" id="display-button" type="button">Search</button>
                        </span>
                    </div>
                </div>
                <div id="search-result-container" style="display:none; width: 100%; min-height:100%;">

                </div>
            </div>
        </div>
        <!-- /page content -->