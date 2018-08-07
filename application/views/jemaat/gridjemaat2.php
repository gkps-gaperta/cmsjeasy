<script type="text/javascript">
    var acl = "<?php echo $acl; ?>";
     $(function(){
        var dg = $("#dgJemaat").datagrid(
            {
                remoteFilter:true,
                pagination:true,
                rownumbers:true,
                fitColumns:true,
                singleSelect:true,
                remoteSort:true,
                clientPaging: false,
                url:"<?= base_url() ?>jemaat/grid3",
                method:'get',
                onClickRow:function(index,row){
                    var relationno = row.relationno;
                    relasi(relationno);
                    // console.log(relationno);
                 }
            });
        dg.datagrid('enableFilter', [{
            field:'recno',
            type:'label'
        }]);  
    });
    function relasi(relationno){
        page="<?php echo base_url()?>relasi/index2/?relationno="+relationno;
        $('#datarelasi').html('<img src="<?php echo base_url()?>libraries/img/loading.gif">').load(page);
    }
</script>
<div class="easyui-tabs" style="height:auto">
    <div title="Data Jemaat" style="padding:10px">
         <table id="dgJemaat" title="Jemaat" class="easyui-datagrid" style="width:100%;height:250px"
               >
            <thead>
                <tr>
                    <?php foreach($listTable as $t){
                     ?>
                    <th field="<?= $t ?>" width="10%" sortable="true"><?= $t ?></th>
                    <?php } ?>
                </tr>
            </thead>
        </table>
        <br>
        <div id="datarelasi"></div>
    </div>
</div>