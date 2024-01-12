<div class="row">
	<div class="col-md-12" style="border-bottom: solid 1px #ccc;padding-bottom: 5px;font-size: 20px;">
		<a class="backToCategory"><img src="<?php echo base_url('assets/back.png'); ?>" style="height: 18px;"/> <img src="<?php echo base_url('assets/medicine.png'); ?>" style="height: 20px;"/> <?php echo $kategori->kategori; ?></a>
	</div>
</div>

<div class="row" style="margin-top: 10px;">
	<div class="col-md-12">
		<table class="table table-bordered" id="datatable">
			<thead>
				<tr>
					<td width="5%" style="font-weight: bold;">No</td>
					<td style="font-weight: bold;">Kode</td>
					<td style="font-weight: bold;">Nama Obat</td>
				</tr>
			</thead>
		</table>
	</div>
</div>

<script type="text/javascript">
	var idKategori = "<?php echo $kategori->id_kategori; ?>";

	$('.backToCategory').on("click",function(){
		tampilkanKategoriObat();
	});

	$("#datatable").DataTable({
        ordering: false,
        processing: false,
        serverSide: true,
        ajax: {
           	url: "<?php echo base_url('antrian/viewObatPercategory'); ?>",
           	type:'POST',
           	data : {idKategori : idKategori}
        }
    });
</script>