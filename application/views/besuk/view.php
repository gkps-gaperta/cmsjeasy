<?php
	$this->load->view('besuk/jemaat');
?>
<hr>
<?php
	@$query=("SELECT *, DATE_FORMAT(besukdate,'%d-%m-%Y') besukdate,
		DATE_FORMAT(modifiedon,'%d-%m-%Y %T') modifiedon FROM tblbesuk WHERE besukid=".$besukid." LIMIT 0,1");
	@$row=queryCustom2($query);
?>
<input type="hidden" name="besukid" value="<?php echo @$row['besukid'] ?>">
<table class="table table-condensed" cellpadding="0" cellspacing="0">
	<tr>
		<td>recno</td>
		<td>: <?php echo @$row['recno'] ?></td>
	</tr>
	<tr>
		<td>besukdate</td>
		<td>: <?php echo @$row['besukdate'] ?></td>
	</tr>
	<tr>
		<td>pembesuk</td>
		<td>: <?php echo @$row['pembesuk'] ?></td>
	</tr>
	<tr>
		<td>pembesukdari</td>
		<td>: <?php echo @$row['pembesukdari'] ?></td>
	</tr>
	<tr>
		<td>remark</td>
		<td>: <?php echo @$row['remark'] ?></td>
	</tr>
	<tr>
		<td>besuklanjutan</td>
		<td>: <?php echo @$row['besuklanjutan'] ?></td>
	</tr>
</table>