<div class="row">
	<div class="col-md-12" style="border-bottom: solid 1px #ccc;padding-bottom: 5px;font-size: 20px;">
		<a class="backToObat"><img src="<?php echo base_url('assets/back.png'); ?>" style="height: 18px;"/> <img src="<?php echo base_url('assets/medicine.png'); ?>" style="height: 20px;"/> <?php echo $namaObat; ?></a>
	</div>
</div>

<div class="row" style="margin-top: 10px;">
	<div class="col-md-12">
		<div class="form-group">
			<label>Quantity</label>
			<input type="number" class="form-control" id="qty">
		</div>

		<div class="form-group">
			<label>Aturan Pakai</label>
			<input type="text" class="form-control" id="aturanPakai">
		</div>

		<div class="form-group">
			<button class="btn btn-success btn-rounded rules" value="3x1">3x1</button>
			<button class="btn btn-success btn-rounded rules" value="2x1">2x1</button>
			<button class="btn btn-success btn-rounded rules" value="1x1">1x1</button>
		</div>

		<div class="form-group">
			<button class="btn btn-inverse btn-rounded rules" value="Sesudah Makan">Sesudah Makan</button>
			<button class="btn btn-inverse btn-rounded rules" value="Sebelum Makan">Sebelum Makan</button>
		</div>
	</div>
</div>

<div class="row" style="margin-top: 10px;border-top: solid 1px #ddd;">
	<div class="col-md-12" style="text-align: right;padding-top: 10px;">
		<button class="btn btn-primary btn-rounded" id="simpanResep"><i class="fa fa-save"></i> Simpan</button>
	</div>
</div>

<script type="text/javascript">
	$('.backToObat').on("click",function(){
		tampilkanDaftarObat(idKategori);
	});

	$('.rules').on("click",function(){
		var aturanPakai = $(this).val();
		var currentValue = $('#aturanPakai').val();

		$('#aturanPakai').val(currentValue+' '+aturanPakai);
	});

	$('#simpanResep').on("click",function(){
		var idProduk = "<?php echo $idProduk; ?>";
		var aturanPakai = $('#aturanPakai').val();
		var qty = $('#qty').val();

		var urlSimpanResep = "<?php echo base_url('antrian/simpanResepPasien'); ?>";
	
		$.ajax({
			method : "POST",
			url : urlSimpanResep,
			data : {idProduk : idProduk, aturanPakai : aturanPakai,noPendaftaran : noPendaftaran, qty : qty},
			success : function(){
				$('#myModal').modal('hide');
				tampilkanCart();
			},
			error : function(){
				alert('Error');
			}
		});
	});
</script>