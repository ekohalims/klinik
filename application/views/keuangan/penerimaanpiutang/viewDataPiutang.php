<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>No Pendaftaran</th>
            <th>No RM</th>
            <th>Nama Pasien</th>
            <th>Tanggal Daftar</th>
            <th>Jatuh Tempo</th>
            <th>Penanggung</th>
            <th style="text-align:right;">Total Piutang</th>
            <th style="text-align:right;">Terbayar</th>
            <th style="text-align:right;">Sisa Piutang</th>
        </tr>
    </thead>

    <tbody>
        <?php
            $i = 1;
            $totalPiutang = 0;
            $totalTerbayar = 0;
            $sisaPiutang = 0;
            $numRows = $viewDataPiutang->num_rows();

            if($numRows > 0){
            foreach($viewDataPiutang->result() as $row){
                $piutangTerbayar = $this->modelPublic->hutangTerbayar($row->noPendaftaran);

                $nilai = $this->encryption->encrypt($row->noPendaftaran);
		        $encoded = strtr($nilai,array('+' => '.', '=' => '-', '/' => '~'));
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><a href="<?php echo base_url('penerimaanPiutang/bayarPiutang/'.$encoded); ?>"><?php echo $row->noPendaftaran; ?></a></td>
            <td><?php echo $row->idPasien; ?></td>
            <td><?php echo $row->namaPasien; ?></td>
            <td>
                <?php
                    echo date_format(date_create($row->tanggalDaftar),'d M Y');
                ?>
            </td>
            <td>
                <?php
                    echo date_format(date_create($row->jatuhTempo),'d M Y');
                ?>
            </td>
            <td>
                <?php echo $row->layanan." ".$row->namaAsuransi; ?>
            </td>
            <td style="text-align:right;"><?php echo number_format($row->grandTotal,'0',',','.'); ?></td>
            <td style="text-align:right;"><?php echo number_format($piutangTerbayar,'0',',','.'); ?></td>
            <td style="text-align:right;"><?php echo number_format($row->grandTotal-$piutangTerbayar,'0',',','.'); ?></td>
        </tr>
        <?php 
                $i++; 
                $totalPiutang = $totalPiutang+$row->grandTotal;
                $totalTerbayar = $totalTerbayar+$piutangTerbayar;
                $sisaPiutang = $sisaPiutang+($row->grandTotal-$piutangTerbayar);
            } 

        } else {
        ?>

        <tr>
            <td colspan="10">--Belum ada data--</td>
        </tr>

        <?php } ?>
    </tbody>
</table>

<table width="100%">
    <tr>
        <td width="90%" style="text-align:right;">Total Piutang</td>
        <td style="text-align:right;padding-right:10px;"><?php echo number_format($totalPiutang,'0',',','.'); ?></td>
    </tr>

    <tr>
        <td style="text-align:right;">Total Terbayar</td>
        <td style="text-align:right;padding-right:10px;border-bottom:solid 1px black;"><?php echo number_format($totalTerbayar,'0',',','.'); ?></td>
    </tr>

    <tr>
        <td style="text-align:right;font-weight:bold;">Total Sisa Piutang</td>
        <td style="text-align:right;font-weight:bold;padding-right:10px;"><?php echo number_format($sisaPiutang,'0',',','.'); ?></td>
    </tr>
</table>