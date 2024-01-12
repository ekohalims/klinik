<table class="table table-bordered" id="datatable">
	<thead>
		<tr>
			<td style="font-weight: bold;" width="5%">No</td>
			<td style="font-weight: bold;">Nama Radiologi</td>
			<td style="font-weight: bold;" width="15%">Harga</td>
			<td style="font-weight: bold;" width="40%">Keterangan</td>
			<td style="font-weight: bold;" width="10%">Status</td>
			<td width="5%"></td>
		</tr>
	</thead>

	<tbody>
		<?php
			$i = 1;
			foreach($item as $row){
		?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->namaRadiologi; ?></td>
			<td><?php echo number_format($row->harga,'0',',','.'); ?></td>
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
			<td>
				<a href="#myModal" data-toggle="modal" class="ubahItem" id="<?php echo $row->id; ?>"><i class="fa fa-pencil"></i></a> | 
				<a class="hapusItem" id="<?php echo $row->id; ?>"><i class="fa fa-trash"></i></a>
			</td>
		</tr>
		<?php $i++; } ?>
	</tbody>
</table>

<script type="text/javascript">
	$('#datatable').dataTable();
</script>