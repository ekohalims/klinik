<?php
    $i = 1;
    $numRows = $viewRegistPasien->num_rows();

    if($numRows > 0){
    foreach($viewRegistPasien->result() as $row){
        $nilai = $this->encryption->encrypt($row->noPendaftaran);
        $encoded = strtr($nilai,array('+' => '.', '=' => '-', '/' => '~'));
        
        $noPasien = $this->encryption->encrypt($row->idPasien);
		$enkrip = strtr($noPasien,array('+' => '.', '=' => '-', '/' => '~'));
?>

    <tr>
        <td style="vertical-align:middle;"><?php echo $i; ?></td>
        <td style="vertical-align:middle;"><?php echo $row->noPendaftaran; ?></td>
        <td style="vertical-align:middle;"><?php echo date_format(date_create($row->tanggalDaftar),'d/m/Y H:i'); ?></td>
        <td style="vertical-align:middle;"><?php echo $row->idPasien; ?></td>
        <td style="vertical-align:middle;"><?php echo $row->namaLengkap; ?></td>
        <td style="vertical-align:middle;"><?php echo date_format(date_create($row->tanggalLahir),'d/m/Y'); ?></td>
        <td style="vertical-align:middle;"><?php echo $row->layanan." ".$row->namaAsuransi; ?></td>
        <td style="vertical-align:middle;"></td>
        <td style="vertical-align:middle;"><?php echo $row->pos; ?></td>
        <td style="vertical-align:middle;"><?php echo $row->namaRuang; ?></td>
        <td style="vertical-align:middle;"><?php echo $row->namaDokter; ?></td>
        <td style="text-align:right;">
            <a target="_blank" href="<?php echo base_url('pendaftaranRanap/cetakGelang/'.$encoded); ?>" class="btn btn-sm btn-inverse"><i class="fa fa-life-ring"></i></a>
            <a target="_blank" href="<?php echo base_url('pendaftaranRanap/cetakKartuPasien/'.$enkrip); ?>" class="btn btn-sm btn-default"><i class="fa fa-credit-card"></i></a>
        </td>
    </tr>
<?php $i++; } } else { ?>
    <tr>
    <td colspan="12">
        <div class="alert alert-danger" style="text-align:center;">
            --Belum ada data--
        </div>
    </td>
</tr>
<?php } ?>