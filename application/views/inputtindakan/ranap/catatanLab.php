<div class="row">
	<div class="col-md-12" style="padding-bottom: 5px;font-size: 20px;">
		<div style="border-bottom: solid 1px #dedede;">
			<a class="backTo"><img src="<?php echo base_url('assets/back.png'); ?>" style="height: 18px;"/><?php echo $namaLab; ?></a>
		</div>
	</div>
</div>

<div class="row" style="margin-top: 10px;">
	<div class="col-md-12">
		<textarea class="form-control" placeholder="Catatan" id="catatanTextArea"></textarea>
	</div>

	<div class="col-md-12" style="margin-top: 10px;text-align: right;">
		<button class="btn btn-success btn-rounded" id="simpanLab"><i class="fa fa-save"></i> Simpan</button>
	</div>
</div>

<script type="text/javascript">
	$('.backTo').on("click",function(){
		loadItem();
	});

	$('#simpanLab').on("click",function(){
		var catatan = $('#catatanTextArea').val();
		var id = "<?php echo $id; ?>";

		orderLab(id,catatan);
	});
</script>