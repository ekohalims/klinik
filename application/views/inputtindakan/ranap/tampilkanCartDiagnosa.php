<?php
	$numRows = $cartLab->num_rows();

	$i = 1;
	if($numRows < 1){
?>

<tr>
	<td colspan="6" align="center">--Belum ada data--</td>
</tr>

<?php
	} else {

	foreach($cartLab->result() as $row){
?>

<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $row->code; ?></td>
	<td><?php echo $row->icd; ?></td>
	<td><?php echo $row->diagnosa; ?></td>
	<td><?php echo $row->keterangan; ?></td>
	<td style="text-align: center;"><a class="hapusCartDiag" id="<?php echo $row->id; ?>"><i class="fa fa-trash"></i></a></td>
</tr>
<?php $i++; } } ?>