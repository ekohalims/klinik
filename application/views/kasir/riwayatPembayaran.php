<?php
    $numRows = $riwayatPembayaran->num_rows();

    if($numRows > 0){
        $i = 1;
        foreach($riwayatPembayaran->result() as $row){
?>
<tr>    
    <td><?php echo $i; ?></td>
    <td><?php echo $row->noPembayaran; ?></td>
    <td><?php echo date_format(date_create($row->tanggalBayar),'d/m/Y H:i'); ?></td>
    <td><?php echo $row->first_name; ?></td>
    <td><?php echo $row->payment_type." ".$row->account; ?></td>
    <td><?php echo $row->keterangan; ?></td>
    <td style="text-align:right;"><?php echo number_format($row->nilaiBayar,'0',',','.'); ?></td>
</tr>
<?php $i++; } } else { ?>
<tr>
    <td colspan="7">--Belum ada riwayat pembayaran--</td>
</tr>
<?php } ?>