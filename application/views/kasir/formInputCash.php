<div class="input-group" style="border-top: solid 1px #ddd;padding-top: 10px;">
    <span class="input-group-addon"><i class="fa fa-money"></i></span>
    <input type="text" class="form-control" placeholder="Jumlah Bayar" id="jumlahBayar">
</div>

<div class="form-group" style="border-top: solid 1px #ddd;padding-top: 10px;text-align: right;">
    <a class="btn btn-inverse btn-rounded" id="prosesPembayaran" style="width:100%;"><i class="fa fa-save"></i> Proses Pembayaran</a>
</div>

<script type="text/javascript">
	$('#jumlahBayar').on("keyup", function(){
        var urlGrandTotal = "<?php echo base_url('kasir/grandTotal'); ?>";
       	var jumlahBayar = $(this).val();

        $.ajax({
            type : "POST",
            url : urlGrandTotal,
            data : {noPendaftaran : noPendaftaran},
            success : function(grandTotal){
                $('#payment_total_notif').css("display","");    

                $('#totalKeseluruhan').text(formatAngka(grandTotal));
                $('#jumlahBayarNotif').text(formatAngka(jumlahBayar));
                $('#kembaliNotif').text(formatAngka(jumlahBayar-grandTotal));
            }
        });
    });

    $('#prosesPembayaran').on("click",function(){
    	var jumlahBayar = $('#jumlahBayar').val();
    	var idPaymentType = $('#idPaymentValue').val();
    	var subAccount = '';

    	var urlProsesPembayaran = "<?php echo base_url('kasir/prosesPembayaran'); ?>";

		if(jumlahBayar==''){
			$.Notification.autoHideNotify('error', 'top right', 'Gagal!','Harap isi jumlah bayar');
		} else {
			
			grandTotal = grandTotal();

			if(parseInt(jumlahBayar) < parseInt(grandTotal)){
				$.Notification.autoHideNotify('error', 'top right', 'Gagal!','Jumlah bayar lebih kecil dari grand total');
			} else {
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
			}
		}
    });

	function grandTotal(){
		var urlGrandTotal = "<?php echo base_url('kasir/grandTotal'); ?>";

        $.ajax({
            type : "POST",
            url : urlGrandTotal,
            data : {noPendaftaran : noPendaftaran},
            success : function(grandTotal){
				return grandTotal;
            }
        });
	}
</script>
