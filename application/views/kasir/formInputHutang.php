<div class="input-group" style="border-top: solid 1px #ddd;padding-top: 10px;">
    <span class="input-group-addon" style="background: #ddd;"><i class="fa fa-calendar"></i></span>
    <input type="text" class="form-control datepicker" id="jatuhTempo" placeholder="Jatuh Tempo Pembayaran" readonly>
</div>

<div class="input-group" style="padding-top: 10px;">
    <span class="input-group-addon" style="background: #ddd;"><i class="fa fa-money"></i></span>
    <textarea class="form-control" placeholder="Keterangan" id="keterangan"></textarea>
</div>

<div class="form-group" style="padding-top: 10px;text-align: right;">
    <a class="btn btn-inverse btn-rounded" id="prosesPembayaran" style="width:100%;"><i class="fa fa-save"></i> Proses Pembayaran</a>
</div>

<script type="text/javascript">
    jQuery('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        autoclose : true
    });

    $('#prosesPembayaran').on("click",function(){
        var jumlahBayar = '';
        var idPaymentType = $('#idPaymentValue').val();
        var subAccount = '' ;
        var jatuhTempo = $('#jatuhTempo').val();
        var keterangan = $('#keterangan').val();

        var urlProsesPembayaran = "<?php echo base_url('kasir/prosesPembayaranHutang'); ?>";

        if(jatuhTempo==''){
            $.Notification.autoHideNotify('error', 'top right', 'Gagal!','Harap isi jatuh tempo');
        } else {
            $.ajax({
                method : "POST",
                url : urlProsesPembayaran,
                data : {jatuhTempo : jatuhTempo, keterangan : keterangan, jumlahBayar : jumlahBayar, idPaymentType : idPaymentType, subAccount : subAccount, noPendaftaran : noPendaftaran},
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
        }
    });
</script>
