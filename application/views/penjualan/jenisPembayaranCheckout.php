<div class="col-md-12">
	<?php
		foreach($paymentType as $row){
	?>
		<button class="btn btn-info btn-rounded" id="button<?php echo $row->id; ?>" data-id="<?php echo $row->id; ?>"><?php echo $row->payment_type; ?></button>
	<?php } ?>
	<input type="hidden" id="typeBayar">
	<input type="hidden" id="subAccountHidden">
</div>

<div class="col-md-12" style="margin-top: 5px;" id="subAccount">
</div>


<script type="text/javascript">
	$('.btn-rounded').on("click",function(){
		var idPayment = $(this).data('id'); 

		addClasses(idPayment);

		if(idPayment==2 || idPayment==3){
			var urlSubAccount = "<?php echo base_url('penjualan/subAccountCheckout'); ?>";
			$('#subAccount').load(urlSubAccount,{idPayment : idPayment});
			$('#formInputJumlahBayar').empty();
			
		} else if(idPayment==5) {
			var urlHutangTempo = "<?php echo base_url('penjualan/formPembayaranHutangDanTempo'); ?>";
			$('#formInputJumlahBayar').load(urlHutangTempo);
			$('#subAccount').empty();
		} else if(idPayment==4){
			var urlTipeBayarTransfer = "<?php echo base_url('penjualan/formTipeBayarTransfer'); ?>";
			$('#formInputJumlahBayar').load(urlTipeBayarTransfer);
			$('#subAccount').empty();
			$('#subAccountHidden').val('');
			fillJumlahBayar();
		} else {
			$('#subAccount').empty();
			var urlFormInputJumlahBayar = "<?php echo base_url('penjualan/formInputJumlahBayar'); ?>";
			$('#formInputJumlahBayar').load(urlFormInputJumlahBayar);
			$('#subAccountHidden').val('');
		}

		$('#typeBayar').val(idPayment);
	});

	function addClasses(idPayment){
		$('.btn-success').prop("disabled",false);	
		$('.btn-info').removeAttr('style');

		$('#button'+idPayment).prop("disabled",true);
		$('#button'+idPayment).css("background","#262727");
		$('#button'+idPayment).css("border","solid 1px #262727");
	}


</script>

