<?php
	$i = 1;
	foreach($dokter as $row){
?>
<tr>
	<td style="text-align: center;"><?php echo $i; ?></td>
	<td><?php echo $row->nama; ?></td>
	<td><?php echo $row->poliklinik; ?></td>
	<td style="text-align: center;">
		<?php 
			echo $this->modelJadwalDokter->getJadwal($row->id_dokter,'1');
		?>
	</td>
	<td style="text-align: center;">
		<?php 
			echo $this->modelJadwalDokter->getJadwal($row->id_dokter,'2');
		?>
	</td>
	<td style="text-align: center;">
		<?php 
			echo $this->modelJadwalDokter->getJadwal($row->id_dokter,'3');
		?>
	</td>
	<td style="text-align: center;">
		<?php 
			echo $this->modelJadwalDokter->getJadwal($row->id_dokter,'4');
		?>
	</td>
	<td style="text-align: center;">
		<?php 
			echo $this->modelJadwalDokter->getJadwal($row->id_dokter,'5');
		?>
	</td>
	<td style="text-align: center;">
		<?php 
			echo $this->modelJadwalDokter->getJadwal($row->id_dokter,'6');
		?>
	</td>
	<td style="text-align: center;">
		<?php 
			echo $this->modelJadwalDokter->getJadwal($row->id_dokter,'7');
		?>
	</td>
	<td><a href="#myModal" data-toggle="modal" class="editJadwal" id="<?php echo $row->id_dokter; ?>"><i class="fa fa-pencil"></i></a></td>
</tr>
<?php $i++; } ?>