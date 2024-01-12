<div class="col-md-12" style="margin-top: 20px;border-top: solid 3px #ccc;border-radius: 3px;padding-top: 10px;text-align: right;">
	<a class="btn btn-success" onclick="printContent('print-area')"><i class="fa fa-print"></i> Print</a>
</div>

<div class="col-md-12" style="margin-top: 20px;">
	<div id="print-area">
		<center>
			<table width="100%">
				<tr>
					<td align="center" style="font-size: 12px;"><?php echo $klinikInfo->nama_perusahaan; ?></td>
				</tr>

				<tr>
					<td align="center"><?php echo $klinikInfo->alamat; ?></td>
				</tr>

				<tr>
					<td align="center"><?php echo $klinikInfo->kontak; ?></td>
				</tr>
			</table>
			

			<table width="30%" style="margin-top: 5px;">
				<tr>
					<td width="45%">No Pendaftaran</td>
					<td>:</td>
					<td><?php echo $dataDaftar->noPendaftaran; ?></td>
				</tr>

				<tr>
					<td width="40%">No Pasien</td>
					<td>:</td>
					<td><?php echo $dataDaftar->noPasien; ?></td>
				</tr>

				<tr>
					<td>Nama</td>
					<td>:</td>
					<td><?php echo $dataDaftar->namaLengkap; ?></td>
				</tr>

				<tr>
					<td>Poliklinik</td>
					<td>:</td>
					<td><?php echo $dataDaftar->poliklinik; ?></td>
				</tr>

				<tr>
					<td style="vertical-align: top;">Dokter</td>
					<td style="vertical-align: top;">:</td>
					<td><?php echo $dataDaftar->namaDokter; ?></td>
				</tr>

				<tr>
					<td>Tanggal</td>
					<td>:</td>
					<td><?php echo date_format(date_create($dataDaftar->tanggalDaftar),'d F Y H:i'); ?></td>
				</tr>
			</table>

			<table>
				<tr>
					<td style="text-align: center;font-size: 100px;font-weight: bold;">
						<?php
							echo substr($dataDaftar->noPendaftaran, 15,3);
						?>
					</td>
				</tr>
			</table>
		</center>
	</div>
</div>