<script type="text/javascript">
     $(function(){
        var dgRelasi = $("#dgRelasi").datagrid(
            {
                remoteFilter:true,
                pagination:true,
                rownumbers:true,
                fitColumns:true,
                singleSelect:true,
                remoteSort:true,
                clientPaging: false,
                url:"<?= base_url() ?>relasi/grid2/<?= $relationno ?>",
                method:'get'
            });
        dgRelasi.datagrid('enableFilter', [{
            field:'recno',
            type:'label'
        }]);  
    });
</script>
<table id="dgRelasi" title="Relasi" class="easyui-datagrid" style="width:100%;height:250px"
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