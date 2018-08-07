<script type="text/javascript">

$(document).ready(function(){
	$('input[type=text]').focusout(function() {
		$(this).val($(this).val().toUpperCase());
	});

/*
	$('input').focusout(function() {
		// Uppercase-ize contents
		this.value = this.value.toLocaleUpperCase();
	});
*/


    $('input[type=email]').keyup(function() {
        $(this).val($(this).val().toLowerCase());
    });

});
</script>
<?php
	@$sql="SELECT * FROM tblblood WHERE bloodid='".$bloodid."' LIMIT 0,1";
	@$data = queryCustom($sql);
?>

<style type="text/css">
	@font-face{
		font-family: COOPERM;
		src: url('libraries/font/COOPERM.TTF'),url('../../libraries/font/COOPERM.eot'); /* IE9 */
	}

	@font-face{
		font-family: CHISER__;
		src: url('libraries/font/CHISER__.TTF'),url('../../libraries/font/CHISER__.eot'); /* IE9 */
	}

	@font-face{
		font-family: segoeui;
		src: url('libraries/font/segoeui.ttf'),url('../../libraries/font/segoeui.eot'); /* IE9 */
	}
	table{
		font-family:segoeui;
		font-size: 12px;
	}

	input{
		font-family:segoeui;
		font-size: 8px;
	}

	#address{
		font-family:segoeui;
		font-size: 11px;
	}
</style>
<input type="hidden" name="bloodid" value="<?php echo @$data->bloodid ?>">
<table class="table table-condensed" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>bloodid</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$data->bloodid ?>" name="bloodid" id="bloodid"><span id="tip"></span></td>
	</tr>
	<tr>
		<td>bloodname</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$data->bloodname ?>" name="bloodname" id="bloodname"></td>
	</tr>
</table>