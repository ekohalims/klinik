<table class="table" id="datatable">
    <thead>
        <tr>
            <th style="width:3%;">No</th>
            <th>Nama Tarif</th>
            <th>Kategori</th>
            <th>Nilai</th>
            <th>Nilai Min - Max</th>
            <th>Nilai Normal</th>
            <th>Satuan</th>
            <th>Keterangan</th>
            <th>Tarif</th>
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
           	url: "<?php echo base_url('tindakan/datatableTarifLabSatuan'); ?>",
           	type:'POST'
        }
    });
</script>