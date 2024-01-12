<?php
	$numRows = $cart->num_rows();

	if($numRows > 0){

	$i = 1;
	foreach($cart->result() as $row){
?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $row->id_produk; ?></td>
	<td><?php echo $row->nama_produk; ?></td>
	<td><?php echo $row->kategori; ?></td>
	<td><?php echo number_format($row->harga,'0',',','.'); ?></td>
	<td><input type="number" class="form-control changeQty idProduk<?php echo $row->id_produk; ?>" id="<?php echo $row->id_produk; ?>" value="<?php echo $row->jumlah; ?>"/></td>
	<td><?php echo $row->satuan; ?></td>
	<td><input type="text" class="form-control aturanPakai" id="<?php echo $row->id_produk; ?>" value="<?php echo $row->aturan; ?>"/></td>
	<td style="text-align: center;"><a class="hapusResep" id="<?php echo $row->id_produk; ?>"><i class="fa fa-trash"></i></a></td>
</tr>
<?php $i++; } } else { ?>

<tr>
	<td colspan="8" align="center">--Belum ada data untuk ditampilkan--</td>
</tr>

<?php } ?>

<script type="text/javascript">
	$('.changeQty').on("change",function(){
		var qty = $(this).val();
		var idProduk = this.id;

		var url = "<?php echo base_url('inputTindakanIGD/ubahQtyResep'); ?>";

		$.ajax({
			method : "POST",
			url : url,
			data : {qty :qty, idProduk : idProduk, noPendaftaran : noPendaftaran},
			success : function(response){
				if(response=='StokEnough'){
					//$.Notification.autoHideNotify('success', 'top right', 'Berhasil!','Berhasil mengubah qty');
					tampilkanCart();
					loadDaftarBiaya(noPendaftaran);
				} else {
					$.Notification.autoHideNotify('error', 'top right', 'Gagal!','Stok tidak mecukupi');
					$('.idProduk'+idProduk).val(response);
					
				}
			}
		});
	});

	$('.aturanPakai').on("change",function(){
		var aturanPakai = $(this).val();
		var idProduk = this.id;

		var url = "<?php echo base_url('inputTindakanIGD/ubahAturanPakai'); ?>";
		
		$.ajax({
			method : "POST",
			url : url,
			data : {aturanPakai : aturanPakai, idProduk : idProduk, noPendaftaran : noPendaftaran},
			success : function(response){
				if(response > 0){
					//do nothing for a while
				} else {
					$.Notification.autoHideNotify('error', 'top right', 'Gagal!','Gagal mengubah aturan pakai');
				}
			},
			error : function(){
				$.Notification.autoHideNotify('error', 'top right', 'Gagal!','Kesalahan sistem');
			}
		});
	});
</script>