<body>
    <script type="text/javascript">
            function tampilkanjam(){
                var waktu = new Date();
                var jam = waktu.getHours();
                var menit = waktu.getMinutes();
                var detik = waktu.getSeconds();
                var teksjam = new String();
                if ( menit <= 9 )
                menit = "0" + menit;
                if ( detik <= 9 )
                detik = "0" + detik;
                teksjam = jam + ":" + menit + ":" + detik;
                tempatjam.innerHTML = teksjam;
                setTimeout ("tampilkanjam()",1000);
            }
            
            function start() {
                tampilkanjam();
            }

            window.onload = start;
        </script>

  	<p><h2>CMS | Church Membership System - GMI GLORIA</h2></p>
    <div style="margin:10px 0;"></div>
    <div style="padding:5px;background:#fafafa;border:10px solid #ccc">
        <?php
            $sub="";
            $plain = "";
            $n=0;
            foreach($sqlmenu as $data)
            {
                $n++;
                $x = print_recursive_list($data['child']);
                if($x!=""){
                    $class = "easyui-menubutton";
                }
                else{
                    $class = "easyui-linkbutton";
                }
                ?>
                    <a href="<?php echo base_url();?><?php echo $data['menuexe'] ?>" class="<?php echo $class; ?>" data-options="plain:true, menu:'#<?php echo $n?>'" iconCls="<?php echo $data['menuicon'] ?>"><?php echo $data['menuname'] ?>
                        <div id="<?php echo $n?>">
                            <!-- diganti -->
                            <?php echo $x; ?>
                        </div>
                    </a>
                <?php
            }
        ?>
        <div style="float:right; font-weight: bold;" id="easyui-menubutton">
                            <?php echo date("d M Y"); ?> / <span id="tempatjam"></span>
                        </div>
    </div>
    <br>