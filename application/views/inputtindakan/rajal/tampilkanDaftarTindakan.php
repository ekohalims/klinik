<table class="table" id="datatable">
	<thead>
		<tr>
			<td style="width: 1%" style="font-weight: bold;">No</td>
			<td style="font-weight: bold;">Pelayanan</td>
			<td style="font-weight: bold;">Jenis</td>
			<td style="font-weight: bold;">Harga</td>
		</tr>
	</thead>

	<tbody>
		<?php
			$i = 1;
			foreach($dataTindakan as $row){
		?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a class="addTindakan" id="<?php echo $row->kode; ?>"><?php echo $row->namaTarif; ?></a></td>
			<td><a class="addTindakan" id="<?php echo $row->kode; ?>"><?php echo $row->nama; ?></a></td>
			<td><?php echo number_format($row->tarif,'0',',','.'); ?></td>
		</tr>
		<?php $i++; } ?>
	</tbody>
</table>

<script type="text/javascript">
	$('#datatable').dataTable();
</script>