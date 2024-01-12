<table class="table">
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th>POS</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <?php
            $numRows = $pos->num_rows();
            if($numRows > 0){
                $i = 1;
                foreach($pos->result() as $row){
        ?>  
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row->pos; ?></td>
            <td style="text-align:right;">
                <a href="#myModal" data-toggle="modal" class='editPOS' id="<?php echo $row->idPos; ?>"><i class="fa fa-pencil"></i></a> 
                <a class='hapusPOS' id="<?php echo $row->idPos; ?>"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        <?php $i++; } } else {?>
        <tr>
            <td colspan="3" style="text-align:center;">--Belum ada data--</td>
        </tr>
        <?php } ?>
    </tbody>
</table>