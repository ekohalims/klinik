<?php
	$total = 0;
	foreach($dataCart as $row){
?>	

<tr id="row<?php echo $row->id; ?>">
	<td width="65%" style="color: black;">
		<?php 
			echo substr($row->nama_produk, 0,20); 
		?>			
	</td>
	<td style="text-align: right;font-size: 12px;color: black;" rowspan="2">
		<?php 
			$harga = $row->qty*$row->harga;
			$percentageDiskon =(($harga-($harga-$row->diskon))/$harga)*100;

			if($row->diskon==0){
				echo number_format($harga,'0',',','.'); 
			} else {
				echo "<label class='label label-danger'>".number_format($percentageDiskon,'0',',','.')."%</label> <strike>".number_format($harga,'0',',','.')."</strike>"."<br>";
				echo number_format($harga-$row->diskon,'0',',','.');
			}
		?>		
	</td>
</tr>

<tr id="rowQty<?php echo $row->id; ?>" style="height: 25px;color: black;">
	<td colspan="2">
		<label class="label label-success"><a href="#editQtyModal" class="editQty qty<?php echo $row->id; ?>" id="<?php echo $row->id_produk; ?>" data-id_cart="<?php echo $row->id; ?>" data-toggle="modal" style="color: white;"><?php echo $row->qty; ?></a></label> x <?php echo number_format($row->harga,'0',',','.'); ?>
	</td>
</tr>
<?php } ?>