<div class="wraper container-fluid">
    <div class="panel panel-default" >
        <div class="panel-body" id="print-area">
            <div class="hidden-print">
                <div class="pull-right">
                    <a href="#" onclick="printContent('print-area')" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                </div>
            </div>

            <div class="row">
                <div class= "col-md-12" id="dataContent">

					<div style="margin-top: 10px;">
						<table width="100%">
							<tr style="border-bottom: solid 1px #ddd;">
								<td width="40%">
									<h3 style="font-size: 18px;"><?php echo $header->store; ?></h3>
									<p><?php echo $header->alamat; ?><br>
									Telpon <?php echo $header->kontak; ?></p>
								</td>
								<td width="50%" style="text-align: right;font-weight: bold;font-size: 18px;vertical-align: bottom">
									INVOICE
								</td>
							</tr>
						</table>

						<BR>
						Customer.

						<table width="100%">
							<tr>
								<td width="50%">
									<table width="100%">
										<tr>
											<td width="15%">Nama</td>
											<td width="1%">:</td>
											<td><?php echo $invoiceInfo->nama; ?></td>
										</tr>

										<tr>
											<td width="15%">No Telp</td>
											<td width="1%">:</td>
											<td><?php echo $invoiceInfo->kontak; ?></td>
										</tr>

										<tr>
											<td width="15%" style="vertical-align: top;">Alamat</td>
											<td width="1%" style="vertical-align: top;">:</td>
											<td><?php echo $invoiceInfo->alamat; ?></td>
										</tr>
									</table>
								</td>

								<td style="vertical-align: top;">
									<table width="100%">
										<tr>
											<td width="20%">No Invoice</td>
											<td width="1%">:</td>
											<td><?php echo $invoiceInfo->no_invoice; ?></td>
										</tr>

										<tr>
											<td width="20%">Tanggal</td>
											<td width="1%">:</td>
											<td><?php echo date_format(date_create($invoiceInfo->tanggal),'d F Y H:i'); ?></td>
										</tr>

										<tr>
											<td width="20%">Pembayaran</td>
											<td width="1%">:</td>
											<td><?php echo $invoiceInfo->payment_type." ".$invoiceInfo->account; ?></td>
										</tr>

										<?php
											if($invoiceInfo->tipe_bayar==5){
										?>
										<tr>
											<td width="20%">Jatuh Tempo</td>
											<td width="1%">:</td>
											<td><?php echo date_format(date_create($invoiceInfo->jatuh_tempo),'d F Y'); ?></td>
										</tr>
										<?php
											}
										?>
									</table>
								</td>
							</tr>
						</table>

						<br>
						<table width="100%">
							<tr style="font-weight: bold;border:solid 1px black;">
								<td width="3%" style="text-align: center;border:solid 1px black;">No</td>
								<td style="border:solid 1px black;width: 13%">Kode Barang</td>
								<td style="border:solid 1px black;">Nama Barang</td>
								<td style="border:solid 1px black;width: 10%;text-align: right;">Harga Satuan</td>
								<td style="border:solid 1px black;width: 10%;text-align: right;">Pajak</td>
								<td style="border:solid 1px black;width: 10%;text-align: right;">Diskon</td>
								<td width="10%" style="text-align: center;border:solid 1px black;">QTY</td>
								<td width="15%" style="text-align: center;border:solid 1px black;text-align: right;">Total</td>
							</tr>

							<?php
								$i = 1;
								$diskonPeritem = 0;
								$jumlah_item = 0;
								$ppn = 0;
								foreach($invoiceItem->result() as $row){
							?>
							<tr style="border-left: solid 1px black;border-right: solid 1px black;">
								<td align="center" style="border-right: solid 1px black;vertical-align: top;"><?php echo $i; ?></td>
								<td style="border-right: solid 1px black;vertical-align: top;"><?php echo $row->id_produk; ?></td>
								<td style="border-right: solid 1px black;vertical-align: top;"><?php echo $row->nama_produk; ?></td>
								<td style="border-right: solid 1px black;text-align: right;vertical-align: top;"><?php echo number_format($row->harga_jual,'0',',','.'); ?></td>
								<td style="border-right: solid 1px black;text-align: right;vertical-align: top;"><?php echo number_format($row->pajak,'0',',','.'); ?></td>
								<td style="border-right: solid 1px black;text-align: right;vertical-align: top;"><?php echo number_format($row->diskon,'0',',','.'); ?></td>
								<td style="border-right: solid 1px black;text-align: center;vertical-align: top;"><?php echo number_format($row->qty,'0',',','.'); ?></td>
								<td style="border-right: solid 1px black;text-align: right;vertical-align: top;">
									<?php echo number_format($row->qty*$row->harga_jual,'0',',','.'); ?>
								</td>
							</tr>
							<?php 
								$i++; 
								$diskonPeritem = $diskonPeritem+$row->diskon;
								$jumlah_item = $jumlah_item+$row->qty;
								$ppn = $ppn+$row->pajak;
								} 
							?>

							<tr style="border-top: solid 1px black;">
								<td colspan="5" rowspan="10" style="vertical-align:top;">
									Total Item <?php echo $item_barang; ?>, Total Keseluruhan Item <?php echo $jumlah_item; ?>
									<br>
									Terbilang :
									<b><?php echo $terbilang; ?></b>
								</td>
								<td colspan="2" align="right">Subtotal</td>
								<td style="text-align: right;"><?php echo number_format($invoiceInfo->total,'0',',','.'); ?></td>
							</tr>

							<?php
								if($diskonPeritem > 0){
							?>
							<tr>
								<td colspan="2" align="right">Diskon</td>
								<td style="text-align: right;border-bottom:solid 1px #ddd;"><?php echo number_format($diskonPeritem,'0',',','.'); ?></td>
							</tr>
							<?php
								}
							?>

							<tr>
								<td colspan="2" align="right"><b>Total Setelah Diskon</b></td>
								<td style="text-align: right;"><?php echo number_format($invoiceInfo->total-$diskonPeritem,'0',',','.'); ?></td>
							</tr>
							
							<?php
								if($ppn > 0){
							?>
								<tr>
								<td colspan="2" align="right">PPN 10%</td>
								<td style="text-align: right;"><?php echo number_format($ppn,'0',',','.'); ?></td>
							</tr>
							<?php
								}
							?>

							<?php
								if(!empty($invoiceInfo->ongkir)){
							?>
							<tr>
								<td colspan="2" align="right">Biaya Pengiriman</td>
								<td style="text-align: right;"><?php echo number_format($invoiceInfo->ongkir,'0',',','.'); ?></td>
							</tr>
							<?php
								}
							?>

							<?php
								if(!empty($invoiceInfo->diskon)){
							?>
							<tr>
								<td colspan="2" align="right">Diskon Member</td>
								<td style="text-align: right;"><?php echo number_format($invoiceInfo->diskon,'0',',','.'); ?></td>
							</tr>
							<?php
								}
							?>

							<?php
								if(!empty($invoiceInfo->diskon_free)){
							?>
							<tr>
								<td align="right">Diskon</td>
								<td style="text-align: right;"><?php echo number_format($invoiceInfo->diskon_free,'0',',','.'); ?></td>
							</tr>
							<?php
								}
							?>

							<?php
								if(!empty($invoiceInfo->poin_value)){
							?>
							<tr>
								<td colspan="2" align="right">Poin Reimburs</td>
								<td style="text-align: right;"><?php echo number_format($invoiceInfo->poin_value,'0',',','.'); ?></td>
							</tr>
							<?php
								}
							?>

							<tr>
								<td colspan="2" align="right"><b>Grand Total</b></td>
								<td style="text-align: right;border-top:solid 1px #ddd;"><?php echo number_format(($invoiceInfo->ongkir+$invoiceInfo->total+$ppn)-($invoiceInfo->diskon+$invoiceInfo->diskon_free+$invoiceInfo->poin_value+$diskonPeritem),'0',',','.'); ?></td>
							</tr>
							
							<?php
								if($invoiceInfo->tipe_bayar == 5){
									$grandTotal = ($invoiceInfo->ongkir+$invoiceInfo->total+$ppn)-($invoiceInfo->diskon+$invoiceInfo->diskon_free+$invoiceInfo->poin_value+$diskonPeritem);
							?>
							<tr>
								<td colspan="2" align="right"><b>Down Payment</b></td>
								<td style="text-align: right;"><?php echo number_format($invoiceInfo->jumlah_bayar,'0',',','.'); ?></td>
							</tr>

							<tr>
								<td colspan="2" align="right"><b>Sisa Pembayaran</b></td>
								<td style="text-align: right;"><?php echo number_format($grandTotal-$invoiceInfo->jumlah_bayar,'0',',','.'); ?></td>
							</tr>
							<?php } ?>

							
							<?php
								if($invoiceInfo->tipe_bayar != 5){
							?>
							<tr>
								<td colspan="2" align="right"><b>Jumlah Bayar</b></td>
								<td style="text-align: right;"><?php echo number_format($invoiceInfo->jumlah_bayar,'0',',','.'); ?></td>
							</tr>

							<tr>
								<td colspan="2" align="right"><b>Kembali</b></td>
								<td style="text-align: right;"><?php echo number_format($invoiceInfo->jumlah_bayar-(($invoiceInfo->ongkir+$invoiceInfo->total+$ppn)-($invoiceInfo->diskon+$invoiceInfo->diskon_free+$invoiceInfo->poin_value+$diskonPeritem)),'0',',','.'); ?></td>
							</tr>
							<?php } ?>
						</table>
					</div>


				</div>
            </div>
        </div>
    </div>

</div>
