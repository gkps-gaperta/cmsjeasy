<?php 
    foreach ($sql->result() as $row) {
        ?>      
            <table>
                <tr>
                    <th>memberno</th>
                    <td>: <?php echo $row->memberno ?></td>
                </tr>
                <tr>
                    <th>membername</th>
                    <td>: <?php echo $row->membername ?></td>
                </tr>
                <tr>
                    <th>chinesename</th>
                    <td>: <?php echo $row->chinesename ?></td>
                </tr>
                <tr>
                    <th>handphone</th>
                    <td>: <?php echo $row->handphone ?></td>
                </tr>
                <tr>
                    <th>address</th>
                    <td>: <?php echo $row->address ?></td>
                </tr>
                <tr>
                    <th>city</th>
                    <td>: <?php echo $row->city ?></td>
                </tr>
            </table>
        <?php
    }
?>
