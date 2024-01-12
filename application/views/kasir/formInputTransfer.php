<div class="form-group" style="border-top: solid 1px #ddd;padding-top: 10px;text-align: right;">
    <a class="btn btn-inverse btn-rounded" id="prosesPembayaran" style="width:100%;"><i class="fa fa-save"></i> Proses Pembayaran</a>
</div>

<script type="text/javascript">
    $('#prosesPembayaran').on("click",function(){
        var jumlahBayar = '';
        var idPaymentType = $('#idPaymentValue').val();
        var subAccount = '' ;

        var urlProsesPembayaran = "<?php echo base_url('kasir/prosesPembayaran'); ?>";

        $.ajax({
            method : "POST",
            url : urlProsesPembayaran,
            data : {jumlahBayar : jumlahBayar, idPaymentType : idPaymentType, subAccount : subAccount, noPendaftaran : noPendaftaran},
            beforeSend : function(){
                $('#CssLoader').show();
            },
            success : function(response){
                if(response=='Failed'){
                    $('#CssLoader').hide();
                    alert("Insert Failed");
                } else {
                    var urlRedirect = "<?php echo base_url('kasir/viewInvoice/'); ?>"+response;
                    window.location.replace(urlRedirect);
                }
            }
        });
    });
</script>