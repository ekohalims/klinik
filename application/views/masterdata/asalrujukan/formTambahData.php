<table class="table">
	<tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Nama Rujukan</td>
		<td><input type="text" class="form-control" id="namaRujukan"></td>
	</tr>

    <tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Jenis Rujukan</td>
		<td>
			<select class="form-control" id="jenisRujukan">
				<?php
					foreach($jenisRujukan as $row){
				?>
				<option value="<?php echo $row->idJenis; ?>"><?php echo $row->jenisRujukan; ?></option>
				<?php } ?>
			</select >
        </td>
	</tr>

	<tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Keterangan</td>
		<td>
			<textarea class="form-control" id="keterangan"></textarea>
			<input type="hidden" id="jenis" value="tambah">
		</td>
	</tr>
</table>
