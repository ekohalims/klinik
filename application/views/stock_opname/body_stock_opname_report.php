<div class="wraper container-fluid">
	<div class="row">
		<div class="col-md-6">
			<div class="page-title"> 
				<h3 class="title"><i class="fa fa-book"></i> Laporan Stock Opname Gudang</h3> 
			</div>
		</div>

		<div class="col-md-6" style="text-align:right;">
			<a class="btn btn-success btn-rounded" onclick="printContent('area-print')"><i class="fa fa-print"></i> Print</a>	
		</div>
	</div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
					<div class="col-md-12" id="area-print">  
						<table width="100%">
							<tr style="border-bottom:solid 1px #ccc;">
								<td with="60%" style="font-size:14px;">
									<?php 
										echo "<b>".$header->namaKlinik."</b><br>";
										echo $header->alamat."<br>";
										echo "Telepon ".$header->telepon;
									?>
								</td>
								<td style="text-align:right;vertical-align:bottom;font-weight:bold;">
									LAPORAN STOCK OPNAME
								</td>
							</tr>
						</table>

						<table width="100%" style="margin-top:5px;">
							<tr>
								<td width="50%">
									<table width="100%">
										<tr>
											<td width="20%">No SO</td>
											<td width="2%">:</td>
											<td><?php echo $headerSO->noSO; ?></td>
										</tr>

										<tr>
											<td>Tanggal</td>
											<td>:</td>
											<td>
												<?php
													echo date_format(date_create($headerSO->tanggal),'d M Y');
												?>
											</td>
										</tr>
									</table>
								</td>
								
								<td>
									<table width="100%">
										<tr>
											<td width="20%">PIC</td>
											<td width="2%">:</td>
											<td><?php echo $headerSO->first_name." ".$headerSO->last_name; ?></td>
										</tr>

										<tr>
											<td>Keterangan</td>
											<td>:</td>
											<td><?php echo $headerSO->keterangan; ?></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

						<table class="table" style="margin-top:10px;">
							<thead>
								<tr>
									<th style="width:3%;vertical-align:middle;" rowspan="2">No</th>
									<th style="width:15%;vertical-align:middle;" rowspan="2">Kode Item</th>
									<th rowspan="2" style="vertical-align:middle;">Nama Item</th>
									<th style="text-align:right;vertical-align:middle;" rowspan="2">Harga Pokok</th>
									<th colspan="2" style="text-align:center;">Nilai Buku</th>
									<th colspan="2" style="text-align:center;">Nilai Fisik</th>
									<th colspan="2" style="text-align:center;">Selisih</th>
								</tr>

								<tr>
									<th style="width:10%;text-align:center;">Jumlah</th>
									<th style="width:10%;text-align:right;">Nilai</th>
									<th style="width:10%;text-align:center;">Jumlah</th>
									<th style="width:10%;text-align:right;">Nilai</th>
									<th style="width:10%;text-align:center;">Jumlah</th>
									<th style="width:10%;text-align:right;">Nilai</th>
								</tr>
							</thead>

							<tbody>
								<?php
									$i = 1;
									$jumlahNilaiBuku = 0;
									$nilaiBuku = 0;
									$jumlahNilaiFisik = 0;
									$nilaiFisik = 0;
									$jumlahSelisih = 0;
									$nilaiSelisih = 0;

									foreach($dataSO as $row){
								?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $row->id_produk; ?></td>
									<td><?php echo $row->nama_produk; ?></td>
									<td style="text-align:right;"><?php echo number_format($row->harga,'0',',','.'); ?></td>
									<td style="text-align:center;"><?php echo number_format($row->lastStok,'0',',','.'); ?></td>
									<td style="text-align:right;"><?php echo number_format($row->lastStok*$row->harga,'0',',','.'); ?></td>
									<td style="text-align:center;"><?php echo number_format($row->newStok,'0',',','.'); ?></td>
									<td style="text-align:right;"><?php echo number_format($row->newStok*$row->harga,'0',',','.'); ?></td>
									<td style="text-align:center;"><?php echo number_format($row->newStok-$row->lastStok,'0',',','.'); ?></td>
									<td style="text-align:right;"><?php echo number_format(($row->newStok-$row->lastStok)*$row->harga,'0',',','.'); ?></td>
								</tr>
								<?php 
										$i++; 
										$jumlahNilaiBuku  = $jumlahNilaiBuku+$row->lastStok;
										$nilaiBuku = $nilaiBuku+($row->lastStok*$row->harga);
										$jumlahNilaiFisik = $jumlahNilaiFisik+$row->newStok;
										$nilaiFisik = $nilaiFisik+($row->newStok*$row->harga);
										$jumlahSelisih = $jumlahSelisih+($row->newStok-$row->lastStok);
										$nilaiSelisih = $nilaiSelisih+(($row->newStok-$row->lastStok)*$row->harga);
									} 
								?>
							</tbody>

							<tfoot>
								<tr>
									<td colspan="4" align="center"><b>TOTAL</b></td>
									<td style="text-align:center;font-weight:bold;"><?php echo number_format($jumlahNilaiBuku,'0',',','.'); ?></td>
									<td style="text-align:right;font-weight:bold;"><?php echo number_format($nilaiBuku,'0',',','.'); ?></td>
									<td style="text-align:center;font-weight:bold;"><?php echo number_format($jumlahNilaiFisik,'0',',','.'); ?></td>
									<td style="text-align:right;font-weight:bold;"><?php echo number_format($nilaiFisik,'0',',','.'); ?></td>
									<td style="text-align:center;font-weight:bold;"><?php echo number_format($jumlahSelisih,'0',',','.'); ?></td>
									<td style="text-align:right;font-weight:bold;"><?php echo number_format($nilaiSelisih,'0',',','.'); ?></td>
								</tr>
							</tfoot>
						</table>
					</div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>
