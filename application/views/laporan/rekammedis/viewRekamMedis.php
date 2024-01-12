<?php
	foreach($viewRekamMedis as $row){
?>
<div class="row" style="padding-bottom: 10px;">
	<div class="col-md-12">
		<div style="border-top:solid 2px #ddd;padding-top: 5px;">
		<table width="100%">
			<tr>
				<td style="vertical-align: top;">
					<table width="100%">
						<tr>
							<td width="30%">No Pendaftaran</td>
							<td width="2%">:</td>
							<td><?php echo $row->noPendaftaran; ?></td>
						</tr>	

						<tr>
							<td>No Pasien</td>
							<td>:</td>
							<td><?php echo $row->noPasien;?></td>
						</tr>

						<tr>
							<td>Tanggal</td>
							<td>:</td>
							<td><?php echo date_format(date_create($row->tanggalDaftar),'d M Y H:i'); ?></td>
						</tr>

						<tr>
							<td>Nama</td>
							<td>:</td>
							<td><?php echo $row->namaLengkap;?></td>
						</tr>

						<tr>
							<td>Alamat</td>
							<td>:</td>
							<td><?php echo $row->alamat;?></td>
						</tr>

						<tr>
							<td>Jenis Kelamin</td>
							<td>:</td>
							<td><?php echo $row->jenisKelamin;?></td>
						</tr>

						<tr>
							<td>Dokter</td>
							<td>:</td>
							<td><?php echo $row->namaDokter;?></td>
						</tr>

						<tr>
							<td>Poliklinik</td>
							<td>:</td>
							<td><?php echo $row->poliklinik;?></td>
						</tr>
					</table>
				</td>
				
				<td width="50%" style="vertical-align: top;">
					<table width="100%">
						<?php
							$asalDaftar = $this->db->get_where("kl_daftar",array("noPendaftaran" => $row->noPendaftaran))->row()->asalDaftar;
							$tindakan = $this->modelKasir->viewTindakan($row->noPendaftaran,$asalDaftar);
							$numRowsTindakan = $tindakan->num_rows();

							if($numRowsTindakan > 0){
						?>
						<tr>
							<td style="font-weight: bold;"><i class="fa fa-stethoscope"></i> Tindakan</td>
						</tr>

						<tr>
							<td style="padding-left: 20px;">
								<?php 
									foreach($tindakan->result() as $td){
										echo "<li>".$td->namaTindakan."</li>";
									}
								?>
							</td>
						</tr>
						<?php } ?>
						<!--end tindakan-->

						<?php
							$diagnosa = $this->modelLaporan->viewDiagnosa($row->noPendaftaran);
							$numRowsDiagnosa = $diagnosa->num_rows();

							if($numRowsDiagnosa > 0){
						?>
						<tr>
							<td style="font-weight: bold;"><i class="fa fa-hand-o-right"></i> Diagnosa</td>
						</tr>

						<tr>
							<td style="padding-left: 20px;">
								<?php
									foreach($diagnosa->result() as $dg){
										echo "<li>".$dg->CODE." - ".$dg->diagnosa."</li>";
									}
								?>
							</td>
						</tr>
						<?php } ?>

						<?php
							$farmasi = $this->modelKasir->viewFarmasi($row->noPendaftaran);
							$numRowsFarmasi = $farmasi->num_rows();

							if($numRowsFarmasi > 0){
						?>
						<tr>
							<td style="font-weight: bold;"><i class="fa fa-umbrella"></i> Obat</td>
						</tr>

						<tr>
							<td style="padding-left: 20px;">
								<?php
									foreach($farmasi->result() as $frm){
										echo "<li>".$frm->nama_produk."(@".$frm->jumlah.")"."</li>";
									}
								?>
							</td>
						</tr>

						<?php } ?>

						<?php
							$laboratorium = $this->modelKasir->viewLaboratorium($row->noPendaftaran);
							$numRowsLaboratorium = $laboratorium->num_rows();

							if($numRowsLaboratorium > 0){
						?>
						<tr>
							<td style="font-weight: bold;"><i class="fa fa-tasks"></i> Laboratorium</td>
						</tr>

						<tr>
							<td style="padding-left: 20px;">
								<?php 
									foreach($laboratorium->result() as $lb){
										echo "<li>".$lb->namaLab."</li>";
									}
								?>
							</td>
						</tr>
						<?php  } ?>

						<?php
							$radiologi = $this->modelKasir->viewRadiologi($row->noPendaftaran);
							$numRowsRadiologi = $radiologi->num_rows();

							if($numRowsRadiologi > 0){
						?>
						<tr>
							<td style="font-weight: bold;"><i class="fa fa-sun-o"></i> Radiologi</td>
						</tr>

						<tr>
							<td style="padding-left: 20px;">
								<?php
									foreach($radiologi->result() as $rd){
										echo "<li>".$rd->namaRadiologi."</li>";
									}
								?>
							</td>
						</tr>

						<?php } ?>


						<tr>
							<td style="font-weight: bold;"><i class="fa fa-paper-plane"></i> Catatan</td>
						</tr>

						<?php
							$catatan = $this->modelLaporan->viewCatatan($row->noPendaftaran);
							$numRowsCatatan = $catatan->num_rows();

							if($numRowsCatatan > 0){
						?>

						<tr>
							<td style="padding-left: 16px;">
								<?php
									foreach($catatan->result() as $ct){
										if($ct->catatan==''){
											echo "Tidak ada catatan";
										} else {
											echo $ct->catatan;
										}
									}
								?>
							</td>
						</tr>

						<?php } ?>

						<tr>
							<td style="font-weight: bold;"><i class="fa fa-random"></i> Tindak Lanjut</td>
						</tr>
						
						<?php
							$tindakLanjut = $this->modelLaporan->viewTindakLanjut($row->noPendaftaran);
							$numRowsTindakLanjut = $tindakLanjut->num_rows();

							if($numRowsTindakLanjut > 0){
						?>
						<tr>
							<td style='padding-left:16px;'>
								<?php
									foreach($tindakLanjut->result() as $tdl){
										echo $tdl->namaTindakLanjut."<br>";
										echo "<b>".$tdl->keterangan."</b>";
									}
								?>
							</td>
						</tr>
						<?php } else { ?>
						<tr>
							<td>
								Tidak ada tindak lanjut
							</td>
						</tr>
						<?php } ?>
					</table>
				</td>
			</tr>
		</table>
		</div>
	</div>
</div>
<?php } ?>


