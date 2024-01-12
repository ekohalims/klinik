<table class="table" id="datatable">
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th>Asuransi</th>
            <th>Tempo</th>
            <th>Keterangan</th>
            <th style="width:10%;">Status</th>
            <th style="width:5%;"></th>
        </tr>
    </thead>

    <tbody>
        <?php
            $i = 1;
            foreach($viewAsuransiAktif as $row){
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row->namaAsuransi; ?></td>
            <td><?php echo $row->tempo; ?> Hari</td>
            <td><?php echo $row->keterangan; ?></td>
            <td>
                <?php
                    if($row->status==1){
                        echo "<span class='label label-success'>Aktif</span>";
                    } else {
                        echo "<span class='label label-danger'>Non-Aktif</span>";
                    }
                ?>
            </td>
            <td style="text-align:right;"><a href="#myModal" data-toggle="modal" class="editAsuransi" id="<?php echo $row->idAsuransi; ?>"><i class="fa fa-pencil"></i> </a>| <a class="hapusAsuransi" id="<?php echo $row->idAsuransi; ?>"><i class="fa fa-trash"></i></a></a></td>
        </tr>
        <?php $i++; } ?>
    </tbody>
</table>

<script type="text/javascript">
    $('#datatable').dataTable();
</script>
