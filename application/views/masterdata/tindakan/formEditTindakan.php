<table class="table">
	<tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Nama Tindakan</td>
		<td><input type="text" class="form-control" id="namaTindakan" value="<?php echo $tindakan->namaTindakan; ?>"></td>
	</tr>

	<tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Tarif</td>
		<td><input type="number" class="form-control" id="tarif" value="<?php echo $tindakan->tarif; ?>"></td>
	</tr>

	<tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Komisi</td>
		<td><input type="number" class="form-control" id="komisi" value="<?php echo $tindakan->komisi; ?>"></td>
	</tr>

	<tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Keterangan</td>
		<td>
			<textarea class="form-control" id="keterangan"><?php echo $tindakan->keterangan; ?></textarea>
			<input type="hidden" id="jenis" value="edit">
			<input type="hidden" id="idTindakan" value="<?php echo $idTindakan; ?>">
		</td>
	</tr>

	<tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Status</td>
		<td>
			<select class="form-control" id="status">
				<option value="1" <?php if($tindakan->status==1){echo "selected"; } ?>>Aktif</option>
				<option value="0" <?php if($tindakan->status==0){echo "selected"; } ?>>Non-Aktif</option>
			</select>
		</td>
	</tr>
</table>
