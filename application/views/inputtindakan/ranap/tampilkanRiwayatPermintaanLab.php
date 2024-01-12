<?php
    $numRows = $riwayatPermintaanLab->num_rows();

    if($numRows > 0){
        $i = 1;
        foreach($riwayatPermintaanLab->result() as $row){
?>
<tr>
    <td><?php echo $i; ?></td>
    <td><a class="rincianPermintaan" id="<?php echo $row->noPermintaan; ?>"><span class='label label-info'><?php echo $row->noPermintaan; ?></span></a></td>
    <td><?php echo nice_date($row->tanggal,'d/m/Y H:i'); ?></td>
    <td><?php echo $row->first_name." ".$row->last_name; ?></td>
    <td>
        <?php
            $status = $row->status;

            if($status==0){
                echo "<span class='label label-warning'>Belum di proses</span>";
            } elseif($status==1){
                echo "<span class='label label-info'>Dalam proses</span>";
            } elseif($status==2){
                echo "<span class='label label-success'>Selesai</span>";
            } else {
                echo "<span class='label label-danger'>Batal</span>";
            }
        ?>
    </td>
</tr>
<?php $i++; } } else { ?>

<tr>
    <td colspan="5">--Belum ada riwayat permintaan--</td>
</tr>

<?php } ?>