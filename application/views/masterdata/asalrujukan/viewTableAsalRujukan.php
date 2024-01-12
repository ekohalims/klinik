<table class="table" id="datatable">
    <thead>
        <tr>
            <th style="width:5%">No</th>
            <th>Asal Rujukan</th>
            <th>Jenis Rujukan</th>
            <th>Keterangan</th>
            <th style="width:5%"></th>
        </tr>
    </thead>

    <tbody>
        <?php 
            $i = 1;
            foreach($tampilkanData as $row){
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row->asalRujukan; ?></td>
            <td><?php echo $row->jenisRujukan; ?></td>
            <td><?php echo $row->keterangan; ?></td>
            <td style="text-align:right;"><a href="#myModal" data-toggle="modal" class='edit' id="<?php echo $row->id; ?>"><i class="fa fa-pencil"></i></a> <a class='hapus' id="<?php echo $row->id; ?>"><i class="fa fa-trash"></i></a></td>
        </tr>
        <?php $i++; } ?>
    </tbody>
</table>

<script type="text/javascript">
    $('#datatable').dataTable();
</script>