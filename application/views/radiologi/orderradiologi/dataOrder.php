<?php
    $i = 1;
    foreach($dataOrder as $row){
?>
    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $row->namaRadiologi; ?></td>
        <td><?php echo $row->first_name." ".$row->last_name; ?></td>
        <td><?php echo date_format(date_create($row->tanggal),'d/m/Y H:i'); ?></td>
        <td><?php echo $row->catatan; ?></td>
        <td style="text-align: center;">
        	<?php
        		if($statusOrder==1){
        			echo "<a class='hasilLab' id='".$row->idRadiologi."'><i class='fa fa-list'></i></a>";
        		} elseif($statusOrder==2){
                    echo "<a href='".base_url('orderRadiologi/printHasil/'.$noPendaftaran.'/'.$row->idRadiologi)."'><i class='fa fa-print'></i></a>";
                }
        	?>
        </td>
    </tr>
<?php $i++; } ?>