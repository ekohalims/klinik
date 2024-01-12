<table class="table" id="datatables">
    <thead>
        <tr style="font-weight: bold;">
            <th width="1%">No</th>
            <th width="10%">Poliklinik</th>
            <th width="15%">Keterangan</th>   
            <th width="2%" style="text-align: center;">Status</th> 
            <th width="1%"></th>  
        </tr>
    </thead>

    <tbody>
        <?php
            $i = 1;
            foreach($daftarPoli as $row){
        ?>
            <tr>
                <td style="text-align: center;"><?php echo $i; ?></td>
                <td><?php echo $row->poliklinik; ?></td>
                <td><?php echo $row->keterangan; ?></td>
                <td style="text-align: center;">
                    <?php
                        if($row->status==1){
                            echo "<span class='label label-success'>Aktif</span>";
                        } else {
                            echo "<span class='label label-danger'>Non-Aktif</span>";
                        }
                    ?>
                </td>
                <td style="text-align: center;">
                    <a class="editPoli" id="<?php echo $row->id_poliklinik; ?>"><i class="fa fa-pencil"></i></a> | <a class="hapusPoli" id="<?php echo $row->id_poliklinik; ?>"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        <?php $i++; } ?>
    </tbody>
</table>
<script type="text/javascript">
    $('#datatables').dataTable();
</script>

