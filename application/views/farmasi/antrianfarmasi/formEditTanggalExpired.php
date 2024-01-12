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
        foreach($dataExpiredDate as $row){
    ?>
    <tr>
        <td style="vertical-align:middle;"><?php echo date_format(date_create($row->expiredDate),'d M Y'); ?></td>
        <td style="text-align:right;"><a class="btn btn-success btn-rounded pilihExpired" id="<?php echo $row->id_produk; ?>" data-tanggal="<?php echo $row->expiredDate; ?>" data-no_pendaftaran="<?php echo $noPendaftaran; ?>"><i class="fa fa-check-square-o"></i> Pilih</a></td>
    </tr>
    <?php } ?>
</table>

<script type="text/javascript">
    $('.pilihExpired').on("click",function(){
        var idProduk = this.id;
        var tanggal = $(this).data('tanggal');
        var noPendaftaran = $(this).data('no_pendaftaran');
        var url = "<?php echo base_url('antrianFarmasi/ubahExpiredDate'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {idProduk : idProduk, tanggal : tanggal, noPendaftaran : noPendaftaran},
            success : function(){
                tampilkanDataOrder();
                $.Notification.autoHideNotify('success', 'top right', 'Berhasil!','Tanggal expired telah berubah');
                $('#smallModal').modal('hide');
            }
        });
    });
</script>