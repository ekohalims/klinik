<div class="row">
	<div class="col-md-12">
		<div style="border-bottom: solid 1px #dedede;">
			<table width="100%">
				<tr style="font-size: 13px;">
					<td width="40%" style="font-weight: bold;">Nama</td>
					<td width="2%">:</td>
					<td><?php echo $dokter->nama; ?></td>
				</tr>

				<tr style="font-size: 13px;">
					<td style="font-weight: bold;">Poli</td>
					<td>:</td>
					<td><?php echo $dokter->poliklinik; ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>

<div class="row" style="margin-top: 10px;">
	<div class="col-md-12">
		<table width="100%">
			<tr style="height: 40px;">
				<td width="40%">Senin</td>
				<td width="28%"><input type="text" class="form-control" id="begin" data-id_jadwal="1" value="<?php echo $this->modelJadwalDokter->getJadwalBegin($idDokter,'1') ?>"></td>
				<td width="4%" style="text-align: center;">s/d</td>
				<td width="28%"><input type="text" class="form-control" id="end" data-id_jadwal="1" value="<?php echo $this->modelJadwalDokter->getJadwalEnd($idDokter,'1') ?>"></td>
			</tr>

			<tr style="height: 40px;">
				<td width="40%">Selasa</td>
				<td width="28%"><input type="text" class="form-control" id="begin" data-id_jadwal="2" value="<?php echo $this->modelJadwalDokter->getJadwalBegin($idDokter,'2') ?>"></td>
				<td width="4%" style="text-align: center;">s/d</td>
				<td width="28%"><input type="text" class="form-control" id="end" data-id_jadwal="2" value="<?php echo $this->modelJadwalDokter->getJadwalEnd($idDokter,'2') ?>"></td>
			</tr>

			<tr style="height: 40px;">
				<td width="40%">Rabu</td>
				<td width="28%"><input type="text" class="form-control" id="begin" data-id_jadwal="3" value="<?php echo $this->modelJadwalDokter->getJadwalBegin($idDokter,'3') ?>"></td>
				<td width="4%" style="text-align: center;">s/d</td>
				<td width="28%"><input type="text" class="form-control" id="end" data-id_jadwal="3" value="<?php echo $this->modelJadwalDokter->getJadwalEnd($idDokter,'3') ?>"></td>
			</tr>

			<tr style="height: 40px;">
				<td width="40%">Kamis</td>
				<td width="28%"><input type="text" class="form-control" id="begin" data-id_jadwal="4" value="<?php echo $this->modelJadwalDokter->getJadwalBegin($idDokter,'4') ?>"></td>
				<td width="4%" style="text-align: center;">s/d</td>
				<td width="28%"><input type="text" class="form-control" id="end" data-id_jadwal="4" value="<?php echo $this->modelJadwalDokter->getJadwalEnd($idDokter,'4') ?>"></td>
			</tr>

			<tr style="height: 40px;">
				<td width="40%">Jumat</td>
				<td width="28%"><input type="text" class="form-control" id="begin" data-id_jadwal="5" value="<?php echo $this->modelJadwalDokter->getJadwalBegin($idDokter,'5') ?>"></td>
				<td width="4%" style="text-align: center;">s/d</td>
				<td width="28%"><input type="text" class="form-control" id="end" data-id_jadwal="5" value="<?php echo $this->modelJadwalDokter->getJadwalEnd($idDokter,'5') ?>"></td>
			</tr>

			<tr style="height: 40px;">
				<td width="40%">Sabtu</td>
				<td width="28%"><input type="text" class="form-control" id="begin" data-id_jadwal="6" value="<?php echo $this->modelJadwalDokter->getJadwalBegin($idDokter,'6') ?>"></td>
				<td width="4%" style="text-align: center;">s/d</td>
				<td width="28%"><input type="text" class="form-control" id="end" data-id_jadwal="6" value="<?php echo $this->modelJadwalDokter->getJadwalEnd($idDokter,'6') ?>"></td>
			</tr>

			<tr style="height: 40px;">
				<td width="40%">Minggu</td>
				<td width="28%"><input type="text" class="form-control" id="begin" data-id_jadwal="7" value="<?php echo $this->modelJadwalDokter->getJadwalBegin($idDokter,'7') ?>"></td>
				<td width="4%" style="text-align: center;">s/d</td>
				<td width="28%"><input type="text" class="form-control" id="end" data-id_jadwal="7" value="<?php echo $this->modelJadwalDokter->getJadwalEnd($idDokter,'7') ?>"><input type="hidden" id="idDokter" value="<?php echo $idDokter; ?>" /></td>
			</tr>
		</table>
	</div>
</div>