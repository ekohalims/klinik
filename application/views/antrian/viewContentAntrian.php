 <?php
    $numRows = $daftarAntrian->num_rows();

    if($numRows < 1){
?>
    <div class="alert alert-danger" style="text-align: center;">
        --Belum ada data ditampilkan--
    </div>
<?php } else { ?>

<table class="table" id="datatable">
    <thead>
        <tr>
            <th>No Antrian</th>
            <th>Tanggal Daftar</th>
            <th>No Pendaftaran</th>
            <th>No RM</th>
            <th>Nama</th>
            <th>Jenis Layanan</th>
            <th>Poli</th>
            <th>Dokter</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
    <?php
        foreach($daftarAntrian->result() as $row){
            $enkrip = $this->encryption->encrypt($row->noPendaftaran);
            $noPendaftaran = strtr($enkrip,array('+' => '.', '=' => '-', '/' => '~'));
    ?>
        <tr>
            <td><?php echo substr($row->noPendaftaran, 15, 3); ?></td>
            <td><?php echo date_format(date_create($row->tanggalDaftar),'d/m/Y H:i'); ?></td>
            <td><?php echo $row->noPendaftaran; ?></td>
            <td><?php echo $row->idPasien; ?></td>
            <td><?php echo $row->namaLengkap; ?></td>
            <td><?php echo $row->layanan." ".$row->namaAsuransi; ?></td>
            <td><?php echo $row->poliklinik; ?></td>
            <td><?php echo $row->namaDokter; ?></td>
            <td style="text-align: right;"><a href="<?php echo base_url('antrian/tindakanPasien?noPendaftaran='.$noPendaftaran); ?>"><i class="fa fa-pencil"></i></a></td>
         </tr>
    <?php } ?>
    </tbody>
</table>
<?php } ?>
