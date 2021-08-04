<script type="text/javascript">

    var user = $("#user").val();
    var date_from = $("#date_from").val();
    $("#date_to").change(function () {
		$(this).after('<div id="loader"><img src="img/ajax_loader.gif" alt="loading...." width="30" height="30" /></div>');           
        $.get('load_rpt.php?date_to=' + $(this).val() + '&date_from=' + date_from + '&user=' + user, function (data) {
            // replace table
            var galimg = $('.display_report');
            var nodes = galimg.parent().contents();
            var idx = nodes.index( galimg );
                
            nodes.slice( idx + 1 ).remove();
         $(".display_report").after(data);
            $('#loader').slideUp(910, function () {
                $(this).remove();
            });
        });
    });
</script>

<?php
    $date_from = $_REQUEST['date_from'];
    $user = $_REQUEST['user'];
?>
<div class="col-md-4">
     <input type="date" name="date_to" id="date_to" class="form-control"/>
 </div>

 <input type="hidden" name="date_from" id="date_from" value="<?php echo $date_from; ?>" hidden class="form-control"/>
 <input type="hidden" name="user" id="user" value="<?php echo $user; ?>" hidden class="form-control"/>