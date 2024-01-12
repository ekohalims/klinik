<table class="table table-striped" id="datatable">
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th>No Stock Opname</th>
            <th>Tanggal</th>
            <th>PIC</th>
            <th>Keterangan</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    var tahun = "<?php echo $tahun; ?>";

    $("#datatable").DataTable({
        ordering: false,
        processing: false,
        serverSide: true,
        ajax: {
           	url: "<?php echo base_url('laporan/datatableLaporanSO'); ?>",
           	type:'POST',
            data : {tahun : tahun}
        }
    });
</script>