<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
                <h3 class="title"><i class="fa fa-print"></i> Cetak Antrian</h3> 
            </div>
        </div>

        <div class="col-md-6" style="text-align: right;">
            <a class="btn btn-success btn-rounded" id="cetakForm"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>

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
                            

                            <table width="30%" style="margin-top: 5px;">
                                <tr>
                                    <td width="50%">No Pendaftaran</td>
                                    <td>:</td>
                                    <td><?php echo $dataDaftar->noPendaftaran; ?></td>
                                </tr>

                                <tr>
                                    <td>No RM</td>
                                    <td>:</td>
                                    <td><?php echo $dataDaftar->noPasien; ?></td>
                                </tr>

                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td><?php echo $dataDaftar->namaLengkap; ?></td>
                                </tr>

                                <tr>
                                    <td style="vertical-align: top;">Dokter PJB</td>
                                    <td style="vertical-align: top;">:</td>
                                    <td><?php echo $dataDaftar->namaDokter; ?></td>
                                </tr>

                                <tr>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td><?php echo date_format(date_create($dataDaftar->tanggalDaftar),'d M Y H:i'); ?></td>
                                </tr>

                                <tr>
                                    <td>Ruangan</td>
                                    <td>:</td>
                                    <td><?php echo $dataDaftar->namaRuang; ?></td>
                                </tr>
                            </table>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>
