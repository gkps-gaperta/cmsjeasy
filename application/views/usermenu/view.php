<script type="text/javascript">
	$(document).ready(function(){
	    $('input[type=text]').keyup(function() {
	        $(this).val($(this).val().toUpperCase());
	    });

	    $('input[type=email]').keyup(function() {
	        $(this).val($(this).val().toLowerCase());
	    });
	});
</script>
<hr>
<?php
	@$query=("SELECT * , DATE_FORMAT(modifiedon,'%d-%m-%Y %T') modifiedon FROM tblusermenu WHERE usermenuid=".$usermenuid." LIMIT 0,1");
	@$row=queryCustom2($query);
?>
<input type="hidden" name="usermenuid" value="<?php echo @$usermenuid ?>">
<input type="hidden" name="userpk" value="<?php echo @$userpk ?>">
<table class="table table-condensed" cellpadding="0" cellspacing="0">
	<tr>
		<td>pstatusid</td>
		<td>: 
			<select id="menuid" name="menuid">
                <option value=""></option>
                <?php
                    foreach ($sqlusermenu->result() as $rowform) {
                        ?>
                        	<option <?php if($row['menuid']==$rowform->menuid){echo "selected";} ?> value="<?php echo $rowform->menuid ?>" readonly><?php echo $rowform->menuname ?></option>
                        <?php
                    }
                ?>
            </select><span id="tip"></span>
        </td>
	</tr>
	<tr>
		<td>acl</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$row['acl'] ?>" name="acl" id="acl" readonly><span id="tip2"></span></td>
	</tr>
</table>