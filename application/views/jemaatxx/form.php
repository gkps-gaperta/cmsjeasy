<script type="text/javascript">
function readurl(input) {
    var x = $("#photofile").val();
    var ext = x.split('.').pop();
    switch(ext){
        case 'jpg':
        case 'JPG':
	        var reader = new FileReader();
	        reader.onload = function (e){
	            $('#blah')
	            .attr('src', e.target.result)
	            .width(200);
	        };
	        reader.readAsDataURL(input.files[0]);
	        $("#extphotofile").val(ext);
        break;
        default:
	        $("#extphotofile").val("");
            alert('extensi harus jpg');
            this.value='';
    }
}

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

    $('input[type=email]').focusout(function() {
        $(this).val($(this).val().toLowerCase());
    });

    $('textarea').focusout(function() {
        $(this).val($(this).val().toUpperCase());
    });

});
</script>
<?php
	@$query=mysql_query("SELECT *, DATE_FORMAT(dob,'%d-%m-%Y') dob, 
		DATE_FORMAT(tglbesuk,'%d-%m-%Y') tglbesuk,
		DATE_FORMAT(baptismdate,'%d-%m-%Y') baptismdate,
		DATE_FORMAT(modifiedon,'%d-%m-%Y %T') modifiedon FROM tblmember WHERE recno=".$recno." LIMIT 0,1");
	@$row=mysql_fetch_array($query);
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
<input type="hidden" name="recno" value="<?php echo @$row['recno'] ?>">
<table class="table table-condensed" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>grp_pi</td>
		<td>: <input type="checkbox" class="inputmedium" <?php if(@$row['grp_pi']==1 OR @$grp_pi=="pi"){echo "checked";} ?> value="1" name="grp_pi" id="grp_pi"></td>
	</tr>
	<tr>
		<td>relationno</td>
		<td width="250">: <input type="text" class="inputmedium" value="<?php echo $row['relationno'] ?>" name="relationno" id="relationno"></td>
		<td rowspan="37" valign="top" align="center">
			<?php
				if($row['photofile']!=""){
					$url = "medium_".$row['photofile'];
				}
				else{
					$url = "medium_nofoto.jpg";
				}
			?>
			<img width="200" class="mediumpic" id="blah" src="<?php echo base_url();?>uploads/<?php echo $url ?>">
			<br>
			<div class="upload">Ganti Foto
				<input id="photofile" type="file" name="photofile" onchange="readurl(this);"/>
			</div>
			<a href="<?php echo base_url()?>jemaat/download/<?php echo $url ?>" title="Download Foto">
				<img src='<?php echo base_url(); ?>libraries/icon/24x24/download.jpg'>
			</a>
			<input type="hidden" name="editphotofile" id="editphotofile" value="<?php echo $row['photofile'] ?>">
			<input type="hidden" name="extphotofile" id="extphotofile">
			<div id="loading"></div>
        </td>
	</tr>
	<tr>
		<td>memberno</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$row['memberno'] ?>" name="memberno" id="memberno"></td>
	</tr>
	<tr>
		<td>membername</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$row['membername'] ?>" name="membername" id="membername"><span id="tip"></span></td>
	</tr>
	<tr>
		<td>chinesename</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$row['chinesename'] ?>" name="chinesename" id="chinesename"></td>
	</tr>
	<tr>
		<td>phoneticname</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$row['phoneticname'] ?>" name="phoneticname" id="phoneticname"></td>
	</tr>
	<tr>
		<td>aliasname</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$row['aliasname'] ?>" name="aliasname" id="aliasname"></td>
	</tr>
	<tr>
		<td>tel_h</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$row['tel_h'] ?>" name="tel_h" id="tel_h"></td>
	</tr>
	<tr>
		<td>tel_o</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$row['tel_o'] ?>" name="tel_o" id="tel_o"></td>
	</tr>
	<tr>
		<td>handphone</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$row['handphone'] ?>" name="handphone" id="handphone"></td>
	</tr>
	<tr>
		<td>address</td>
		<td>: 
			<textarea name="address" id="address"><?php echo @$row['address'] ?></textarea>
		</td>
	</tr>
	<tr>
		<td>add2</td>
		<td>: 
			<textarea name="add2" id="add2"><?php echo @$row['add2'] ?></textarea>
		</td>
	</tr>
	<tr>
		<td>city</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$row['city'] ?>" name="city" id="city"></td>
	</tr>
	<tr>
		<td>genderid</td>
		<td>: 
			<select id="genderid" name="genderid">
                <option value=""></option>
                <?php
                    foreach ($sqlgender->result() as $rowform) {
                        ?>
                        	<option <?php if($row['genderid']==$rowform->genderid){echo "selected";} ?> value="<?php echo $rowform->genderid ?>"><?php echo $rowform->genderid ?></option>
                        <?php
                    }
                ?>
            </select>
		</td>
	</tr>
	<tr>
		<td>pstatusid</td>
		<td>: 
			<select id="pstatusid" name="pstatusid">
                <option value=""></option>
                <?php
                    foreach ($sqlpstatus->result() as $rowform) {
                        ?>
                        	<option <?php if($row['pstatusid']==$rowform->pstatusid){echo "selected";} ?> value="<?php echo $rowform->pstatusid ?>"><?php echo $rowform->pstatusid ?></option>
                        <?php
                    }
                ?>
            </select>
        </td>
	</tr>
	<tr>
		<td>pob</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$row['pob'] ?>" name="pob" id="pob"></td>
	</tr>
	<tr>
		<td>dob</td>
		<td>: 
			<script type="text/javascript">
				$(document).ready(function(){
					$("#dob").datepicker({dateFormat: 'dd-mm-yy'});
				});
			</script>
			<input type="text" class="inputmedium" value="<?php echo @$row['dob'] ?>" name="dob" id="dob">
        </td>
	</tr>
	<tr>
		<td>bloodid</td>
		<td>: 
			<select id="bloodid" name="bloodid">
                <option value=""></option>
                <?php
                    foreach ($sqlblood->result() as $rowform) {
                    	?>
                        	<option <?php if($row['bloodid']==$rowform->bloodid){echo "selected";} ?> value="<?php echo $rowform->bloodid ?>"><?php echo $rowform->bloodid ?></option>
                        <?php
                    }
                ?>
            </select>
        </td>
	</tr>
	<tr>
		<td>kebaktianid</td>
		<td>: 
			<select id="kebaktianid" name="kebaktianid">
                <option value=""></option>
                <?php
                    foreach ($sqlkebaktian->result() as $rowform) {
                    	?>
                        	<option <?php if($row['kebaktianid']==$rowform->kebaktianid){echo "selected";} ?> value="<?php echo $rowform->kebaktianid ?>"><?php echo $rowform->kebaktianid ?></option>
                        <?php
                    }
                ?>
            </select>
        </td>
	</tr>
	<tr>
		<td>persekutuanid</td>
		<td>: 
			<select id="persekutuanid" name="persekutuanid">
                <option value=""></option>
                <?php
                    foreach ($sqlpersekutuan->result() as $rowform) {
                    	?>
                        	<option <?php if($row['persekutuanid']==$rowform->persekutuanid){echo "selected";} ?> value="<?php echo $rowform->persekutuanid ?>"><?php echo $rowform->persekutuanid ?></option>
                        <?php
                    }
                ?>
            </select>
        </td>
	</tr>
	<tr>
		<td>rayonid</td>
		<td>: 
			<select id="rayonid" name="rayonid">
                <option value=""></option>
                <?php
                    foreach ($sqlrayon->result() as $rowform) {
                    	?>
                        	<option <?php if($row['rayonid']==$rowform->rayonid){echo "selected";} ?> value="<?php echo $rowform->rayonid ?>"><?php echo $rowform->rayonid ?></option>
                        <?php
                    }
                ?>
            </select>
        </td>
	</tr>
	<tr>
		<td>statusid</td>
		<td>: 
			<select id="statusid" name="statusid">
                <option value=""></option>
                <?php
                    foreach ($sqlstatusid->result() as $rowform) {
                    	?>
                        	<option <?php if($row['statusid']==$rowform->parameterid){echo "selected";} ?> value="<?php echo $rowform->parameterid ?>"><?php echo $rowform->parametertext ?></option>
                        <?php
                    }
                ?>
            </select>
        </td>
	</tr>
	<tr>
		<td>serving</td>
		<td>: 
            <link href="<?php echo base_url()?>libraries/select2-3.4.6/select2.css" rel="stylesheet"/>
		    <script src="<?php echo base_url()?>libraries/select2-3.4.6/select2.js"></script>
            <script>
            	$(document).ready(function() {
					$("#servingid").select2({
				    	placeholder: "Select a State"
					});
			    });
			</script>
			<select id="servingid" name="servingid[]" multiple="multiple" style="width:204px; font-size:10px;">
				<option value=""></option>
                <?php
                    foreach ($sqlserving->result() as $rowform) {
                    	$serving = $row['serving'];
		               	$findme = $rowform->servingid;
		                $pos = strpos($serving, $findme);
                    	?>
                        	<option <?php if($pos!==false){echo"selected";} ?>  value="<?php echo $rowform->servingid ?>"><span style="color:rgb(255,0,0);"><?php echo $rowform->servingid ?></span></option>
                        <?php
                    }
                ?>
			</select>
        </td>
	</tr>
	<tr>
		<td>fax</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$row['fax'] ?>" name="fax" id="fax"></td>
	</tr>
	<tr>
		<td>email</td>
		<td>: <input type="email" class="inputmedium" value="<?php echo @$row['email'] ?>" name="email" id="email"></td>
	</tr>
	<tr>
		<td>website</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$row['website'] ?>" name="website" id="website"></td>
	</tr>
	<tr>
		<td>baptismdocno</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$row['baptismdocno'] ?>" name="baptismdocno" id="baptismdocno"></td>
	</tr>
	<tr>
		<td>baptis</td>
		<td>: <input type="checkbox" value="1" id="baptis" name="baptis" <?php if($row['baptis']==1){echo "checked";} ?>></td>
	</tr>
	<tr>
		<td>baptismdate</td>
		<td>: 
			<script type="text/javascript">
				$(document).ready(function(){
					$("#baptismdate").datepicker({dateFormat: 'dd-mm-yy'});  
				});
			</script>
			<input type="text" class="inputmedium" value="<?php echo @$row['baptismdate'] ?>" name="baptismdate" id="baptismdate">
		</td>
	</tr>
	<tr>
		<td>remark</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$row['remark'] ?>" name="remark" id="remark"></td>
	</tr>
	<tr>
		<td>relation</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$row['relation'] ?>" name="relation" id="relation"></td>
	</tr>
	<tr>
		<td>oldgrp</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$row['oldgrp'] ?>" name="oldgrp" id="oldgrp"></td>
	</tr>
	<tr>
		<td>kebaktian</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$row['kebaktian'] ?>" name="kebaktian" id="kebaktian"></td>
	</tr>
	<tr>
		<td>tglbesuk</td>
		<td>: 
			<script type="text/javascript">
				$(document).ready(function(){
					$("#tglbesuk").datepicker({dateFormat: 'dd-mm-yy'});  
				});
			</script>
			<input type="text" class="inputmedium" value="<?php echo @$row['tglbesuk'] ?>" name="tglbesuk" id="tglbesuk">
		</td>
	</tr>
	<tr>
		<td>teambesuk</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$row['teambesuk'] ?>" name="teambesuk" id="teambesuk"></td>
	</tr>
	<tr>
		<td>description</td>
		<td>: <input type="text" class="inputmedium" value="<?php echo @$row['description'] ?>" name="description" id="description"></td>
	</tr>
</table>