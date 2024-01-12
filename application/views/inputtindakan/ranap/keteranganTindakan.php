<div class="row">
	<div class="col-md-12" style="padding-bottom: 5px;font-size: 20px;">
		<div style="border-bottom: solid 1px #dedede;">
			<a class="backTo"><img src="<?php echo base_url('assets/back.png'); ?>" style="height: 18px;"/><?php echo $tindakan; ?></a>
		</div>
	</div>
</div>

<div class="row" style="margin-top: 10px;">
	<div class="col-md-12">
		<select class="select2" id="dokter">
			<option value="">Pilih Dokter</option>
			<?php
				foreach($dokter as $dk){
			?>
			<option value="<?php echo $dk->id_dokter; ?>"><?php echo $dk->nama; ?></option>
			<?php } ?>
		</select>
	</div>

	<div class="col-md-12">
		<br>
		<input type="text" class="form-control" id="tanggal" placeholder="Tanggal" data-mask="9999-99-99" value="<?php echo date('Y-m-d'); ?>"/>
		<label>yyyy-mm-dd</label>
	</div>

	<div class="col-md-12" style="margin-top: 10px;text-align: right;">
		<button class="btn btn-info" id="simpan"><i class="fa fa-save"></i> Simpan</button>
	</div>
</div>
<script src="<?php echo base_url('assets'); ?>/assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
<script type="text/javascript">
	// Select2
	jQuery(".select2").select2({
        width: '100%'
    });

	$('.backTo').on("click",function(){
		tampilkanDaftarTindakan();
	});

	$('#simpan').on("click",function(){
		var dokter = $('#dokter').val();
		var id = "<?php echo $id; ?>";
		var tanggal = $('#tanggal').val();

		addTindakan(id,dokter,tanggal);
	});
</script>