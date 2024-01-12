<table class="table" id="datatable">
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th>Kode Item</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Satuan</th>
            <th>Stok Minimal</th>
            <th>Stok</th>
            <th>Harga Pokok</th>
            <th>Harga Jual</th>
            <th style="width:4%;"></th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    $("#datatable").DataTable({
        ordering: false,
        processing: false,
        serverSide: true,
        ajax: {
           	url: "<?php echo base_url('item/datatable'); ?>",
           	type:'POST'
        }
    });
</script>