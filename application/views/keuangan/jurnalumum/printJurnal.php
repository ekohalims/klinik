<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
                <h3 class="title"><i class="fa fa-print"></i> Print Jurnal</h3> 
                <h6><a href="<?php echo base_url('jurnalUmum'); ?>">Jurnal Umum</a> / Print Jurnal</h6>
            </div>
        </div>

        <div class="col-md-6" style="text-align:right;">
            <a class='btn btn-success btn-rounded' onclick="printContent('printArea')"><i class='fa fa-print'></i> Print</a>
        </div>
    </div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body" id="printArea">
                <div class="row">
                    <div class="col-md-12">
                        <table width="100%">
                            <tr style="border-bottom:solid 1px #ccc;">
                                <td with="60%" style="font-size:14px;">
                                    <?php 
                                        echo "<b>".$header->namaKlinik."</b><br>";
                                        echo $header->alamat."<br>";
                                        echo "Telepon ".$header->telepon;
                                    ?>
                                </td>
                                <td style="text-align:right;vertical-align:bottom;font-weight:bold;">
                                    JURNAL UMUM<br>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row"> 
                    <div class="col-md-12">
                        <table width="100%">
                            <tr>
                                <td width="15%">No Transaksi</td>
                                <td widht="1%">:</td>
                                <td><?php echo $headerJurnal->noJurnalUmum; ?></td>
                            </tr>

                            <tr>
                                <td>Tanggal</td>
                                <td>:</td>
                                <td><?php echo date_format(date_create($headerJurnal->tanggal),'d/m/Y H:i'); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row" style="margin-top:20px;">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Akun</th>
                                    <th>Deskripsi</th>
                                    <th style="width:20%;text-align:right;">Debit</th>
                                    <th style="width:20%;text-align:right;">Kredit</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    $totalDebit = 0;
                                    $totalKredit = 0;
                                    foreach($jurnal as $row){
                                ?>
                                <tr>
                                    <td><?php echo $row->kodeAkun." - ".$row->namaAkun; ?></td>
                                    <td><?php echo $row->keterangan; ?></td>
                                    <td style="text-align:right;">
                                        <?php
                                            if($row->debit > 0){
                                                echo number_format($row->debit,'0',',','.');
                                            }
                                        ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php
                                            if($row->kredit > 0){
                                                echo number_format($row->kredit,'0',',','.');
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <?php $totalDebit = $totalDebit+$row->debit; $totalKredit=$totalKredit+$row->kredit;} ?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="2"><b>TOTAL</b></td>
                                    <td style="text-align:right;font-weight:bold;"><?php echo number_format($totalDebit,'0',',','.'); ?></td>
                                    <td style="text-align:right;font-weight:bold;"><?php echo number_format($totalKredit,'0',',','.'); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="row" style="margin-top:20px;">
                    <div class="col-md-12">
                        <table width="100%" border="1">
                            <tr>
                                <td width="25%" style="text-align:center;">Dibuat oleh</td>
                                <td width="25%" style="text-align:center;">Diperiksa oleh</td>
                                <td width="25%" style="text-align:center;">Disetujui oleh</td>
                                <td width="25%" style="text-align:center;">Diterima oleh</td>
                            </tr>

                            <tr style="height:50px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>
