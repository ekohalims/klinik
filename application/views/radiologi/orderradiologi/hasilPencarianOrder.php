<?php
	foreach($cariOrder as $row){
?>
<div class="row" style="margin-top: 15px;border-top: solid 2px #12a89d;padding-top: 5px;border-radius:3px;box-shadow: 1px 1px 3px #ccc;">
	<div class="col-md-4" style="padding: 10px;">
		<table width="100%">
			<tr>
				<td width="50%" style="font-weight: bold;">No Pendaftaran</td>
				<td><?php echo $row->noPendaftaran; ?></td>
			</tr>

			<tr>
				<td width="50%" style="font-weight: bold;">No Pasien</td>
				<td><?php echo $row->noPasien; ?></td>
			</tr>

			<tr>
				<td width="50%" style="font-weight: bold;">No ID</td>
				<td><?php echo $row->noID; ?></td>
			</tr>

			<tr>
				<td width="50%" style="font-weight: bold;">Nama</td>
				<td><?php echo $row->namaLengkap; ?></td>
			</tr>

			<tr>
				<td width="50%" style="font-weight: bold;vertical-align: top;">Alamat</td>
				<td style="vertical-align: top;"><?php echo $row->alamat; ?></td>
			</tr>

			<tr>
				<td width="50%" style="font-weight: bold;">Kontak</td>
				<td><?php echo $row->noHP; ?></td>
			</tr>

			<tr>
				<td width="50%" style="font-weight: bold;">Tanggal Permintaan</td>
				<td><?php echo date_format(date_create($row->tanggal),'d M Y H:i'); ?></td>
			</tr>

			<tr>
				<td width="50%" style="font-weight: bold;">Dokter</td>
				<td><?php echo $row->namaDokter; ?></td>
			</tr>

			<tr>
				<td width="50%" style="font-weight: bold;">Poli</td>
				<td><?php echo $row->poliklinik; ?></td>
			</tr>

			<tr>
				<td width="50%" style="font-weight: bold;">Status</td>
				<td>
					<?php
						if($row->status==0){
							echo "<span class='label label-warning'>Belum Diproses</span>";
						} elseif($row->status==1){
							echo "<span class='label label-info'>Dalam Proses</span>";
						} elseif($row->status==2){
							echo "<span class='label label-success'>Selesai</span>";
						}
					?>
				</td>
			</tr>
		</table>
	</div>	

	<div class="col-md-8" style="padding: 10px;">
		<label><u>Permintaan Radiologi</u></label>
		<table class="table table-striped table-bordered">
			<thead>
				<tr style="font-weight: bold;">
					<td width="4%">No</td>
					<td width="45%">Nama Order</td>
					<td>Catatan</td>
				</tr>
			</thead>

			<tbody>
				<?php
					$dataOrder = $this->modelOrderRadiologi->dataOrder($row->noPendaftaran);

					$i = 1;
					foreach($dataOrder as $dt){
				?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $dt->namaRadiologi; ?></td>
					<td><?php echo $dt->catatan; ?></td>
				</tr>
				<?php $i++; } ?>
			</tbody>
		</table>

		<div class="form-group" style="text-align: right;margin-top: 10px;">
			<?php
				$nilai = $this->encryption->encrypt($row->noPendaftaran);
				$encoded = strtr($nilai,array('+' => '.', '=' => '-', '/' => '~'));
			?>
			<a href="<?php echo base_url('orderRadiologi/processOrder/'.$encoded); ?>" class="btn btn-info"><i class="fa fa-eye"></i> Detail</a>
		</div>
	</div>
</div>
<?php } ?>