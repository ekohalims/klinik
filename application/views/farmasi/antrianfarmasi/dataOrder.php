<?php
    $i = 1;
    foreach($dataOrder as $row){
?>
<tr>
    <td><?php echo $i; ?></td>
    <td><?php echo $row->id_produk; ?></td>
    <td><?php echo $row->nama_produk; ?></td>
    <td style="text-align:center;"><?php echo $row->jumlah; ?></td>
    <td><?php echo $row->satuan; ?></td>
    <td>
        <input type="number" class="form-control" value="0" placeholder="Tuslah" style="text-align:right;"/>
    </td>
    <td><?php echo $row->aturan; ?></td>
    <td>
        <?php
            $expiredDate = $row->expiredDate;
            
            if(!empty($expiredDate)){
                if($status != 2){
                    echo "<a class='changeExpiredDate' id='".$row->id_produk."' data-no_pendaftaran='".$noPendaftaran."'><span class='label label-info'>".date_format(date_create($expiredDate),'d M Y')."</span></a>";
                } else {
                    echo date_format(date_create($expiredDate),'d M Y');
                }
            } else {
                echo "<span class='label label-info'>Tidak Ada Tanggal Expired</span>";
            }
        ?>
    </td>
    <td>
        <?php
            if(empty($row->noBatch)){
        ?>
        <a class="pilihNoBatch" id="<?php echo $row->id_produk; ?>" data-no_pendaftaran="<?php echo $noPendaftaran; ?>"><span class='label label-info'>Pilih No Batch</span></a>
        <?php } else {?>
            <a class="pilihNoBatch" id="<?php echo $row->id_produk; ?>" data-no_pendaftaran="<?php echo $noPendaftaran; ?>"><span class='label label-info'><?php echo $row->noBatch; ?></span></a>
        <?php } ?>
    </td>
    <td>
        <?php
            if($status==1){
        ?>
        <a class="hapusObat" id="<?php echo $row->id_produk; ?>"><i class="fa fa-trash"></i></a>
        <?php } ?>
    </td>
</tr>
<?php $i++; } ?>