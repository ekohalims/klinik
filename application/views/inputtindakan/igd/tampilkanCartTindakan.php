<?php
	$i = 1;

	$numRows = $viewTindakan->num_rows();

	if($numRows > 0){

	foreach($viewTindakan->result() as $row){
?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $row->namaTarif; ?></td>
	<td><?php echo $row->namaDokter; ?></td>
	<td style="text-align:right;"><?php echo number_format($row->harga,'0',',','.'); ?></td>
	<td style="text-align:right;">
		<input type="number" class="form-control" value="<?php echo $row->selisih; ?>" id="selisih" data-id="<?php echo $row->kode; ?>" style="text-align:right;"/>
	</td>
	<td style="text-align:right;">
		<input type="number" class="form-control" value="<?php echo $row->qty; ?>" id="qty" data-id="<?php echo $row->kode; ?>" style="text-align:right;"/>
	</td>
	<td style="text-align:right;"><?php echo number_format(($row->harga*$row->qty)-$row->selisih,'0',',','.'); ?></td>
	<td style="text-align: right;"><a class="hapusTindakan" id="<?php echo $row->idTindakan; ?>"><i class="fa fa-trash"></i></a></td>
</tr>
<?php $i++; } } else { ?>

<tr>
	<td colspan="8" style="text-align: center;">--Belum ada data--</td>
</tr>

<?php } ?>