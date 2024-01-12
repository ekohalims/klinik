<table class="table">
	<tr>
		<td width="30%">Nama Radiologi</td>
		<td><input type="text" class="form-control" id="namaRadiologi" value="<?php echo $item->namaRadiologi; ?>"></td>
	</tr>

	<tr>
		<td width="30%">Harga</td>
		<td><input type="number" class="form-control" id="harga" value="<?php echo $item->harga; ?>"></td>
	</tr>

	<tr>
		<td width="30%">Keterangan</td>
		<td>
			<textarea class="form-control" id="keterangan"><?php echo $item->keterangan; ?></textarea>
			<input type="hidden" id="jenis" value="edit">
			<input type="hidden" id="id" value="<?php echo $item->id; ?>">
		</td>
	</tr>

	<tr>
		<td width="30%">Status</td>
		<td>
			<select class="form-control" id="status">
				<option value="1" <?php if($item->status==1){echo "selected";} ?>>Aktif</option>
				<option value="0" <?php if($item->status==0){echo "selected";} ?>>Non-Aktif</option>
			</select>
		</td>
	</tr>
</table>