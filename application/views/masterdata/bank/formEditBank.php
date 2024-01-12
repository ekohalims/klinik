<table class="table">
	<tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Kode Akun</td>
		<td><input type="text" class="form-control" value="<?php echo $bank->kodeBank; ?>" readonly></td>
	</tr>

	<tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Nama Bank</td>
		<td><input type="text" class="form-control" id="namaBank" value="<?php echo $bank->bank; ?>"></td>
	</tr>

	<tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Cabang</td>
		<td><input type="text" class="form-control" id="cabang" value="<?php echo $bank->cabang; ?>"/></td>
	</tr>

    <tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">No Rekening</td>
		<td><input type="text" class="form-control" id="noRekening" value="<?php echo $bank->noRekening; ?>"/></td>
	</tr>

    <tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Atas Nama</td>
		<td><input type="text" class="form-control" id="atasNama" value="<?php echo $bank->atasNama; ?>"><input type="hidden" id="jenis" value="edit"></td>
	</tr>

    <tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Status</td>
		<td>
            <select class="form-control" id="status">
                <option value="1" <?php if($bank->status==1){echo "selected";} ?>>Aktif</option>
                <option value="0" <?php if($bank->status==0){echo "selected";} ?>>Non-Aktif</option>
            </select>
            <input type="hidden" id="kodeAkun" value="<?php echo $kodeAkun; ?>"/>
        </td>
	</tr>

	<tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Menerima Pembayaran</td>
		<td>
			<input type="checkbox" id="debit" value="1" <?php if($bank->debit==1){echo "checked";}?>/> Debit <input type="checkbox" id="kredit" value="1" <?php if($bank->kredit==1){echo "checked";}?>/> Kredit <input type="checkbox" id="transfer" value="1" <?php if($bank->transfer==1){echo "checked";}?>/> Transfer
		</td>
	</tr>
</table>
