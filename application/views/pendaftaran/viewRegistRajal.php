<?php   
    $i = 1;
    $numRows = $viewRegist->num_rows();

    if($numRows > 0){
    foreach($viewRegist->result() as $row){
        $nilai = $this->encryption->encrypt($row->noPendaftaran);
		$encoded = strtr($nilai,array('+' => '.', '=' => '-', '/' => '~'));
?>  
<tr>
    <td style="vertical-align:middle;"><?php echo $i; ?></td>
    <td style="vertical-align:middle;"><?php echo $row->noPendaftaran; ?></td>
    <td style="vertical-align:middle;"><?php echo nice_date($row->tanggalDaftar,'d/m/y H:i'); ?></td>
    <td style="vertical-align:middle;"><?php echo $row->idPasien; ?></td>
    <td style="vertical-align:middle;"><?php echo $row->namaLengkap; ?></td>
    <td style="vertical-align:middle;"><?php echo nice_date($row->tanggalLahir,'d/m/Y'); ?></td>
    <td style="vertical-align:middle;"><?php echo $row->poliklinik; ?></td>
    <td style="vertical-align:middle;"><?php echo $row->namaDokter; ?></td>
    <td style="vertical-align:middle;"><?php echo $row->layanan." ".$row->namaAsuransi; ?></td>
    <td style="vertical-align:middle;"><?php echo $this->modelPublic->jenisKunjungan($row->idPasien); ?></td>
    <td style="vertical-align:middle;"></td>
    <td style="text-align:right;">
        <a target="_blank" href="<?php echo base_url('pendaftaranRajal/cetakSBP/'.$encoded); ?>" class="btn btn-sm btn-primary"><i class="fa fa-stethoscope"></i></a> 
        <a target="_blank" href="<?php echo base_url('pendaftaranRajal/cetakAntrian/'.$encoded); ?>" class="btn btn-sm btn-info"><i class="fa fa-users"></i></a> 
        <a target="_blank" href="<?php echo base_url('pendaftaranRajal/cetakIdentitas/'.$encoded); ?>" class="btn btn-sm btn-warning"><i class="fa fa-user"></i></a> 
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