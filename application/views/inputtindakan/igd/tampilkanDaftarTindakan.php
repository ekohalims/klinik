<table class="table" id="datatable">
	<thead>
		<tr>
			<th style="width: 1%" style="font-weight: bold;">No</th>
			<th style="font-weight: bold;">Pelayanan</th>
			<th style="font-weight: bold;">Jenis</th>
			<th style="font-weight: bold;">Tarif</th>
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
			<td style='text-align:right;'><a class="addTindakan" id="<?php echo $row->kode; ?>"><?php echo number_format($row->tarif,'0',',','.'); ?></a></td>
		</tr>
		<?php $i++; } ?>
	</tbody>
</table>

<script type="text/javascript">
	$('#datatable').dataTable();
</script>