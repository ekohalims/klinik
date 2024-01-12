<div style="border-top: solid 1px #ccc;margin-top: 5px;padding: 5px;">
	<?php
		foreach($subAccount as $row){
	?>
		<button class="btn btn-success btn-rounded" id="buttonAccount<?php echo $row->id_payment_account; ?>" data-id="<?php echo $row->id_payment_account; ?>"><?php echo $row->account; ?></button>
	<?php } ?>
	<input type="hidden" id="jumlah_bayar"/>
</div>

<diV class="row" style="margin-top: 10px;">
    <div class="col-md-12" style="border-top: solid 1px #ccc;padding-top: 5px;">
        <textarea class="form-control" placeholder="Keterangan" id="keterangan"></textarea>
    </div>
</diV>

<script type="text/javascript">
	$('.btn-success').on("click",function(){
		var idAccount = $(this).data('id'); 

		addClassess(idAccount);
		$('#subAccountHidden').val(idAccount);

		fillJumlahBayar();
	});

	function addClassess(idAccount){
		$('.btn-success').prop("disabled",false);	
		$('.btn-success').removeAttr('style');

		$('#buttonAccount'+idAccount).prop("disabled",true);
		$('#buttonAccount'+idAccount).css("background","#262727");
		$('#buttonAccount'+idAccount).css("border","solid 1px #262727");
	}


</script>