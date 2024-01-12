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
                                    <tr>
                                        <td colspan="2"> <!--header sjp-->
                                            <table width="100%">
                                                <tr style="font-size:15px;font-weight:bold;">
                                                    <td  style="vertical-align:top;" width="10%"><img src="<?php echo base_url('assets/'.$header->image); ?>" height="80px"/></td>
                                                    <td style="vertical-align:middle;">SURAT BUKTI PELAYANAN (SBP) <br> IGD</td>
                                                    <td style="vertical-align:middle;"><?php echo $headerSJP->layanan." ".$headerSJP->namaAsuransi; ?></td>
                                                </tr>
                                            </table>
                                        </td> <!-- end header sjp-->
                                    </tr>

                                    <tr> <!-- header title sjp-->
                                        <td width="50%" style="vertical-align:top;padding-top:5px;">
                                            <table width="100%">
                                                <tr>
                                                    <td width="30%">No SEP</td>
                                                    <td width="1%">:</td>
                                                    <td>
                                                        <?php
                                                            if($headerSJP->layanan=='BPJS'){ 
                                                                echo $headerSJP->noKartu; 
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Tanggal SJP</td>
                                                    <td>:</td>
                                                    <td><?php echo nice_date($headerSJP->tanggalDaftar,'d/m/Y'); ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Asal Rujukan</td>
                                                    <td>:</td>
                                                    <td><?php echo $headerSJP->asalRujukan; ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Diagnosa Awal</td>
                                                    <td>:</td>
                                                    <td><?php echo $headerSJP->keluhan; ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Poli Tujuan</td>
                                                    <td>:</td>
                                                    <td><?php echo $headerSJP->poliklinik; ?></td>
                                                </tr>

                                                <tr>
                                                    <td>DPJP</td>
                                                    <td>:</td>
                                                    <td><?php echo $headerSJP->namaDokter; ?></td>
                                                </tr>
                                            </table>
                                        </td>

                                        <td style="padding-top:5px;">
                                            <table width="100%">
                                                <tr>
                                                    <td width="30%">No SJP</td>
                                                    <td width="1%">:</td>
                                                    <td><?php echo $headerSJP->noPendaftaran; ?></td>
                                                </tr>

                                                <tr>
                                                    <td>No Medrec</td>
                                                    <td>:</td>
                                                    <td><?php echo $headerSJP->idPasien; ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Nama Pasien</td>
                                                    <td>:</td>
                                                    <td><?php echo $headerSJP->namaLengkap; ?></td>
                                                </tr>

                                                <tr>
                                                    <td>No Kartu</td>
                                                    <td>:</td>
                                                    <td>
                                                        <?php
                                                            if($headerSJP->layanan!='BPJS'){ 
                                                                echo $headerSJP->noKartu; 
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Jenis Kelamin</td>
                                                    <td>:</td>
                                                    <td><?php echo $headerSJP->jenisKelamin; ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Tanggal Lahir</td>
                                                    <td>:</td>
                                                    <td><?php echo nice_date($headerSJP->tanggalLahir,'d/m/Y'); ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Operator</td>
                                                    <td>:</td>
                                                    <td><?php echo $headerSJP->first_name." ".$headerSJP->last_name; ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Alamat</td>
                                                    <td>:</td>
                                                    <td><?php echo $headerSJP->alamat; ?></td>
                                                </tr>

                                                <tr>
                                                    <td>No Telpon</td>
                                                    <td>:</td>
                                                    <td><?php echo $headerSJP->noHP; ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    
                                    <tr> <!-- anamnesis dan pemeriksaan fisik-->
                                        <td colspan="2">
                                            Anamnesis dan Pemeriksaan Fisik (Tanda-tanda vital)
                                            <hr>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <hr>
                                        </td>
                                    </tr> <!-- end anamnesis dan pemeriksaan fisik-->
                                    
                                    <tr> <!--penunjang tindakan-->
                                        <td style="padding-top:10px;" colspan="2">
                                            <table width="100%">
                                                <tr>
                                                    <td width="20%">Penunjang</td>
                                                    <td>
                                                        1. <img src="<?php echo base_url('assets/box.png'); ?>" height="25px"/> LAB &nbsp
                                                        2. <img src="<?php echo base_url('assets/box.png'); ?>" height="25px"/> ECHO &nbsp
                                                        3. <img src="<?php echo base_url('assets/box.png'); ?>" height="25px"/> USG &nbsp
                                                        4. <img src="<?php echo base_url('assets/box.png'); ?>" height="25px"/> Treadmil &nbsp
                                                        5. <img src="<?php echo base_url('assets/box.png'); ?>" height="25px"/> Fisioterapi &nbsp
                                                        6. <img src="<?php echo base_url('assets/box.png'); ?>" height="25px"/> ... &nbsp
                                                    </td>
                                                </tr>

                                                <tr style="height:40px;">
                                                    <td style="vertical-align:top;" width="20%">DIAGNOSA UTAMA</td>
                                                    <td>
                                                        <table width="100%">
                                                            <tr style="height:40px;">
                                                                <td style="border:solid 1px black;vertical-align:top;"></td>
                                                                <td style="border:solid 1px black;vertical-align:top;" width="20%">ICD 10 :</td>
                                                                <td style="border:solid 1px black;vertical-align:top;" width="20%">PDokter : </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>

                                                <tr style="height:40px;">
                                                    <td style="vertical-align:top;padding-top:5px;">DIAGNOSA SEKUNDER</td>
                                                    <td style="vertical-align:top;padding-top:5px;">
                                                        <table width="100%">
                                                            <tr style="height:40px;">
                                                                <td style="border:solid 1px black;vertical-align:top;"></td>
                                                                <td style="border:solid 1px black;vertical-align:top;" width="20%">ICD 10 :</td>
                                                                <td style="border:solid 1px black;vertical-align:top;" width="20%">PDokter : </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>

                                                <tr style="height:40px;">
                                                    <td style="vertical-align:top:padding-top:5px;">TINDAKAN</td>
                                                    <td style="vertical-align:top;padding-top:5px;">
                                                        <table width="100%">
                                                            <tr style="height:40px;">
                                                                <td style="border:solid 1px black;vertical-align:top;"></td>
                                                                <td style="border:solid 1px black;vertical-align:top;" width="20%">ICD 9 :</td>
                                                                <td style="border:solid 1px black;vertical-align:top;" width="20%">PDokter : </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr> <!-- tanda tangan-->
                                        <td colspan="2" style='padding-top:10px;'>
                                            <table width="100%">
                                                <tr style="height:50px;">
                                                    <td width="33%" style="text-align:center;vertical-align:top;">Pasien / Keluarga</td>
                                                    <td width="33%" style="text-align:center;vertical-align:top;">Operator</td>
                                                    <td width="33%" style="text-align:center;vertical-align:top;">DPJP</td>
                                                </tr>

                                                <tr>
                                                    <td width="33%" style="text-align:center;"></td>
                                                    <td width="33%" style="text-align:center;"><?php echo $headerSJP->first_name." ".$headerSJP->last_name; ?></td>
                                                    <td width="33%" style="text-align:center;"><?php echo $headerSJP->namaDokter; ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" style="font-weight:bold;font-size:13px;">BERKAS TIDAK DIBAWA PULANG</td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <B>RESEP PASIEN</b>
                                            <table width="100%">
                                                <tr>
                                                    <td width="20%">NO SJP</td>
                                                    <td width="1%">:</td>
                                                    <td><b><?php echo $headerSJP->noPendaftaran; ?></b></td>
                                                </tr>

                                                <tr>
                                                    <td>TGL SJP</td>
                                                    <td>:</td>
                                                    <td><?php echo nice_date($headerSJP->tanggalDaftar,'d/m/Y'); ?></td>
                                                </tr>

                                                <tr>
                                                    <td>No Resep</td>
                                                    <td>:</td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td>R/</td>
                                                    <td></td>
                                                    <td>Nama Obat</td>
                                                </tr>

                                                <tr style="height:20px;">
                                                    <td></td>
                                                    <td></td>
                                                    <td>R/.....</td>
                                                </tr>

                                                <tr style="height:20px;">
                                                    <td></td>
                                                    <td></td>
                                                    <td>R/.....</td>
                                                </tr>

                                                <tr style="height:20px;">
                                                    <td></td>
                                                    <td></td>
                                                    <td>R/.....</td>
                                                </tr>

                                                <tr style="height:20px;">
                                                    <td></td>
                                                    <td></td>
                                                    <td>R/.....</td>
                                                </tr>

                                                <tr style="height:20px;">
                                                    <td></td>
                                                    <td></td>
                                                    <td>R/.....</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td style="vertical-align:top;">
                                            <table width="100%">
                                                <tr>
                                                    <td>Poli</td>
                                                    <td width="1%">:</td>
                                                    <td><b><?php echo $headerSJP->poliklinik; ?></b></td>
                                                </tr>

                                                <tr>
                                                    <td>Nama Pasien</td>
                                                    <td>:</td>
                                                    <td><?php echo $headerSJP->namaLengkap; ?></td>
                                                </tr>

                                                <tr>
                                                    <td>No Medrec</td>
                                                    <td>:</td>
                                                    <td><?php echo $headerSJP->idPasien; ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Tanggal Lahir</td>
                                                    <td>:</td>
                                                    <td><?php echo nice_date($headerSJP->tanggalLahir,'d/m/Y'); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr> <!-- tanda tangan-->
                                        <td colspan="2" style='padding-top:10px;'>
                                            <table width="100%">
                                                <tr style="height:50px;">
                                                    <td width="33%" style="text-align:center;vertical-align:top;">Pasien / Keluarga</td>
                                                    <td width="33%" style="text-align:center;vertical-align:top;">Operator</td>
                                                    <td width="33%" style="text-align:center;vertical-align:top;">DPJP</td>
                                                </tr>

                                                <tr>
                                                    <td width="33%" style="text-align:center;"></td>
                                                    <td width="33%" style="text-align:center;"><?php echo $headerSJP->first_name." ".$headerSJP->last_name; ?></td>
                                                    <td width="33%" style="text-align:center;"><?php echo $headerSJP->namaDokter; ?></td>
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

