<table class="table">
	<tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Nama Rujukan</td>
		<td><input type="text" class="form-control" id="namaRujukan" value="<?php echo $row->asalRujukan; ?>"></td>
	</tr>

    <tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Jenis Rujukan</td>
		<td>
			<select class="form-control" id="jenisRujukan">
				<?php
					foreach($jenisRujukan as $dt){
				?>
				<option value="<?php echo $dt->idJenis; ?>" <?php if($row->idJenis==$dt->idJenis){echo "selected";}?>><?php echo $dt->jenisRujukan; ?></option>
				<?php } ?>
			</select >
			<input type="hidden" id="id" value="<?php echo $row->id; ?>"/>
        </td>
	</tr>

	<tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Keterangan</td>
		<td>
			<textarea class="form-control" id="keterangan"></textarea>
			<input type="hidden" id="jenis" value="edit">
		</td>
	</tr>
</table>
