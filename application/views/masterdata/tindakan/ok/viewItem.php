<table class="table" id="datatable">
    <thead>
        <tr>
            <th style="width:4%;">No</th>
            <th>Jenis</th>
            <th>Kelas</th>
            <th>Nama Tarif</th>
            <th>Total Tarif</th>
            <th style="width:5%;"></th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    $("#datatable").DataTable({
        ordering: false,
        processing: false,
        serverSide: true,
        ajax: {
           	url: "<?php echo base_url('tindakan/datatableOK'); ?>",
           	type:'POST'
        }
    });
</script>