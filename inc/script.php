<!--Select2-->
<script src="../select2/js/select2.full.min.js"></script>
<script>
$(function() {
    //Initialize Select2 Elements
    $(".select2").select2();

})

// on click search results...
$(document).on("click", "#display-button", function() {
    var value = $("#search-data").val();
    if (value.length != 0) {
        searchData(value);
    } else {
        $('#search-result-container').hide();
    }
});

$(document).on("click", ".search-result", function() {
    var divIdVal = $(this).attr('id');
    getData(divIdVal);
});

$(document).ready(function() {
    $("#search-data").keyup(function() {
        var searchText = $('#search-data').val();
        if (searchText.length != 0) {
            searchData(searchText);
        } else {
            $('#search-result-container').hide();
        }
    });

    $('.switch-toggle-btn').click(function() {
        var getId = $(this).attr("id");
        $(this).toggleClass(".switch-toggle-btn active");
        setStatus(getId);
    });

    $('.post-paid-btn').click(function() {
        var getId = $(this).attr("id");
        $(this).toggleClass(".post-paid-btn active");
        setPostStatus(getId);
    });
});

function setStatus(id) {
    $.post('live_search_controller.php', {
        'id': parseInt(id)
    }, function(data) {}).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
        alert(thrownError); //alert with HTTP error
    });
}

function setPostStatus(id) {
    $.post('live_search_controller.php', {
        'post-id': parseInt(id)
    }, function(data) {}).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
        alert(thrownError); //alert with HTTP error
    });
}

function getData(val) {
    $('#search-result-container').show();
    $('#search-result-container').html('<div><span style="width:100%; text-align:center;">Please Wait...</span></div>');
    $.post('live_search_controller.php', {
        'get-data': val
    }, function(data) {
        if (data != "")
            $('#search-result-container').html(data);
        else
            $('#search-result-container').html("<div class='search-result'>No Result Found...</div>");
    }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?

        alert(thrownError); //alert with HTTP error

    });
}

// This function helps to send the request to retrieve data from mysql database...
function searchData(val) {
    $('#search-result-container').show();
    $('#search-result-container').html(
        '<div><span style="width:100%; font-size: 18px; text-align:center;">Please Wait...</span></div>');
    $.post('live_search_controller.php', {
        'search-data': val
    }, function(data) {
        if (data != "")
            $('#search-result-container').html(data);
        else
            $('#search-result-container').html("<div class='search-result'>No Result Found...</div>");
    }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?

        alert(thrownError); //alert with HTTP error

    });
}
</script>

<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- FastClick -->
<script src="../vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="../vendors/nprogress/nprogress.js"></script>
<!-- Chart.js -->
<script src="../vendors/Chart.js/dist/Chart.min.js"></script>
<!-- gauge.js -->
<script src="../vendors/gauge.js/dist/gauge.min.js"></script>
<!-- bootstrap-progressbar -->
<script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- iCheck -->
<script src="../vendors/iCheck/icheck.min.js"></script>
<!-- Skycons -->
<script src="../vendors/skycons/skycons.js"></script>
<!-- Flot -->
<script src="../vendors/Flot/jquery.flot.js"></script>
<script src="../vendors/Flot/jquery.flot.pie.js"></script>
<script src="../vendors/Flot/jquery.flot.time.js"></script>
<script src="../vendors/Flot/jquery.flot.stack.js"></script>
<script src="../vendors/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="../vendors/flot.curvedlines/curvedLines.js"></script>
<!-- DateJS -->
<script src="../vendors/DateJS/build/date.js"></script>
<!-- JQVMap -->
<script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
<script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
<!-- bootstrap-daterangepicker -->
<script src="../vendors/moment/min/moment.min.js"></script>
<script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- Datatables -->
<script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="../vendors/jszip/dist/jszip.min.js"></script>
<script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="../vendors/pdfmake/build/vfs_fonts.js"></script>
<script src="../vendors/button-loader/jquery.buttonLoader.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>