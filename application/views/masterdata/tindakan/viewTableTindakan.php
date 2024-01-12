<table class="table" id="datatable">
	<thead>
		<tr>
			<th width="5%" style="font-weight: bold;">No</th>
			<th width="25%" style="font-weight: bold;">Nama Tindakan</th>
			<th width="15%" style="font-weight: bold;">Tarif</th>
			<th width="15%" style="font-weight: bold;">Komisi</th>
			<th style="font-weight: bold;">Keterangan</th>
			<th width="8%" style="font-weight: bold;">Status</th>
			<th width="5%" style="font-weight: bold;"></th>
		</tr>
	</thead>

	<tbody>
		<?php
			$i = 1;
			foreach($tindakan as $row){
		?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->namaTindakan; ?></td>
			<td><?php echo number_format($row->tarif,'0',',','.'); ?></td>
			<td><?php echo number_format($row->komisi,'0',',','.'); ?></td>
			<td><?php echo $row->keterangan; ?></td>
			<td>
				<?php
					if($row->status==1){
						echo "<span class='label label-success'>Aktif</span>";
					} else {
						echo "<span class='label label-danger'>Non-Aktif</span>";
					}
				?>
			</td>
			<td style="text-align: center;">
				<a href="#myModal" data-toggle="modal" class="editTindakan" id="<?php echo $row->idTindakan; ?>"><i class="fa fa-pencil"></i></a> | 
				<a class="hapusTindakan" id="<?php echo $row->idTindakan; ?>"><i class="fa fa-trash"></i></a>
			</td>
		</tr>
		<?php $i++; } ?>
	</tbody>
</table>

<script type="text/javascript">
	$('#datatable').dataTable();
</script>