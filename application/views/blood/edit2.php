<?php
	@$sql="SELECT * FROM tblblood WHERE bloodid='".$bloodid."' LIMIT 0,1";
	@$data = queryCustom($sql);
?>
<form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
    <h3>Blood Informasi</h3>
    <input type="hidden" name="oper" id="oper" value="edit">
    <div style="margin-bottom:10px">
        <input name="bloodid" class="easyui-textbox" readonly="" required="true" value="<?= @$data->bloodid ?>" label="Blood Id:" style="width:100%">
    </div>
    <div style="margin-bottom:10px">
        <input name="bloodname" class="easyui-textbox" required="true"  value="<?= @$data->bloodname ?>"  label="Blood Name:" style="width:100%">
    </div>
</form>