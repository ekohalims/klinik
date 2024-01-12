<table class="table" id="datatable">
    <thead>
        <tr>
            <th width="4%">No</th>
            <th>No Pendaftaran</th>
            <th>No Pasien</th>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Tanggal Lahir</th>
            <th>Dokter</th>
            <th>Poliklinik</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    var status = "<?php echo $status; ?>";

    $("#datatable").DataTable({
        ordering: false,
        processing: false,
        serverSide: true,
        ajax: {
           	url: "<?php echo base_url('orderRadiologi/datatableOrderServerSide'); ?>",
               type:'POST',
               data : {status : status}
        }
    });
</script>