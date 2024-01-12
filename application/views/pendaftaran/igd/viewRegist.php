<?php
    $i = 1;
    $numRows = $viewIGD->num_rows();

    if($numRows > 0){
    foreach($viewIGD->result() as $row){
        $nilai = $this->encryption->encrypt($row->noPendaftaran);
		$encoded = strtr($nilai,array('+' => '.', '=' => '-', '/' => '~'));
?>
<tr>
    <td style="vertical-align:middle;"><?php echo $i; ?></td>
    <td style="vertical-align:middle;"><?php echo $row->noPendaftaran; ?></td>
    <td style="vertical-align:middle;"><?php echo nice_date($row->tanggalDaftar,'d/m/Y'); ?></td>
    <td style="vertical-align:middle;"><?php echo $row->idPasien; ?></td>
    <td style="vertical-align:middle;"><?php echo $row->namaLengkap; ?></td>
    <td style="vertical-align:middle;"><?php echo nice_date($row->tanggalLahir,'d/m/Y'); ?></td>
    <td style="vertical-align:middle;">IGD</td>
    <td style="vertical-align:middle;"><?php echo $row->namaDokter; ?></td>
    <td style="vertical-align:middle;"><?php echo $row->layanan." ".$row->namaAsuransi; ?></td>
    <td style="vertical-align:middle;">
        <?php
            if($row->tindakLanjut==1){
                echo "Dirawat";
            } elseif($row->tindakLanjut==2){
                echo "Pulang";
            } elseif($row->tindakLanjut==3){
                echo "Rujuk";
            }
        ?>
    </td>
    <td style="text-align:right;vertical-align:middle;">
        <a target="_blank" href="<?php echo base_url('pendaftaranIGD/cetakSBP/'.$encoded); ?>" class="btn btn-sm btn-primary"><i class="fa fa-stethoscope"></i></a> 
        <a target="_blank" href="<?php echo base_url('pendaftaranIGD/cetakIdentitas/'.$encoded); ?>" class="btn btn-sm btn-info"><i class="fa fa-user"></i></a> 
    </td>
</tr>
<?php $i++; } } else { ?>
<tr>
    <td colspan="11">
        <div class="alert alert-danger" style="text-align:center;">
            --Belum ada data--
        </div>
    </td>
</tr>
<?php } ?>