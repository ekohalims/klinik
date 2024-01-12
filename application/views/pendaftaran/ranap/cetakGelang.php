<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-success" id="cetakForm"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>

    <div class="row" style="margin-top:10px;">
        <div class="col-md-2">
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12" id="print-area">
                                <table width="100%" style="font-size:11px;">
                                    <tr>
                                        <td>
                                            <b><?php echo $header->namaKlinik; ?></b> <br>
                                            <?php echo $pasien->namaLengkap; ?> <br>
                                            <?php echo $pasien->noPasien; ?> <br>
                                            Tgl Lahir. <?php echo nice_date($pasien->tanggalLahir,'d/m/Y'); ; ?> <br>
                                            
                                        </td>

                                        <td style='text-align:right;vertical-align:middle;'>
                                            <?php
                                                $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                                                echo '<img width="60px" height="40px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($pasien->noPasien, $generator::TYPE_CODE_128)) . '">';
                                            ?>
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
