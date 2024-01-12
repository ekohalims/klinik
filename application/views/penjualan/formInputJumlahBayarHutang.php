<diV class="row">
    <div class="col-md-6" style="padding-top: 5px;">
        <input type="text" class="form-control datepicker" placeholder="Jatuh Tempo" id="jatuhTempo" readonly style="border:0;border-bottom: solid 0.5px #ccc;width: 100%;">
    </div>

	<div class="col-md-6" style="padding-top: 5px;">
		<input type="text" class="form-control" placeholder="Jumlah Bayar" id="jumlah_bayar" style="border:0;border-bottom: solid 0.5px #ccc;width: 100%;">
	</div>
</diV>

<diV class="row" style="margin-top: 10px;">
    <div class="col-md-12" style="border-top: solid 1px #ccc;padding-top: 5px;">
        <textarea class="form-control" placeholder="Keterangan" id="keterangan"></textarea>
    </div>
</diV>

<script src="<?php echo base_url('assets'); ?>/assets/timepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	$('#jumlah_bayar').on("keyup", function(){
       	var urlGrandTotal = "<?php echo base_url('penjualan/viewGrandTotal'); ?>";
        jumlah_bayar = $('#jumlah_bayar').val();

        $.ajax({
            type        : "POST",
            url         : urlGrandTotal,
            success     : function(totalPurchase){
                            var grandTotal = totalPurchase.split('.').join("");
                            $('#kembalianCheckout').text(formatAngka(jumlah_bayar-grandTotal));
                            $('#jumlahBayarCheckout').text(formatAngka(jumlah_bayar));
            }
        });
    });

    jQuery('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        autoclose : true
    });
</script>