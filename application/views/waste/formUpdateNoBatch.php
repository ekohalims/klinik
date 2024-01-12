<table style="width:100%;">
    <tr>
        <td style="width:35%;">Kode Item</td>
        <td width="3%">:</td>
        <td><?php echo $dataItem->id_produk; ?></td>
    </tr>

    <tr>
        <td>Nama Item</td>
        <td>:</td>
        <td><?php echo $dataItem->nama_produk; ?></td>
    </tr>
</table>

<br>

<table class="table">
    <?php
        foreach($batch as $row){
    ?>
    <tr>
        <td><?php echo $row->noBatch; ?></td>
        <td style="text-align:right;"> 
            <a class="btn btn-success btn-rounded btn-sm pilihBatch" id="<?php echo $row->noBatch; ?>" data-id_produk="<?php echo $row->id_produk; ?>"><i class="fa fa-check-square-o"></i> Pilih</a>
        </td>
    </tr>
    <?php } ?>
</table>

<script type="text/javascript">
    $('.pilihBatch').on("click",function(){
        var noBatch = this.id;
        var idProduk = $(this).data('id_produk');
        var url = "<?php echo base_url('waste/updateBatchCartSQL'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {
                noBatch : noBatch,
                idProduk : idProduk
            },
            success : function(){
                $('#smallModal').modal('hide');
                var dataUrl = "<?php echo base_url('waste/viewCartWaste'); ?>";
                $('#data-input').load(dataUrl);
            }
        });
    });
</script>