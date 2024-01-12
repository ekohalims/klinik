<?php
	$i = 1;
	$numRows = $cartLab->num_rows();

	if($numRows > 0  ){
	$total = 0;
	foreach($cartLab->result() as $row){
?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $row->namaLab; ?></td>
	<td><?php echo $row->catatan; ?></td>
	<td align="right"><?php echo number_format($row->harga,'0',',','.'); ?></td>
	<td style="text-align: center;"><a class="hapusCartLab" id="<?php echo $row->idLab; ?>" data-no_pendaftaran="<?php echo $row->noPendaftaran; ?>"><i class="fa fa-trash"></i></a></td>
</tr>
<?php $i++; $total = $total+$row->harga; }  ?>

<tr>
	<td colspan="3" style="text-align: center;font-weight: bold;">TOTAL</td>
	<td align="right" style="font-weight: bold;"><?php echo number_format($total,'0',',','.'); ?></td>
	<td></td>
</tr>

<?php } else { ?>
	<tr>
		<td colspan="5" style="text-align:center;">--Belum ada data--</td>
	</tr>
<?php } ?>