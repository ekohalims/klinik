<div class="input-group" style="border-top: solid 1px #ddd;padding-top: 5px;padding-bottom: 5px;">
	<div class="form-inline">
		<?php
			foreach($subPayment as $row){
		?>
		<div class="form-group" style="margin-top: 5px;">
			<button class='btn btn-info btn-rounded buttonSub subButton<?php echo $row->kodeBank; ?>' id="<?php echo $row->kodeBank; ?>"><?php echo $row->bank; ?></button>
		</div>
		<?php } ?>
	</div>
</div>

<div class="form-group" style="border-top: solid 1px #ddd;padding-top: 10px;text-align: right;">
    <a class="btn btn-inverse btn-rounded" id="prosesPembayaran" style="width:100%;"><i class="fa fa-save"></i> Proses Pembayaran</a>
</div>

<script type="text/javascript">
	$('.buttonSub').on("click",function(){
		var id = this.id;
		$('#subPaymentValue').val(id);
		disabledButton(id);
	});

	function disabledButton(id){
		$('.btn-info').prop("disabled",false);	
		$('.btn-info').removeAttr('style');

		$('.subButton'+id).prop("disabled",true);
		$('.subButton'+id).css("background","#262727");
		$('.subButton'+id).css("border","solid 1px #262727");
	}

	$('#prosesPembayaran').on("click",function(){
    	var jumlahBayar = '';
    	var idPaymentType = $('#idPaymentValue').val();
    	var subAccount = $('#subPaymentValue').val();
		
    	var urlProsesPembayaran = "<?php echo base_url('kasir/prosesPembayaran'); ?>";

		if(subAccount==''){
			$.Notification.autoHideNotify('error', 'top right', 'Gagal!','Harap pilih jenis pembayaran');
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
    });
</script>
