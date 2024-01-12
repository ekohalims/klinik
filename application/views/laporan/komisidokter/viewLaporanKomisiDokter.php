<table width="100%">
    <tr style="border-bottom:solid 1px #ccc;">
        <td with="60%" style="font-size:14px;">
            <?php 
                echo "<b>".$header->namaKlinik."</b><br>";
                echo $header->alamat."<br>";
                echo "Telepon ".$header->telepon;
            ?>
        </td>
        <td style="text-align:right;vertical-align:bottom;font-weight:bold;">
            LAPORAN KOMISI DOKTER<br>
            <?php echo $periode; ?>

        </td>
    </tr>
</table>

<table width="100%" style="margin-top:20px;">
    <?php
        $grandTotal = 0;
        foreach($viewKomisiDokter->result() as $row){
    ?>
    <tr style="height:30px;border-bottom:solid 1px black;border-top:solid 2px #12a89d;"> 
        <td style="font-weight:bold;" colspan="2"><?php echo $row->namaTindakan; ?></td>
    </tr>

    <tr>
        <td colspan="2" style="padding-left:20px;padding-top:10px;padding-bottom:10px;">
            <table width='100%'>
                <tr style='font-weight:bold;'>
                    <td>No</td>
                    <td style="padding-right:2px;">No Pendaftaran</td>
                    <td style="padding-right:2px;">No Pasien</td>
                    <td style="padding-right:2px;">Nama Pasien</td>
                    <td style="padding-right:2px;">Nama Dokter</td>
                    <td style="padding-right:2px;">Tanggal</td>
                    <td style="text-align:right;">Komisi</td>
                </tr>

                <?php
                    $dataKomisi = $this->modelLaporan->dataKomisi($dateStart,$dateEnd,$dokter,$jenis,$row->idTindakan);

                    $x = 1;
                    $total = 0;
                    foreach($dataKomisi->result() as $dt){
                ?>
                <tr>
                    <td width="3%"><?php echo $x; ?></td>
                    <td width="16%" style="padding-right:2px;"><?php echo $dt->noPendaftaran; ?></td>
                    <td width="13%" style="padding-right:2px;"><?php echo $dt->noPasien; ?></td>
                    <td width="20%" style="padding-right:2px;"><?php echo $dt->namaPasien; ?></td>
                    <td width="25%" style="padding-right:2px;"><?php echo $dt->namaDokter; ?></td>
                    <td style="padding-right:2px;"><?php echo date_format(date_create($dt->tanggalDaftar),'d/m/y H:i'); ?></td>
                    <td style="text-align:right;" width="10%"><?php echo number_format($dt->komisi,'0',',','.'); ?></td>
                </tr>
                <?php $total = $total+$dt->komisi; $x++; } ?>

                <tr style='border-top:solid 1px grey;border-bottom:solid 1px grey;height:25px;'>
                    <td style='text-align:center;font-weight:bold;' colspan="6">TOTAL</td>
                    <td style="text-align:right;font-weight:bold;"><?php echo number_format($total,'0',',','.'); ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <?php $grandTotal = $grandTotal + $total; } ?>

    <tr style="font-size:14px;border-top:double;border-color:black;font-weight:bold;height:30px;vertical-align:middle;">
        <td width="90%" style="font-weight:bold;">GRAND TOTAL</td>
        <td style='text-align:right;font-weight:bold;'><?php echo number_format($grandTotal,'0',',','.'); ?></td>
    </tr>
</table>