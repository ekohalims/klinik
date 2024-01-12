<?php
    $i = 1;
    $numRows = $dataRiwayatBerobat->num_rows();

    if($numRows > 0){
    foreach($dataRiwayatBerobat->result() as $row){
?>

<tr>
    <td><?php echo $i; ?></td>
    <td><?php echo date_format(date_create($row->tanggalDaftar),'d M Y H:i'); ?></td>
    <td><?php echo $row->poliklinik; ?></td>
    <td><?php echo $row->namaDokter; ?></td>
    <td><?php echo $row->diagnosa; ?></td>
</tr>

<tr>
    <td colspan="5">
        <table style="width:100%;">
            <tr>
                <td width="20%" style="vertical-align:top;">Catatan</td>
                <td width="1%" style="vertical-align:top;">:</td>
                <td style="vertical-align:top;">
                    <?php
                        if(!empty($row->catatan)){
                            echo $row->catatan; 
                        } else {
                            echo "--Tidak Ada Catatan--";
                        }
                    ?>
                </td>
            </tr>

            <tr>
                <td style="vertical-align:top;">Riwayat Alergi</td>
                <td style="vertical-align:top;">:</td>
                <td style="vertical-align:top;">
                    <?php
                        if(!empty($row->riwayatAlergi)){
                            echo $row->riwayatAlergi; 
                        } else {
                            echo "--Tidak Ada Riwayat Alergi--";
                        }
                    ?>
                </td>
            </tr>

            <tr>
                <td style="vertical-align:top;">Laboratorium</td>
                <td style="vertical-align:top;">:</td>
                <td style="vertical-align:top;">
                    <?php
                        $lab = $this->modelAntrian->tampilkanCartLab($row->noPendaftaran);
                        $numRowsLab = $lab->num_rows();

                        if($numRowsLab < 1){
                            echo "--Tidak Ada Catatan Lab--";
                        } else {
                            foreach($lab->result() as $lb){
                                echo "<li>".$lb->namaLab."</li>";
                            }
                        }
                        
                    ?>
                </td>
            </tr>

            <tr>
                <td style="vertical-align:top;">Radiologi</td>
                <td style="vertical-align:top;">:</td>
                <td style="vertical-align:top;">
                    <?php
                        $rad = $this->modelAntrian->tampilkanCartRad($row->noPendaftaran);
                        $numRowsRad = $rad->num_rows();

                        if($numRowsRad < 1){
                            echo "--Tidak Ada Catatan Radiologi--";
                        } else {
                            foreach($rad->result() as $rd){
                                echo "<li>".$rd->namaRadiologi."</li>";
                            }
                        }
                        
                    ?>
                </td>
            </tr>

            <tr>
                <td style="vertical-align:top;">Resep</td>
                <td style="vertical-align:top;">:</td>
                <td style="vertical-align:top;">
                    <?php
                        $resep = $this->modelAntrian->tampilkanCartResep($row->noPendaftaran);
                        $numRowsResep = $resep->num_rows();

                        if($numRowsResep < 1){
                            echo "--Tidak Ada Catatan Resep--";
                        } else {
                            foreach($resep->result() as $rs){
                                echo "<li>".$rs->nama_produk." @".$rs->jumlah." ".$rs->satuan."</li>";
                            }
                        }
                    ?>
                </td>
            </tr>

            <tr>
                <td style="vertical-align:top;">Tindakan</td>
                <td style="vertical-align:top;">:</td>
                <td style="vertical-align:top;">
                    <?php
                        $tindakan = $this->modelAntrian->viewTindakanCart($row->noPendaftaran);
                        $numRowsTindakan = $tindakan->num_rows();

                        if($numRowsTindakan < 1){
                            echo "Tidak ada catatan tindakan--";
                        } else {
                            foreach($tindakan->result() as $td){
                                echo "<li>".$td->namaTindakan."</li>";
                            }
                        }
                    ?>
                </td>
            </tr>

            <tr>
                <td style="vertical-align:top;">Tindak Lanjut</td>
                <td style="vertical-align:top;">:</td>
                <td style="vertical-align:top;">
                    <?php
                        $cekTindakLanjutExist = $this->modelAntrian->cekTindakLanjutIfExist($row->noPendaftaran);

                        if($cekTindakLanjutExist > 0 ){
                            $tindakLanjut = $this->modelAntrian->currentTindakLanjut($row->noPendaftaran);
                            $idTindakLanjut = $tindakLanjut->idTindakLanjut;

                            if($idTindakLanjut==1){
                                echo "Kontrol Kembali Tanggal : ".$tindakLanjut->tanggalKontrol;
                            } elseif($idTindakLanjut==4){
                                echo "Rujuk <br> Spesialis : ".$tindakLanjut->spesialisRujuk." <br>Rumah Sakit / Klinik : ". $tindakLanjut->rumahSakit;
                            } else {
                                echo "";
                            }
                        } else {
                            echo "--Tidak ada catatan tindak lanjut--";
                        }
                    ?>
                </td>
            </tr>
        </table>
    </td>
</tr>

<?php $i++; } } else { ?>
<tr>
    <td colspan="5">--Belum ada riwayat berobat--</td>
</tr>
<?php } ?>