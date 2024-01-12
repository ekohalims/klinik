<div class="wraper container-fluid">
    <div class="page-title"> 
    	<h3 class="title"><i class="fa fa-book"></i> Laporan Stock Opname Toko</h3> 
	</div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
					<div class="col-md-12">
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

                                        <tr>
											<td>Toko</td>
											<td>:</td>
											<td><?php echo $headerSO->store; ?></td>
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

						<table class="table table-striped" style="margin-top:10px;">
							<thead>
								<tr>
									<th style="width:3%;">No</th>
									<th style="width:15%;">Kode Item</th>
									<th>Nama Item</th>
									<th style="width:15%;text-align:center;">Stok Sistem</th>
									<th style="width:15%;text-align:center;">Stok Faktual</th>
									<th style="width:15%;text-align:center;">Selisih</th>
								</tr>
							</thead>

							<tbody>
								<?php
									$i = 1;
									foreach($dataSO as $row){
								?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $row->id_produk; ?></td>
									<td><?php echo $row->nama_produk; ?></td>
									<td style="text-align:center;"><?php echo number_format($row->lastStok,'0',',','.'); ?></td>
									<td style="text-align:center;"><?php echo number_format($row->newStok,'0',',','.'); ?></td>
									<td style="text-align:center;"><?php echo number_format($row->newStok-$row->lastStok,'0',',','.'); ?></td>
								</tr>
								<?php $i++; } ?>
							</tbody>
						</table>
					</div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>
