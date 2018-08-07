<fieldset>
	<form method="post" action="<?php echo base_url()?>besuk/crud" name="formdatabesuk<?php echo $recno ?>" id="formdatabesuk<?php echo $recno ?>" enctype="multipart/form-data">
		<input type="hidden" name="oper" value="edit">
		<?php $this->load->view("besuk/form") ?>		
	</form>
</fieldset>