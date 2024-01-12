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
                                <table width="100%" style="font-size:11px;">
                                    <tr>
                                        <td>
                                            <?php
                                                $interval = date_diff(date_create(date('Y-m-d')), date_create('2008-01-01'));
                                                $usia = $interval->format("%Y Thn, %M Bulan");
                                            ?>

                                            <u><b><?php echo $header->namaKlinik; ?></b> <br></u>
                                            <?php echo $pasien->namaLengkap; ?> <br>
                                            Tgl Lahir : <?php echo nice_date($pasien->tanggalLahir,'d/m/Y')." / ".$usia; ?> <br>
                                            <?php echo $pasien->noPasien; ?> / <?php if($pasien->jenisKelamin=='L'){echo "Laki-laki"; } else {echo "Perempuan";}?><br>
                                            
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
