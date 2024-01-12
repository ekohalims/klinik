<?php
    $i = 1;
    foreach($dataOrder as $row){
?>
    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $row->namaLab; ?></td>
        <td><?php echo $row->catatan; ?></td>
        <td><?php echo $row->hasil; ?></td>
        <td><?php echo $row->nmin." ".$row->nmax." - ".$row->satuan; ?></td>
        <td style="text-align: right;">
        	<?php
        		if($statusOrder==1){
        			echo "<a class='hasilLab' id='".$row->idLab."'><i class='fa fa-list'></i></a>";
        		} 
        	?>
        </td>
    </tr>
<?php $i++; } ?>