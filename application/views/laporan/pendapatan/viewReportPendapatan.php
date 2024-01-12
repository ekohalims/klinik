<div class="row">
	<div class="col-md-12">
		<table width="100%">
			<tr>
				<td style="text-align: center;font-weight: bold;font-size: 18px;">Laporan Pendapatan</td>
			</tr>
			<tr>
				<td style="text-align: center;font-size: 14px;">Periode</td>
			</tr>
			<tr>
				<td style="text-align: center;font-size: 14px;"><?php echo $periode; ?></td>
			</tr>
		</table>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<table width="100%" border="1">
			<thead>
				<tr style="font-weight: bold;">
					<td width="5%" style="text-align: center;">No</td>
					<td style="padding-left:2px;">No Invoice</td>
					<td style="padding-left:2px;">No Pendaftaran</td>
					<td style="padding-left:2px;">Tanggal</td>
					<td style="padding-left:2px;">Pasien</td>
					<td style="padding-left:2px;">Tipe Bayar</td>
					<td style="padding-right:2px;text-align: right;">Total</td>
					<td style="padding-right:2px;text-align: right;">Diskon</td>
					<td style="padding-right:2px;text-align: right;">Grand Total</td>
				</tr>
			</thead>

			<tbody>
				<?php
					$i = 1;
					$numRows = $viewReportPendapatan->num_rows();
					$jumlah = 0;
					if($numRows > 0){
					foreach($viewReportPendapatan->result() as $row){
						$nilai = $this->encryption->encrypt($row->noInvoice);
						$encoded = strtr($nilai,array('+' => '.', '=' => '-', '/' => '~'));
				?>
				<tr>
					<td style="text-align: center;"><?php echo $i; ?></td>
					<td style="padding-left:2px;"><a href="<?php echo base_url('laporan/cetakInvoice/'.$encoded); ?>" target="_blank"><?php echo $row->noInvoice; ?></a></td>
					<td style="padding-left:2px;"><?php echo $row->noPendaftaran; ?></td>
					<td style="padding-left:2px;"><?php echo date_format(date_create($row->tanggalBayar),'d/m/y H:i'); ?></td>
					<td style="padding-left:2px;"><?php echo $row->namaLengkap; ?></td>
					<td style="padding-left:2px;"><?php echo $row->payment_type." ".$row->account; ?></td>
					<td style="padding-right:2px;text-align: right;"><?php echo number_format($row->grandTotal+$row->diskon,'0',',','.'); ?></td>
					<td style="padding-right:2px;text-align: right;"><?php echo number_format($row->diskon,'0',',','.'); ?></td>
					<td style="padding-right:2px;text-align: right;"><?php echo number_format($row->grandTotal,'0',',','.'); ?></td>
				</tr>
				<?php $i++; $jumlah = $jumlah+$row->grandTotal; } ?>

				<?php } else { ?>
				<tr>
					<td colspan="9">--Data tidak ditemukan--</td>
				</tr>
				<?php } ?>
			</tbody>

			<?php
				if($numRows > 0){
			?>

			<tfoot>
				<tr>
					<td colspan="8" style="font-weight: bold;text-align: center;">TOTAL</td>
					<td style="text-align: right;font-weight: bold;padding-right:2px;"><?php echo number_format($jumlah,'0',',','.'); ?></td>
				</tr>
			</tfoot>
			<?php } ?>
		</table>
	</div>
</div>