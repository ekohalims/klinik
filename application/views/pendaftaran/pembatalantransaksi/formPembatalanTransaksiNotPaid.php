Apakah anda yakin akan membatalkan transaksi ? 

<div class="row">
    <div class="col-md-12" style="text-align:right;">
        <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger btn-rounded" id="batalkan">Batalkan</button>
    </div>
</div>

<script type="text/javascript">
    $('#batalkan').on("click",function(){
        var urlBatal = "<?php echo base_url('pembatalanTransaksi/batalkanTransaksi'); ?>";
        var akun = '';

        $.ajax({
            method : "POST",
            url : urlBatal,
            data : {akun : akun, noPendaftaran : noPendaftaran},
            success : function(){
                $('#myModal').modal('hide');
                $.Notification.autoHideNotify('success', 'top right', 'Berhasil','Transaksi telah dibatalkan');
            }
        }); 
      
    });
</script>