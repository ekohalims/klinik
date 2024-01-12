<table class="table table-bordered" id="datatable">
	<thead>
		<tr>
			<td style="font-weight: bold;" width="5%">No</td>
			<td style="font-weight: bold;">Nama Lab</td>
			<td style="font-weight: bold;">Harga</td>
			<td style="font-weight: bold;">Keterangan</td>
		</tr>
	</thead>

	<tbody>
		<?php
			$i = 1;
			foreach($item as $row){
		?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a class="orderLab" id="<?php echo $row->id; ?>"><?php echo $row->namaLab; ?></a></td>
			<td><?php echo number_format($row->harga,'0',',','.'); ?></td>
			<td><?php echo $row->keterangan; ?></td>
		</tr>
		<?php $i++; } ?>
	</tbody>
</table>

<script type="text/javascript">
	$('#datatable').dataTable();
</script>