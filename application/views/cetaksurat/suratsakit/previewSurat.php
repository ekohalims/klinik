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
        <td style="text-align:center;font-size:14px;font-weight:bold;text-decoration:underline;">Surat Keterangan Sakit</td>
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
        <td style="text-align:justify;">
            <br>
            <p>Yang bertanda tangan dibawah ini Dokter Pemeriksa <?php echo $header->namaKlinik; ?>, menerangkan bahwa :  </p>
            
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
                    <td>Alamat</td>
                    <td>:</td>
                    <td><?php echo $dataPasien->alamat." ".$dataPasien->rtrw.",".$dataPasien->kelurahan.",".$dataPasien->kecamatan.",".$dataPasien->nama_kabupaten.",".$dataPasien->nama_provinsi; ?></td>
                </tr>
            </table>
            
            <br>
            <p>Pada pemeriksaan kesehatan yang dilakukan pada <?php echo $tanggalIndonesia; ?>, maka dengan ini menyatakan yang bersangkutan dalam kondisi kurang sehat. Sehingga membutuhkan istirahat selama <?php echo $lamaHari; ?> hari terhitung dari <?php echo $tanggalIndonesia; ?> hingga <?php echo $tanggalAkhirIzin; ?>.</p>
            <table width="100%">
                <tr>
                    <td width="20%">Diagnosa penyakit</td>
                    <td width="2%">:</td>
                    <td>
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
            </table>
            <br>
            <p>Untuk itu, saudara dengan nama diatas tidak dapat melaksanakan kewajibannya sebagaimana biasanya. Demikian surat ini dibuat dan diberikan untuk dipergunakan sebagaimana mestinya. Terima kasih.</p>
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