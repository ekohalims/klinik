<table class="table" id="datatableStok">
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th style="width:15%;">Kode Item</th>
            <th>Nama Item</th>
            <th>Tanggal Expired</th>
            <th>Harga Average</th>
            <th>Stok</th>
            <th style="width:10%;">Satuan</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    var param = "<?php echo $param; ?>";

    $("#datatableStok").DataTable({
        ordering: false,
        processing: false,
        serverSide: true,
        ajax: {
           	url: "<?php echo base_url('dataStokExpired/datatablesExpiredItem'); ?>",
           	type:'POST', 
            data : {param : param}
        }
    });
</script>