<legend>Data Customer</legend>

<table width="100%">
	<tr>
		<td width="30%" style="vertical-align: top;">ID Member</td>
		<td width="1%" style="vertical-align: top;">:</td>
		<td style="vertical-align: top;"><?php echo $dataCustomer->id_customer; ?></td>
	</tr>

	<tr>
		<td style="vertical-align: top;">Nama</td>
		<td style="vertical-align: top;">:</td>
		<td style="vertical-align: top;"><?php echo $dataCustomer->nama; ?></td>
	</tr>

	<tr>
		<td style="vertical-align: top;">Alamat</td>
		<td style="vertical-align: top;">:</td>
		<td style="vertical-align: top;"><?php echo $dataCustomer->alamat; ?></td>
	</tr>

	<tr>
		<td style="vertical-align: top;">Riwayat Pembelian</td>
		<td style="vertical-align: top;">:</td>
		<td style="vertical-align: top;"><?php echo $dataCustomer->belanjaKe; ?> Kali</td>
	</tr>

	<tr>
		<td style="vertical-align: top;">Jumlah Poin</td>
		<td style="vertical-align: top;">:</td>
		<td style="vertical-align: top;"><?php echo $dataCustomer->point; ?></td>
	</tr>

	<?php
		if($dataCustomer->point > 0){
	?>
	<tr>
		<td style="vertical-align: top;">Poin Reimburs</td>
		<td style="vertical-align: top;">:</td>
		<td style="vertical-align: top;">
			<input type="number" class="form-control" id="poin-reimbursment">
		</td>
	</tr>
	<?php
		}
	?>
</table>

<script type="text/javascript">
	var totalPurchaseUrl = "<?php echo base_url('penjualan/totalPurchase'); ?>";

	$('#poin-reimbursment').on("keyup",function(){
		//dapatkan id customer dan ambil poin maksimal
		id_customer = $('#customer-form').val();

		poinVal = $('#poin-reimbursment').val();
		max 	 = <?php echo $dataCustomer->point; ?>;

		totalPurchaseValue(poinVal,max);					
	});

	function totalPurchaseValue(poinVal,max){
		$.ajax({
					type 	: "POST",
					url  	: totalPurchaseUrl,
					success : function(totalPurchase){
							  var totalPurchaseConvert = totalPurchase.split(".").join("");

							  if(totalPurchaseConvert > 0){
									//CEK INPUTAN POIN TIDAK BOLEH MELEBIHI NILAI POIN YANG DIMILIKI CUSTOMER
									if(poinVal > max){
										$.Notification.notify('error', 'top right', 'Reimburs poin gagal', 'Inputan poin melebihi jumlah poin yang dimilki customer');
							            $('#poin-reimbursment').val('');
							            $('#poin-value-reimburs').text('');	
									} else {
										//dapatkan nilai reimburs poin
										getNilaiReimburs(poinVal);
									}	
								} else {
									$.Notification.notify('error', 'top right', 'Reimburs poin gagal', 'Belum ada item terinput');
							            $('#poin-reimbursment').val('');
							            $('#poin-value-reimburs').text('');
							            getNilaiReimburs(0);
								}
					}
		});
	}

	function getNilaiReimburs(poinVal){
		//dapatkan nilai reimbursment pada database dengan ajax
		$.ajax({
					type 	: 'POST',
					data 	: {poin : poinVal},
					url 	: "<?php echo base_url('penjualan/get_nilai_reimburs'); ?>",
					success : function(nilaiReimburs){	
								//insert data poin to db
								var urlInsertPoin = "<?php echo base_url('penjualan/insertPoin'); ?>"; 

								$.post(urlInsertPoin,{poinVal,nilaiReimburs},function(){
									var urlNilaiReimburs = "<?php echo base_url('penjualan/viewNilaiReimburs'); ?>";

									$('#poin-value-reimburs').load(urlNilaiReimburs);
									tampilkanDaftarHarga();
									tampilkanDaftarHargaCheckout();
								});
					}
		})
	}

</script>