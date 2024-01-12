<table class="table" id="datatable">
    <thead>
        <tr>
            <th width="2%">No</th>
            <th>No Register</th>
            <th>Medrec</th>
            <th>Tanggal Daftar</th>
            <th>Nama</th>
            <th>Tgl Lahir</th>
            <th>Dokter</th>
            <th>Penanggung</th>
            <th>POS</th>
            <th>Nama Ruang</th>
            <th>Kelas</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    var idPos = "<?php echo $idPos; ?>";

    $("#datatable").DataTable({
        ordering: false,
        processing: false,
        serverSide: true,
        ajax: {
           	url: "<?php echo base_url('inputTindakanRanap/datatable'); ?>",
           	type:'POST',
            data : {idPos : idPos}
        }
    });
</script>