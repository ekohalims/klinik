<table class="table" id="datatable">
	<thead>
		<tr>
			<th style="font-weight: bold;" width="5%">No</th>
			<th style="font-weight: bold;">Nama Tarif</th>
			<th style="font-weight: bold;">Harga</th>
			<th style="font-weight: bold;">Keterangan</th>
		</tr>
	</thead>

	<tbody>
		<?php
			$i = 1;
			foreach($item as $row){
		?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a class="orderLab" id="<?php echo $row->kode; ?>"><?php echo $row->namaTarif; ?></a></td>
			<td><?php echo number_format($row->tarif,'0',',','.'); ?></td>
			<td><?php echo $row->keterangan; ?></td>
		</tr>
		<?php $i++; } ?>
	</tbody>
</table>

<script type="text/javascript">
	$('#datatable').dataTable();
</script>