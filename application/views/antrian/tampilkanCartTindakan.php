<?php
	$i = 1;

	$numRows = $viewTindakan->num_rows();

	if($numRows > 0){

	foreach($viewTindakan->result() as $row){
?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $row->namaTindakan; ?></td>
	<td><?php echo $row->catatan; ?></td>
	<td><?php echo number_format($row->harga,'0',',','.'); ?></td>
	<td style="text-align: center;"><a class="hapusTindakan" id="<?php echo $row->idTindakan; ?>"><i class="fa fa-trash"></i></a></td>
</tr>
<?php $i++; } } else { ?>

<tr>
	<td colspan="5" style="text-align: center;">--Belum ada data--</td>
</tr>

<?php } ?>