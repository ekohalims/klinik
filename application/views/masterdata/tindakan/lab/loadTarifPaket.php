<table class="table"id="datatable">
    <thead>
        <tr>
            <th style="width:3%;">No</th>
            <th>Nama Tarif</th>
            <th>Kategori</th>
            <th>Keterangan</th>
            <th>Total Tarif</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    $("#datatable").DataTable({
        ordering: false,
        processing: false,
        serverSide: true,
        ajax: {
           	url: "<?php echo base_url('tindakan/datatableTarifLabPaket'); ?>",
           	type:'POST'
        }
    });
</script>