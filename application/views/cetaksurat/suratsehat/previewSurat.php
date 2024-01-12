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
        <td style="text-align:center;font-size:14px;font-weight:bold;text-decoration:underline;">Surat Keterangan Sehat</td>
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
            <p>Bahwa pada pemeriksaan jasmani dalam keadaan sehat. Berikut hasil pemeriksaannya :</p>
        
            <table width="100%">
                <tr>
                    <td width="20%">Tinggi Badan</td>
                    <td width="2%">:</td>
                    <td><?php echo $hasilPemeriksaan->tinggiBadan; ?> Cm</td>
                </tr>

                <tr>
                    <td>Berat Badan</td>
                    <td>:</td>
                    <td><?php echo $hasilPemeriksaan->beratBadan; ?> Kg</td>
                </tr>

                <tr>
                    <td>Tekanan Darah</td>
                    <td>:</td>
                    <td><?php echo $hasilPemeriksaan->tekananDarah; ?> MmHg</td>
                </tr>

                <tr>
                    <td>Golongan Darah</td>
                    <td>:</td>
                    <td><?php echo $dataPasien->golonganDarah; ?></td>
                </tr>

                <tr>
                    <td>Buta Warna</td>
                    <td>:</td>
                    <td><?php echo $hasilPemeriksaan->butaWarna; ?></td>
                </tr>

                <tr>
                    <td>Cacat Badan</td>
                    <td>:</td>
                    <td><?php echo $hasilPemeriksaan->cacatBadan; ?></td>
                </tr>
            </table>
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