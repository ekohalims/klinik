<table width="100%">
    <tr style="border-bottom:solid 1px #ccc;">
        <td style="font-size:14px;text-align:center;">
            <?php 
                echo "<b>".$header->namaKlinik."</b><br>";
                echo $header->alamat."<br>";
                echo "Telepon ".$header->telepon;
            ?>
        </td>
    </tr>

    <tr>
        <td style="text-align:center;font-size:14px;font-weight:bold;text-decoration:underline;">Surat Rujukan</td>
    </tr>

    <tr>
        <td style="text-align:center;">
            <table width="100%">
                <tr>
                    <td>Nomor : <?php echo $noPendaftaran; ?></td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td>
            <p>Kepada yang terhormat.</p>
            <table width="100%">
                <tr>
                    <td width="20%">TS dr. Poli</td>
                    <td width="2%">:</td>
                    <td><?php echo $tujuanRujukan->spesialisRujuk; ?></td>
                </tr>

                <tr>
                    <td width="20%">Di RSU</td>
                    <td width="2%">:</td>
                    <td><?php echo $tujuanRujukan->rumahSakit; ?></td>
                </tr>
            </table>

            <br>
            <p>Mohon pemeriksaan dan penanganan lebih lanjut penderita :</p>
            
            <table width="100%">
                <tr>
                    <td width="20%">Nama</td>
                    <td width="2%">:</td>
                    <td><?php echo $dataPasien->namaLengkap; ?></td>
                </tr>

                <tr>
                    <td>Umur</td>
                    <td>:</td>
                    <td><?php echo $umur; ?> Tahun</td>
                </tr>

                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td><?php echo $dataPasien->jenisKelamin; ?></td>
                </tr>

                <tr>
                    <td>Pekerjaan</td>
                    <td>:</td>
                    <td><?php echo $dataPasien->pekerjaan; ?></td>
                </tr>

                <tr>
                    <td style="vertical-align:top;">Alamat</td>
                    <td style="vertical-align:top;">:</td>
                    <td style="vertical-align:top;"><?php echo $dataPasien->alamat." ".$dataPasien->rtrw.",".$dataPasien->kelurahan.",".$dataPasien->kecamatan.",".$dataPasien->nama_kabupaten.",".$dataPasien->nama_provinsi; ?></td>
                </tr>

                <tr>
                    <td style="vertical-align:top;">Diagnosa</td>
                    <td style="vertical-align:top;">:</td>
                    <td style="vertical-align:top;">
                        <?php
                            $numRowsDiagnosa = $diagnosaPenyakit->num_rows();

                            if($numRowsDiagnosa > 0){
                                foreach($diagnosaPenyakit->result() as $row){
                                    echo "<li>".$row->CODE." - ".$row->STR."</li>";
                                }
                            } else {
                                echo "-";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align:top;">Telah diberikan</td>
                    <td style="vertical-align:top;">:</td>
                    <td style="vertical-align:top;">
                        <?php
                            $numRowsObat = $obat->num_rows();

                            if($numRowsObat > 0) {
                                foreach($obat->result() as $dt){
                                    echo "<li>".$dt->nama_produk."</li>";
                                }
                            } else {    
                                echo "-";
                            }
                        ?>
                    </td>
                </tr>
            </table>
            <br>
            <p>Demikian atas bantunnya, kami ucapkan terima kasih.</p>
        </td>
    </tr>

    <tr style="height:80px;text-align:right;">
        <td>
            <?php echo $kecamatanKlinik.",".date_format(date_create($tanggal),'d F Y'); ?> 
        </td>
    </tr>

    <tr style="height:70px;text-align:right;">
        <td>
            <?php echo $dokter->nama; ?><br>
            NIP. <?php echo $dokter->noIzinPraktek; ?>
        </td>
    </tr>
</table>