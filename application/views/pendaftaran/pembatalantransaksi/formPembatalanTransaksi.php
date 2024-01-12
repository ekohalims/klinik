Apakah pengembalian akan dipindahkan ke akun lain ? <br>
<input type="radio" name="refund" class="refund" value="yes"/> Ya <input type="radio" name="refund" class="refund" value="no"/> Tidak <br> <br>
                                
<div id="refundForm">
</div>

<div class="row">
    <div class="col-md-12" style="text-align:right;">
        <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger btn-rounded" id="batalkan">Batalkan</button>
    </div>
</div>

<script type="text/javascript">
    $('#batalkan').on("click",function(){
        if($('.refund').is(':checked')) { 
            var jenisRefund = $("input[name=refund]:checked").val();
            var urlBatal = "<?php echo base_url('pembatalanTransaksi/batalkanTransaksi'); ?>";

            if(jenisRefund=='yes'){
                var akun = '';
            } else {    
                var akun = $('#akun').val();
            }

            $.ajax({
                method : "POST",
                url : urlBatal,
                data : {akun : akun, noPendaftaran : noPendaftaran},
                success : function(){
                    $('#myModal').modal('hide');
                    $.Notification.autoHideNotify('success', 'top right', 'Berhasil','Transaksi telah dibatalkan');
                }
            }); 
        } else {
            $.Notification.autoHideNotify('error', 'top right', 'Gagal','Harap pilih apakah pengembalian dipindahkan ke akun lain');
        }
    });
</script>