<br>
<table class="table" id="datatable">
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th>Ruang</th>
            <th>POS</th>
            <th>Kelas</th>
            <th>Kapasitas</th>
            <th>Jumlah Ruang</th>
            <th>Jumlah Bed</th>
            <th>Tarif</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <?php
            $i=1;
            foreach($ruang as $row){ 
        ?>
        <tr>
            <td style="vertical-align:middle;"><?php echo $i; ?></td>
            <td style="vertical-align:middle;"><?php echo $row->namaGroup; ?></td>
            <td style="vertical-align:middle;"><?php echo $row->pos; ?></td>
            <td style="vertical-align:middle;"><?php echo $row->kelasruang; ?></td>
            <td style="vertical-align:middle;"><?php echo $row->kapasitas; ?> Bed</td>
            <td style="vertical-align:middle;">
                <?php echo $row->jumlahRuang; ?>
            </td>
            <td style="vertical-align:middle;"><?php echo number_format($row->kapasitas*$row->jumlahRuang,'0',',','.'); ?></td>
            <td style="vertical-align:middle;"><?php echo number_format($row->tarif,'0',',','.'); ?></td>
            <td style="text-align:right;">
                <a href="#myModal" data-toggle="modal" class="editRanap btn btn-info btn-rounded btn-sm" id="<?php echo $row->kodeGroup; ?>"><i class="fa fa-pencil"></i></a>
                <a href="#modalDaftarRuang" data-toggle="modal" class="btn btn-primary btn-rounded btn-sm daftarRuangEdit" id="<?php echo $row->kodeGroup; ?>"><i class="fa fa-bed"></i></a>
                <a class="hapusRuangInap btn btn-danger btn-rounded btn-sm" id="<?php echo $row->kodeGroup; ?>"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        <?php $i++; } ?>
    <tbody>
</table>

<script type="text/javascript">
    $('#datatable').DataTable();
</script>