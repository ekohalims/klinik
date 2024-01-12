<table class="table table-bordered">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>No Pendaftaran</th>
            <th>No Pasien</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Poliklinik</th>
            <th>Dokter</th>
        </tr>
    </thead>

    <tbody>
        <?php
            $numRows = $viewLaporanKunjungan->num_rows();

            if($numRows > 0){
                $i = 1;
                foreach($viewLaporanKunjungan->result() as $row){
        ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row->noPendaftaran; ?></td>
                        <td><?php echo $row->noPasien; ?></td>
                        <td><?php echo $row->namaLengkap; ?></td>
                        <td><?php echo date_format(date_create($row->tanggalDaftar),'d M Y H:i'); ?></td>
                        <td><?php echo $row->poliklinik; ?></td>
                        <td><?php echo $row->namaDokter; ?></td>
                    </tr>
        <?php 
                $i++; } 
            } 
        ?>
    </tbody>
</table>