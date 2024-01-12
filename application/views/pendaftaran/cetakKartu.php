<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-success" id="cetakForm"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>

    <div class="row" style="margin-top:10px;">
        <div class="col-md-4">
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12" id="print-area">
                             
                                <table width="100%">
                                        <tr>
                                            <td width="20%">
                                                <img src="<?php echo base_url('assets/'.$header->image); ?>" height="80px"/>
                                            </td>
                                            <td>
                                                <table width="100%">
                                                    <tr>
                                                        <td align="center" style="font-size: 14px;font-weight: bold;"><?php echo $header->namaKlinik; ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td align="center"><?php echo $header->alamat; ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td align="center"><?php echo $header->telepon; ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                </table>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <table width="100%">
                                    <tr>
                                        <td width="40%" style="font-size:16px;">
                                            <b><?php echo $pasien->noPasien; ?> <br>
                                            <?php echo $pasien->namaLengkap; ?> <br>
                                            <?php echo $pasien->alamat; ?> <br></b>
                                        </td>
                                        <td style="text-align:right;vertical-align:bottom;font-weight:bold;">
                                        <?php
                                                $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                                                echo '<img width="100px" height="40px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($pasien->noPasien, $generator::TYPE_CODE_128)) . '">';
                                            ?> <BR>

                                            Kartu Pasien / <i>Patien Card</i>
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
