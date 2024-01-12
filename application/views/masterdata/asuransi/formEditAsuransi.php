<table class="table">
	<tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Nama Asuransi</td>
		<td><input type="text" class="form-control" id="namaAsuransi" value="<?php echo $asuransi->namaAsuransi; ?>"></td>
	</tr>

	<tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Tempo</td>
		<td><input type="text" class="form-control" id="tempo" value="<?php echo $asuransi->tempo; ?>"></td>
	</tr>

	<tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Keterangan</td>
		<td>
			<textarea class="form-control" id="keterangan"><?php echo $asuransi->keterangan; ?></textarea>
			<input type="hidden" id="jenis" value="edit">
            <input type="hidden" id="idAsuransi" value="<?php echo $asuransi->idAsuransi; ?>"/>
		</td>
	</tr>

    <tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Status</td>
		<td>
            <select class="form-control" id="status">
                <option value="1" <?php if($asuransi->status=='1'){echo "selected";} ?>>Aktif</option>
                <option value="0" <?php if($asuransi->status=='0'){echo "selected";} ?>>Non - Aktif</option>
            </select>
        </td>
	</tr>
</table>
