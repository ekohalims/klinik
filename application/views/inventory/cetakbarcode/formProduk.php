<table class="table" id="produkDatatables">
    <thead>
        <tr style="font-weight: bold;">
            <th width="5%">No</th>
            <th>SKU</th>
            <th>Nama Produk</th>
            <th style="width:5%;">Qty</th>
            <th style="width:5%;"></th>
        </tr>
    </thead>
</table>

<script type='text/javascript'>
    $("#produkDatatables").DataTable({
        ordering: false,
        processing: false,
        serverSide: true,
        ajax: {
           	url: "<?php echo base_url('cetakBarcode/datatablesProduk'); ?>",
           	type:'POST'
        }
    });
</script>