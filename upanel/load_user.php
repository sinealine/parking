<script type="text/javascript">
    var user = $("#user").val();
    $("#date_from").change(function () {
		$(this).after('<div id="loader"><img src="img/ajax_loader.gif" alt="loading...." width="30" height="30" /></div>');           
        $.get('load_date_to.php?user=' + user + '&date_from=' + $(this).val() , function (data) {
            // replace dates
            var galimg = $('#display_to');
            var nodes = galimg.parent().contents();
            var idx = nodes.index( galimg );
            
            nodes.slice( idx + 1 ).remove();
            
            // replace table
            var galimg = $('.display_report');
            var nodes = galimg.parent().contents();
            var idx = nodes.index( galimg );
            
            nodes.slice( idx + 1 ).remove();
            
         $("#display_to").after(data);
            $('#loader').slideUp(910, function () {
                $(this).remove();
            });
        });
    });
</script>

<?php
    $user = $_REQUEST['P_OP'];
?>
<div class="col-md-4" id="display_to">
    <input type="date" name="date_from" id="date_from" class="form-control"/>
</div>

<input type="hidden" name="user" value="<?php echo $user; ?>" id="user" class="form-control"/>