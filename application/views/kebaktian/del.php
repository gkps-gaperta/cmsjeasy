<fieldset>
	<form method="post" action="<?php echo base_url()?>kebaktian/crud" name="form1" id="form1" enctype="multipart/form-data">
		<input type="hidden" name="oper" value="del">
		<?php $this->load->view("kebaktian/view") ?>		
	</form>
</fieldset>