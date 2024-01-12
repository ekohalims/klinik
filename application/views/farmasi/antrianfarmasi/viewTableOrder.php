<table class="table table-bordered" id="datatable">
    <thead>
        <tr>
            <th width="4%">No</th>
            <th>No Pendaftaran</th>
            <th>No Pasien</th>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Tanggal Lahir</th>
            <th>Dokter</th>
            <th>Poliklinik</th>
        </tr>
    </thead>

    <tbody>
        <?php
            $i = 1;
            foreach($viewOrder as $row){
                $nilai = $this->encryption->encrypt($row->noPendaftaran);
		        $encoded = strtr($nilai,array('+' => '.', '=' => '-', '/' => '~'));
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><a href="<?php echo base_url('antrianFarmasi/processOrder/'.$encoded); ?>"><?php echo $row->noPendaftaran; ?></a></td>
            <td><?php echo $row->idPasien; ?></td>
            <td><?php echo date_format(date_create($row->tanggal),'d M Y H:i'); ?></td>
            <td><?php echo $row->namaPasien; ?></td>
            <td><?php echo date_format(date_create($row->tanggalLahir),'d M Y'); ?></td>
            <td><?php echo $row->namaDokter; ?></td>
            <td><?php echo $row->poliklinik; ?></td>
        </tr>
        <?php $i++; } ?>
    </tbody>
</table>

<script type="text/javascript">
    $('#datatable').dataTable();
</script>