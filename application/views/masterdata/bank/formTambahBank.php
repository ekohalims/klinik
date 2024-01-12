<table class="table">
	<tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Kode Akun</td>
		<td><input type="text" class="form-control" id="kodeAkun" value="<?php echo $kodeBank; ?>" readonly></td>
	</tr>

	<tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Nama Bank</td>
		<td><input type="text" class="form-control" id="namaBank"></td>
	</tr>

	<tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Cabang</td>
		<td><input type="text" class="form-control" id="cabang"/></td>
	</tr>

    <tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">No Rekening</td>
		<td><input type="text" class="form-control" id="noRekening"/></td>
	</tr>

    <tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Atas Nama</td>
		<td><input type="text" class="form-control" id="atasNama"><input type="hidden" id="jenis" value="tambah"></td>
	</tr>

	<tr>
		<td width="30%" style="vertical-align: middle;font-weight: bold;">Menerima Pembayaran</td>
		<td>
			<input type="checkbox" id="debit" value="1"/> Debit <input type="checkbox" id="kredit" value="1"/> Kredit <input type="checkbox" id="transfer" value="1"/> Transfer
		</td>
	</tr>
</table>
