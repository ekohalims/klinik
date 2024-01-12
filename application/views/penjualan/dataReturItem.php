<?php
	$i = 1;
	$diskonPeritem = 0;
	foreach($invoiceItem as $row){
?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $row->id_produk; ?></td>
	<td><?php echo $row->nama_produk; ?></td>
	<td style="text-align: right;"><?php echo number_format($row->harga_jual,'0',',','.'); ?></td>
	<td style="text-align: center;"><?php echo $row->qty; ?></td>
	<td style="text-align: center;">
		<?php
			$returItem = $this->model_penjualan->returPeritem($noInvoice,$row->id_produk);
			echo number_format($returItem,'0',',','.');
		?>
	</td>
	<td><input type="number" class="form-control jumlahRetur produkFill" id="produk" data-no_invoice="<?php echo $noInvoice; ?>" data-id_produk="<?php echo $row->id_produk; ?>" data-max="<?php echo $row->qty-$returItem; ?>" data-harga="<?php echo $row->harga_jual; ?>" data-diskon="<?php echo $row->diskon; ?>"/></td>
	<td style="text-align: right;"><?php echo number_format($row->harga_jual*$row->qty,'0',',','.'); ?></td>
	<td style="text-align: right;"><?php echo number_format($row->diskon,'0',',','.'); ?></td>
	<td style="text-align: right;"><?php echo number_format($row->harga_jual*$row->qty-$row->diskon,'0',',','.'); ?></td>
</tr>
<?php $diskonPeritem = $diskonPeritem+$row->diskon; $i++; } ?>

<tr>
	<td colspan="9" style="text-align: center;font-weight: bold;">Subtotal</td>
	<td style="text-align: right;font-weight: bold;"><?php echo number_format($total->total-$diskonPeritem,'0',',','.'); ?></td>
</tr>

<?php
	if($total->diskon > 0){
?>
<tr>
	<td colspan="9" style="text-align: center;font-weight: bold;">Diskon Member</td>
	<td style="text-align: right;font-weight: bold;"><?php echo number_format($total->diskon,'0',',','.'); ?></td>
</tr>
<?php } ?>

<?php
	if($total->diskon_free > 0){
?>
<tr>
	<td colspan="9" style="text-align: center;font-weight: bold;">Diskon</td>
	<td style="text-align: right;font-weight: bold;"><?php echo number_format($total->diskon_free,'0',',','.'); ?></td>
</tr>
<?php } ?>

<?php
	if($total->poin_value > 0){
?>
<tr>
	<td colspan="9" style="text-align: center;font-weight: bold;">Poin Reimbursment</td>
	<td style="text-align: right;font-weight: bold;"><?php echo number_format($total->poin_value,'0',',','.'); ?></td>
</tr>
<?php } ?>

<?php
	if($total->ongkir > 0){
?>
<tr>
	<td colspan="9" style="text-align: center;font-weight: bold;">Ongkir</td>
	<td style="text-align: right;font-weight: bold;"><?php echo number_format($total->ongkir,'0',',','.'); ?></td>
</tr>
<?php } ?>

<tr>
	<td colspan="9" style="text-align: center;font-weight: bold;"><b>Grand Total</b></td>
	<td style="text-align: right;font-weight: bold;"><?php echo number_format(($total->ongkir+$total->total)-($total->diskon+$total->diskon_free+$total->poin_value+$diskonPeritem),'0',',','.'); ?></td>
</tr>

<input type="hidden" id="noInvoice" value="<?php echo $noInvoice; ?>"/>