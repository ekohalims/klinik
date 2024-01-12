<table class="table" id="datatable">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>No Pendaftaran</th>
            <th>Tanggal</th>
            <th>Nama Pasien</th>
            <th>Jenis Kelamin</th>
            <th>Tanggal Lahir</th>
            <th>Dokter</th>
            <th>Poliklinik</th>
        </tr>
    </thead>

    <tbody>
        <?php
            $i = 1;
            $numRows = $dataPembayaran->num_rows();

            foreach($dataPembayaran->result() as $row){
                $nilai = $this->encryption->encrypt($row->noPendaftaran);
				$encoded = strtr($nilai,array('+' => '.', '=' => '-', '/' => '~'));
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><a class="label label-info" href="<?php echo base_url('kasir/payment/'.$encoded); ?>"><?php echo $row->noPendaftaran; ?></a></td>
            <td><?php echo date_format(date_create($row->tanggalDaftar),'d/m/Y H:i'); ?></td>
            <td><?php echo $row->namaPasien; ?></td>
            <td><?php echo $row->jenisKelamin; ?></td>
            <td><?php echo date_format(date_create($row->tanggalLahir),'d/m/Y'); ?></td>
            <td><?php echo $row->namaDokter; ?></td>
            <td><?php echo $row->poliklinik; ?></td>
        </tr>
        <?php $i++; }?>

    </tbody>
</table>

<script type='text/javascript'>
    $('#datatable').dataTable();
</script>