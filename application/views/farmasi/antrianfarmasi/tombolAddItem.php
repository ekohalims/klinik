<?php
	if($status==1) {
?>
    <a href="#itemModal" data-toggle="modal" class='btn btn-success btn-rounded' id="modalItem"><i class="fa fa-plus"></i> Tambah Item</a>
<?php } ?>


<a href="<?php echo base_url('antrianFarmasi/cetakResep/'.$noPendaftaran); ?>" target="__blank" class='btn btn-inverse btn-rounded'><i class="fa fa-print"></i> Cetak Resep</a>

<script type="text/javascript">
	$('#modalItem').on("click",function(){
		tampilkanItemModal(idKategori,search,limitStart);		
	});

	$('#kategori').on("change",function(){
		//reset current page
		$('#currentPage').val(1);

		var limitStart = $('#currentPage').val();
		var idKategori = $('#kategori').val();
		var search = $('#pencarian').val();
		
		tampilkanItemModal(idKategori,search,limitStart);
	});

	$('#pencarian').on("keydown",function(){
		//reset current page
		$('#currentPage').val(1);

		var limitStart = $('#currentPage').val();
		var idKategori = $('#kategori').val();
		var search = $('#pencarian').val();

		tampilkanItemModal(idKategori,search,limitStart);
	});
</script>
