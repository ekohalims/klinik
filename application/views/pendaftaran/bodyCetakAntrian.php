<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-success" id="cetakForm"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>

    <div class="row" style="margin-top:10px;">
        <div class="col-md-3">
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12" id="print-area">
                                <center>
                                    <table width="100%">
                                        <tr>
                                            <td align="center" style="font-size: 12px;font-weight: bold;"><?php echo $klinikInfo->namaKlinik; ?></td>
                                        </tr>

                                        <tr>
                                            <td align="center"><?php echo $klinikInfo->alamat; ?></td>
                                        </tr>

                                        <tr>
                                            <td align="center"><?php echo $klinikInfo->telepon; ?></td>
                                        </tr>
                                    </table>
                                    

                                    <table width="100%" style="margin-top: 5px;">
                                        <tr>
                                            <td width="50%">No SBPK</td>
                                            <td>:</td>
                                            <td><?php echo $dataDaftar->noPendaftaran; ?></td>
                                        </tr>

                                        <tr>
                                            <td>No Rekam Medis</td>
                                            <td>:</td>
                                            <td><?php echo $dataDaftar->noPasien; ?></td>
                                        </tr>

                                        <tr>
                                            <td>Nama</td>
                                            <td>:</td>
                                            <td><?php echo $dataDaftar->namaLengkap; ?></td>
                                        </tr>

                                        <tr>
                                            <td>Poliklinik</td>
                                            <td>:</td>
                                            <td><?php echo $dataDaftar->poliklinik; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="vertical-align: top;">Dokter</td>
                                            <td style="vertical-align: top;">:</td>
                                            <td><?php echo $dataDaftar->namaDokter; ?></td>
                                        </tr>

                                        <tr>
                                            <td>Tanggal</td>
                                            <td>:</td>
                                            <td><?php echo date_format(date_create($dataDaftar->tanggalDaftar),'d M Y H:i'); ?></td>
                                        </tr>
                                    </table>

                                    <table>
                                        <tr>
                                            <td style="text-align: center;font-size: 100px;font-weight: bold;">
                                                <?php
                                                    echo substr($dataDaftar->noPendaftaran, -3);
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /Portlet -->	
        </div>
    </div>
</div>
