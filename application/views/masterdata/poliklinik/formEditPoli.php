<table class="table" width="100%">
	<tr>
		<td width="25%" style="font-weight: bold;vertical-align: middle;">Nama Poliklinik</td>
		<td>
			<input type="text" class="form-control" id="namaPoliklinik" value="<?php echo $poli->poliklinik; ?>"/>
			<p style="color: red;" id="namaPoliLabel"></p>
		</td>
	</tr>

	<tr>
		<td width="25%" style="font-weight: bold;vertical-align: middle;">Keterangan</td>
		<td>
			<textarea class="form-control" id="keterangan"><?php echo $poli->keterangan; ?></textarea>
		</td>
	</tr>

	<tr>
		<td width="25%" style="font-weight: bold;vertical-align: middle;">Status</td>
		<td>
			<select class="form-control" id="status">
				<option value="1" <?php if($poli->status==1){echo "selected";} ?>>Aktif</option>
				<option value="0" <?php if($poli->status==0){echo "selected";} ?>>Non-Aktif</option>
			</select>
			<input type="hidden" id="jenis" value="edit">
			<input type="hidden" id="idPoli" value="<?php echo $poli->id_poliklinik; ?>">
		</td>
	</tr>
</table>