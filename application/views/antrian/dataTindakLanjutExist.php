<center>
	<table width="60%">
		<tr style="height: 50px;">
			<td width="30%">Tindak Lanjut</td>
			<td>
				<select class="form-control" id="tindakLanjutId">
					<option value="">--Pilih Tindak Lanjut--</option>
					<?php
						foreach($dropdownTindakLanjut as $row){
					?>
					<option value="<?php echo $row->idTindakLanjut; ?>" <?php if($currentValue->idTindakLanjut==$row->idTindakLanjut){echo "selected"; } ?>><?php echo $row->namaTindakLanjut; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>

		<tr>
			<td width="30%">Keterangan</td>
			<td>
				<textarea class="form-control" id="keterangan"><?php echo $currentValue->keterangan; ?></textarea>
			</td>
		</tr>

		<tbody id="additionalForm">
		</tbody>
	</table>
</center>

<script type="text/javascript">
	var currentValue = "<?php echo $currentValue->idTindakLanjut; ?>";
	loadAdditionalForm(currentValue);

	$(document).on("change",'#tanggalKontrol',function(){
		var tanggalKontrol = $(this).val();

		var url = "<?php echo base_url('antrian/updateTanggalKontrol'); ?>";

		$.ajax({
			method : "POST",
			url : url,
			data : {noPendaftaran : noPendaftaran, tanggalKontrol : tanggalKontrol},
			success : function(){
				//do nothing sementeara
			}
		});
	});

	$(document).on("change","#spesialis",function(){
		var spesialis = $(this).val();
		var tujuan = ''; 

		var url = "<?php echo base_url('antrian/updateRujukanPasien'); ?>";

		$.ajax({
			method : "POST",
			url : url,
			data : {spesialis : spesialis, tujuan : tujuan, noPendaftaran : noPendaftaran},
			success : function(){
				//do nothing sementara
			}
		});
	});

	$(document).on("change","#tujuan",function(){
		var spesialis = '';
		var tujuan =  $(this).val();

		var url = "<?php echo base_url('antrian/updateRujukanPasien'); ?>";

		$.ajax({
			method : "POST",
			url : url,
			data : {spesialis : spesialis, tujuan : tujuan, noPendaftaran : noPendaftaran},
			success : function(){
				//do nothing sementara
			}
		});
	});

	$("#keterangan").change(function(){
		simpanTindakLanjut();
	});

	$('#tindakLanjutId').change(function(){
		var id =  $(this).val();
		loadAdditionalForm(id);
		simpanTindakLanjut();
	});

	function simpanTindakLanjut(){
		var tindakLanjut = $('#tindakLanjutId').val();
		var keterangan = $('#keterangan').val();

		var simpanTindakLanjut = "<?php echo base_url('antrian/simpanTindakLanjut'); ?>";

		$.ajax({
			method : "POST",
			url : simpanTindakLanjut,
			data : {tindakLanjut : tindakLanjut, keterangan : keterangan, noPendaftaran : noPendaftaran},
			beforeSend : function(){
				//$('#simpanTindakLanjut').prop('disabled',true);
			},
			success : function(){
				//$('#simpanTindakLanjut').prop('disabled',false);
				//$.Notification.autoHideNotify('success', 'top right', 'Berhasil!','Tindak lanjut tersimpan');
			}
		});
	}

	function loadAdditionalForm(id){
		if(id=='1'){
			var url = "<?php echo base_url('antrian/formKontrolKembali'); ?>";
			$('#additionalForm').load(url,{noPendaftaran : noPendaftaran});
		} else if(id==4){
			var url = "<?php echo base_url('antrian/formRujukPasien'); ?>";
			$('#additionalForm').load(url,{noPendaftaran : noPendaftaran});
		} else {
			$.ajax({
				method : "POST",
				url : "<?php echo base_url('antrian/kosongkanRujukanDanTanggalKontrol'); ?>",
				data : {noPendaftaran : noPendaftaran},
				success : function(){
					$('#additionalForm').empty();
				}
			});
		}
	}
</script>