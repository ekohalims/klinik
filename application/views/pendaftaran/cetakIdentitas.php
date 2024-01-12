<div id="CssLoader" style="display: none;">
    <div class='spinftw'></div>
</div>

<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-4" style="text-align:right;">
            <a class="btn btn-success" id="cetakForm"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>

    <div class="row" style="margin-top:10px;">
        <div class="col-md-8 col-md-offset-2">
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12" id="print-area">
                                <table width="100%">
                                    <tr style="border-bottom:solid 2px black;border-collapse:collapse;border:1;">
                                        <td> <!--header sjp-->
                                            <table width="100%">
                                                <tr>
                                                    <td style="vertical-align:top;" width="20%"><img src="<?php echo base_url('assets/'.$header->image); ?>" height="80px"/></td>
                                                    <td style="vertical-align:middle;text-align:center;">
                                                        <span style="font-weight:bold;font-size:15px;"><?php echo $header->namaKlinik; ?></span>
                                                        <p>
                                                            <?php echo $header->alamat; ?> <br>
                                                            Provinsi <?php echo $header->nama_provinsi; ?> Telp. <?php echo $header->telepon; ?>
                                                        </p>
                                                    </td>
                                                    <td width="20%" style="text-align:right;"><img src="<?php echo base_url('assets/dinkes.png'); ?>" height="80px"/></td>
                                                </tr>
                                            </table>
                                        </td> <!-- end header sjp-->
                                    </tr>

                                    <tr>
                                        <td style="text-align:center;">
                                            IDENTITAS PASIEN / <br>
                                            NEW PATIENT REGISTRATION DATA <br>
                                            <?php echo $headerSJP->noPendaftaran; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="text-align:right;">
                                            NRM : <b><?php echo $headerSJP->idPasien; ?></b>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                            <table width="100%">
                                                <tr>
                                                    <td width="30%" style="vertical-align:top;"><u>Nama Pasien</u> <br> <i>Patient Name</i></td>
                                                    <td width="1%" style="vertical-align:top;">:</td>
                                                    <td style="vertical-align:top;"><?php echo $headerSJP->namaLengkap; ?></td>
                                                </tr>

                                                <tr>
                                                    <td style="vertical-align:top;"><u>Nama Keluarga / Ayah / Suami</u> <br> <i>Family Name</i></td>
                                                    <td style="vertical-align:top;">:</td>
                                                    <td style="vertical-align:top;"><?php echo $headerSJP->namaKeluarga; ?></td>
                                                </tr>

                                                <tr>
                                                    <td style="vertical-align:top;"><u>Tempat / Tgl Lahir Pasien *</u> <br> <i>Place / Date of Birth</i></td>
                                                    <td style="vertical-align:top;">:</td>
                                                    <td style="vertical-align:top;"><?php echo $headerSJP->tempatLahir." / ".nice_date($headerSJP->tanggalLahir,'d-m-Y'); ?></td>
                                                </tr>

                                                <tr>
                                                    <td style="vertical-align:top;"><u>No Identitas/KTP/Paspor/SIM</u> <br> <i>ID Number</i></td>
                                                    <td style="vertical-align:top;">:</td>
                                                    <td style="vertical-align:top;"><?php echo $headerSJP->noID; ?></td>
                                                </tr>

                                                <tr>
                                                    <td style="vertical-align:top;"><u>Jenis Kelamin</u> <br> <i>Sex</i></td>
                                                    <td style="vertical-align:top;">:</td>
                                                    <td style="vertical-align:top;"><?php echo $headerSJP->jenisKelamin; ?></td>
                                                </tr>

                                                <tr>
                                                    <td style="vertical-align:top;"><u>Pekerjaan</u> <br> <i>Current Employment</i></td>
                                                    <td style="vertical-align:top;">:</td>
                                                    <td style="vertical-align:top;"><?php echo $headerSJP->pekerjaan; ?></td>
                                                </tr>

                                                <tr>
                                                    <td style="vertical-align:top;"><u>Alamat Domisili</u> <br> <i>Current Home Address</i></td>
                                                    <td style="vertical-align:top;">:</td>
                                                    <td style="vertical-align:top;"><?php echo $headerSJP->alamat; ?>, Provinsi <?php echo $headerSJP->nama_provinsi; ?>, Kab. <?php echo $headerSJP->nama_kabupaten; ?>, Kec. <?php echo $headerSJP->kecamatan; ?></td>
                                                </tr>

                                                <tr>
                                                    <td style="vertical-align:top;"><u>Email</u> <br> <i>Email Adress</i></td>
                                                    <td style="vertical-align:top;">:</td>
                                                    <td style="vertical-align:top;"><?php echo $headerSJP->email; ?></td>
                                                </tr>

                                                <tr>
                                                    <td style="vertical-align:top;"><u>Status Perkawinan</u> <br> <i>Marital Status</i></td>
                                                    <td style="vertical-align:top;">:</td>
                                                    <td style="vertical-align:top;"><?php echo $headerSJP->kawin; ?></td>
                                                </tr>

                                                <tr>
                                                    <td style="vertical-align:top;"><u>Agama</u> <br> <i>Religion</i></td>
                                                    <td style="vertical-align:top;">:</td>
                                                    <td style="vertical-align:top;"><?php echo $headerSJP->agama; ?></td>
                                                </tr>

                                                <tr>
                                                    <td style="vertical-align:top;"><u>Telepon Rumah *</u> <br> <i>HP / Mobile Phone</i></td>
                                                    <td style="vertical-align:top;">:</td>
                                                    <td style="vertical-align:top;"><?php echo $headerSJP->noHP; ?></td>
                                                </tr>

                                                <tr>
                                                    <td style="vertical-align:top;"><u>Pendidikan</u> <br> <i>Education</i></td>
                                                    <td style="vertical-align:top;">:</td>
                                                    <td style="vertical-align:top;"><?php echo $headerSJP->pendidikan; ?></td>
                                                </tr>

                                                <tr>
                                                    <td style="vertical-align:top;"><u>Nama & Hub dengan pasien</u> <br> <i>Name of responsible person</i></td>
                                                    <td style="vertical-align:top;">:</td>
                                                    <td style="vertical-align:top;"></td>
                                                </tr>

                                                <tr>
                                                    <td style="vertical-align:top;"><u>Kewarnegaraan</u> <br> <i>Nationality</i></td>
                                                    <td style="vertical-align:top;">:</td>
                                                    <td style="vertical-align:top;"></td>
                                                </tr>

                                                <tr>
                                                    <td style="vertical-align:top;"><u>Jenis Pembayaran</u> <br> <i>Payment</i></td>
                                                    <td style="vertical-align:top;">:</td>
                                                    <td style="vertical-align:top;"><?php echo $headerSJP->layanan." ".$headerSJP->namaAsuransi; ?></td>
                                                </tr>

                                                <tr>
                                                    <td style="vertical-align:top;"><u>Klinik yang dituju</u> <br> <i>Visiting Clinic</i></td>
                                                    <td style="vertical-align:top;">:</td>
                                                    <td style="vertical-align:top;"><?php echo $headerSJP->poliklinik; ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="padding-top:10px;">
                                            <table width="100%">
                                                <tr style='text-align:center;'>
                                                    <td width="50%">Pasien, Orang Tua / Keluarga</td>
                                                    <td>Petugas Skrining</td>
                                                </tr>

                                                <tr style='text-align:center;height:150px;'>
                                                    <td width="50%">Tata tertib/Hak & kewajiban pasien diserahkan kepada pasien / keluarga</td>
                                                    <td>
                                                        <?php
                                                            echo $headerSJP->first_name." ".$headerSJP->last_name; 
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /Portlet -->
        </div>
    </div>	
</div>

