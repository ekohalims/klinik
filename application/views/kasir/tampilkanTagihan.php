<?php
	foreach($cariTagihan as $row){
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
				<td width="50%" style="font-weight: bold;">Tanggal Datang</td>
				<td><?php echo date_format(date_create($row->tanggalDaftar),'d M Y H:i'); ?></td>
			</tr>

			<tr>
				<td width="50%" style="font-weight: bold;vertical-align: top;">Dokter</td>
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
						if($row->status==1){
							echo "<span class='label label-warning'>Belum Terbayar</span>";
						} elseif($row->status==2){
							echo "<span class='label label-success'>Terbayar</span>";
						} elseif($row->status==3){
							echo "<span class='label label-danger'>Batal</span>";
						}
					?>
				</td>
			</tr>
		</table>
	</div>	

	<div class="col-md-8" style="padding: 10px;">
		<label><u>Daftar Biaya</u></label>
		<div style="border:solid 1px #ccc;padding: 10px;">
			<table width="100%">

				<!--tab tindakan-->
				<?php
					$tindakan = $this->modelKasir->viewTindakan($row->noPendaftaran);
					$numRowsTindakan = $tindakan->num_rows();
				
					if($numRowsTindakan > 0){
				?>

					<tr>
						<td colspan="3" style="font-weight: bold;">Biaya Tindakan</td>
					</tr>

					<?php
						foreach($tindakan->result() as $td){
					?>

					<tr>
						<td style="padding-left: 30px;" width="83%"><?php echo $td->namaTindakan; ?></td>
						<td width="1%">Rp.</td>
						<td style="text-align: right;"><?php echo number_format($td->harga,'0',',','.'); ?></td>
					</tr>

					<?php } ?>

				<?php } ?>
				<!--end tindakan-->

				<!--farmasi-->
				<?php
					$farmasi = $this->modelKasir->viewFarmasi($row->noPendaftaran);
					$numRowsFarmasi = $farmasi->num_rows();

					if($numRowsFarmasi > 0){
				?>

					<tr>
						<td colspan="3" style="font-weight: bold;">Biaya Obat-obatan</td>
					</tr>

					<?php
						foreach($farmasi->result() as $fm){
					?>

					<tr>
						<td style="padding-left: 30px;">
							<?php 
								echo $fm->nama_produk."<br>";
								echo "&nbsp @".$fm->jumlah." x ".number_format($fm->harga,'0',',','.'); 
							?>
						</td>
						<td style="vertical-align: bottom;">Rp.</td>
						<td style="vertical-align: bottom;text-align: right;"><?php echo number_format($fm->harga*$fm->jumlah,'0',',','.'); ?></td>
					</tr>
					<?php } ?>

				<?php } ?>
				<!--end farmasi-->

				<!-- Laboratorium-->
				<?php
					$laboratorium = $this->modelKasir->viewLaboratorium($row->noPendaftaran);
					$numRowsLaboratorium = $laboratorium->num_rows();

					if($numRowsLaboratorium > 0){
				?>
					<tr>
						<td colspan="3" style="font-weight: bold;">Laboratorium</td>
					</tr>

					<?php
						foreach($laboratorium->result() as $lb){
					?>
					<tr>
						<td style="padding-left: 30px;"><?php echo $lb->namaLab; ?></td>
						<td>Rp.</td>
						<td style="text-align: right;"><?php echo number_format($lb->harga,'0',',','.'); ?></td>
					</tr>
					<?php } ?>
				<?php } ?>
				<!--end laboratorium-->

				<!--radiologi-->
				<?php
					$radiologi = $this->modelKasir->viewRadiologi($row->noPendaftaran);
					$numRowsRadiologi = $radiologi->num_rows();

					if($numRowsRadiologi > 0){
				?>

					<tr>
						<td colspan="3" style="font-weight: bold;">Radiologi</td>
					</tr>

					<?php
						foreach($radiologi->result() as $rd){
					?>
					<tr>
						<td style="padding-left: 30px;"><?php echo $rd->namaRadiologi; ?></td>
						<td>Rp.</td>
						<td style="text-align: right;"><?php echo number_format($rd->harga,'0',',','.'); ?></td>
					</tr>
					<?php } ?>

				<?php } ?>
				<!--end radiologi-->

				<tr style="border-top: solid 1px #ccc;">
					<td style="text-align: center;font-size: 13px;"><b>TOTAL</b></td>
					<td>Rp.</td>
					<td style="text-align: right;font-weight: bold;font-size: 13px;	">
						<?php
							$total = $this->modelKasir->totalTransaksi($row->noPendaftaran);

							echo number_format($total,'0',',','.');
						?>
					</td>
				</tr>
			</table>
		</div>

		<div class="form-group" style="text-align: right;margin-top: 10px;">
			<?php
				if($row->status==1){
					$nilai = $this->encryption->encrypt($row->noPendaftaran);
					$encoded = strtr($nilai,array('+' => '.', '=' => '-', '/' => '~'));
			?>
				<a class="btn btn-primary btn-rounded" href="<?php echo base_url('kasir/payment/'.$encoded); ?>"><i class="fa fa-money"></i> Bayar Sekarang</a>
			<?php } elseif($row->status==2){ ?>

				<?php
					$noInvoice = $this->db->get_where("kl_invoice",array("noPendaftaran" => $row->noPendaftaran))->row()->noInvoice;

					$nilai = $this->encryption->encrypt($noInvoice);
					$encoded = strtr($nilai,array('+' => '.', '=' => '-', '/' => '~'));
				?>

				<a class="btn btn-success btn-rounded" href="<?php echo base_url('kasir/viewInvoice/'.$encoded); ?>"><i class="fa fa-print"></i> Cetak Ulang Invoice</a>
			<?php } ?>
		</div>
	</div>
</div>
<?php } ?>