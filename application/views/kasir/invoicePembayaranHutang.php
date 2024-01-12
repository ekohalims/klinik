<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
            	<h3 class="title"><i class="fa fa-file-word-o"></i> Invoice</h3> 
        	</div>
        </div>

        <div class="col-md-6" style="text-align: right;">
            <a class="btn btn-success btn-rounded" onclick="printContent('area-print')"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12">
                        <center>    
                            <table width="70%" id="area-print">
                                <tr>
                                    <td>
                                        <!-- header-->
                                        <table width="100%">
                                            <tr>
                                                <td width="70%" style="vertical-align: top;">
                                                    <table width="100%">
                                                        <tr>
                                                            <td style="text-align: left;font-size: 18px;font-weight: bold;"><?php echo $header->namaKlinik; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td style="text-align: left;"><?php echo $header->alamat; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td style="text-align: left;">Telp. <?php echo $header->telepon; ?></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <table width="100%">
                                                        <tr>
                                                            <td width="45%" style="font-weight: bold;">No Invoice</td>
                                                            <td width="2%">:</td>
                                                            <td><?php echo $dataOrder->noInvoice; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td style="font-weight: bold;">No Pendaftaran</td>
                                                            <td>:</td>
                                                            <td><?php echo $dataOrder->noPendaftaran; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td style="font-weight: bold;">No Pasien</td>
                                                            <td>:</td>
                                                            <td><?php echo $dataOrder->noPasien; ?></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- end header-->
                                        <table width="100%">
                                            <tr>
                                                <td style="border-top: solid 1px #ccc;"></td>
                                            </tr>
                                        </table>
                                        <!--info invoice-->
                                        <table width="100%" style="margin-top: 5px;">
                                            <tr>
                                                <td width="50%" style="vertical-align: top;">
                                                    <table width="100%">
                                                        <tr>
                                                            <td width="40%">Nama</td>
                                                            <td width="2%">:</td>
                                                            <td><?php echo $dataOrder->namaLengkap; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Alamat</td>
                                                            <td>:</td>
                                                            <td><?php echo $dataOrder->alamat; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Tanggal Daftar</td>
                                                            <td>:</td>
                                                            <td><?php echo date_format(date_create($dataOrder->tanggalDaftar),'d M Y H:i'); ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Tanggal Pembayaran</td>
                                                            <td>:</td>
                                                            <td><?php echo date_format(date_create($dataOrder->tanggalBayar),'d M Y H:i'); ?></td>
                                                        </tr>

                                                    </table>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <table width="100%">
                                                        <tr>
                                                            <td width="50%">Poli</td>
                                                            <td width="2%">:</td>
                                                            <td><?php echo $dataOrder->poliklinik; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Dokter</td>
                                                            <td>:</td>
                                                            <td><?php echo $dataOrder->namaDokter; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Penanggung</td>
                                                            <td>:</td>
                                                            <td><?php echo $dataOrder->layanan; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Jenis Pembayaran / Jatuh Tempo</td>
                                                            <td>:</td>
                                                            <td><?php echo $dataOrder->payment_type." ".$dataOrder->account; ?> / <?php echo date_format(date_create($jatuhTempo),'d M Y'); ?></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <!--end info invoice-->

                                        <table width="100%">
                                            <tr>
                                                <td style="border-top: solid 1px #ccc;"></td>
                                            </tr>
                                        </table>

                                        <table style="margin-top: 5px;" width="100%"> 
                                            <!-- TAB KAMAR-->

                                            <?php
                                                if($mode=='rekap'){
                                            ?>
                                                    <?php 
                                                        if($asalDaftar=='RANAP'){
                                                    ?>  
                                                        <tr>
                                                            <td width="83%">Biaya Kamar</td>
                                                            <td width="1%">Rp. </td>
                                                            <td style="text-align:right;"><?php echo number_format($totalKamar,'0',',','.'); ?></td>
                                                        </tr>
                                                    <?php
                                                        }
                                                    ?>
                                                    
                                                    <?php 

                                                        $numRowsTindakan = $tindakan->num_rows();
                                                                                            
                                                        if($numRowsTindakan > 0){
                                                    ?>
                                                        <tr>
                                                            <td>Pelayanan</td>
                                                            <td>Rp</td>
                                                            <td style="text-align:right;"><?php echo number_format($totalTindakan,'0',',','.'); ?></td>
                                                        </tr>  
                                                    <?php } ?>

                                                    <?php
                                                        $numRowsFarmasi = $farmasi->num_rows();

                                                        if($numRowsFarmasi > 0){
                                                    ?>

                                                        <tr>
                                                            <td>Obat-obatan</td>
                                                            <td>Rp</td>
                                                            <td style="text-align:right;"><?php echo number_format($totalObat,'0',',','.'); ?></td>
                                                        </tr>  
                                                    <?php } ?>

                                                    <?php
                                                        $numRowsLaboratorium = $laboratorium->num_rows();

                                                        if($numRowsLaboratorium > 0){
                                                    ?>
                                                        <tr>
                                                            <td>Laboratorium</td>
                                                            <td>Rp</td>
                                                            <td style="text-align:right;"><?php echo number_format($totalLab,'0',',','.'); ?></td>
                                                        </tr>  
                                                    <?php } ?>

                                                    <?php
                                                        $numRowsRadiologi = $radiologi->num_rows();

                                                        if($numRowsRadiologi > 0){
                                                    ?>
                                                        <tr>
                                                            <td>Radiologi</td>
                                                            <td>Rp</td>
                                                            <td style="text-align:right;"><?php echo number_format($totalRad,'0',',','.'); ?></td>
                                                        </tr>  
                                                    <?php } ?>
                                            <?php
                                                } else {
                                            ?>
                                            <?php 
                                                if($asalDaftar=='RANAP'){
                                            ?>
                                                <tr>
                                                    <td colspan="3" style="font-weight: bold;">Biaya Kamar</td>
                                                </tr>
                                                
                                                <?php
                                                    foreach($kamarPasien as $km){
                                                ?>
                                                <tr>
                                                    <td style="padding-left: 30px;" width="83%">
                                                        <?php 
                                                            echo $km->namaRuang."<br>"; 
                                                            echo "&nbsp &nbsp<b>".$km->lamaHari." Hari</b>";
                                                        ?>
                                                    </td>
                                                    <td width="1%" style="vertical-align: bottom;">Rp.</td>
                                                    <td style="vertical-align: bottom;text-align: right;">
                                                        <?php echo number_format($km->totalTarif,'0',',','.'); ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            <?php
                                                }
                                            ?>
                                            <!-- end kamar-->

                                             <!--tab tindakan-->
                                            <?php
                                                $numRowsTindakan = $tindakan->num_rows();
                                            
                                                if($numRowsTindakan > 0){
                                            ?>

                                                <tr>
                                                    <td colspan="3" style="font-weight: bold;">Biaya Pelayanan</td>
                                                </tr>

                                                <?php
                                                    foreach($tindakan->result() as $td){
                                                ?>

                                                <tr>
                                                    <td style="padding-left: 30px;" width="83%"><?php echo $td->namaTindakan." x".$td->qty; ?></td>
                                                    <td width="1%">Rp.</td>
                                                    <td style="text-align: right;"><?php echo number_format($td->harga,'0',',','.'); ?></td>
                                                </tr>

                                                <?php } ?>

                                            <?php } ?>
                                            <!--end tindakan-->

                                            <!--farmasi-->
                                            <?php
                                                $numRowsFarmasi = $farmasi->num_rows();

                                                if($numRowsFarmasi > 0){
                                            ?>

                                                <tr>
                                                    <td colspan="3" style="font-weight: bold;">Biaya Obat-obatan</td>
                                                </tr>

                                                <?php
                                                    foreach($farmasi->result() as $fm){
                                                ?>

                                                <tr>
                                                    <td style="padding-left: 30px;">
                                                        <?php 
                                                            echo $fm->nama_produk."<br>";
                                                            echo $fm->jumlah." x ".number_format($fm->harga,'0',',','.'); 
                                                        ?>
                                                    </td>
                                                    <td style="vertical-align: bottom;">Rp.</td>
                                                    <td style="vertical-align: bottom;text-align: right;"><?php echo number_format($fm->harga*$fm->jumlah,'0',',','.'); ?></td>
                                                </tr>
                                                <?php } ?>

                                            <?php } ?>
                                            <!--end farmasi-->

                                            <!-- Laboratorium-->
                                            <?php
                                                $numRowsLaboratorium = $laboratorium->num_rows();

                                                if($numRowsLaboratorium > 0){
                                            ?>
                                                <tr>
                                                    <td colspan="3" style="font-weight: bold;">Laboratorium</td>
                                                </tr>

                                                <?php
                                                    foreach($laboratorium->result() as $lb){
                                                ?>
                                                <tr>
                                                    <td style="padding-left: 30px;"><?php echo $lb->namaLab; ?></td>
                                                    <td>Rp.</td>
                                                    <td style="text-align: right;"><?php echo number_format($lb->harga,'0',',','.'); ?></td>
                                                </tr>
                                                <?php } ?>
                                            <?php } ?>
                                            <!--end laboratorium-->

                                            <!--radiologi-->
                                            <?php
                                                $numRowsRadiologi = $radiologi->num_rows();

                                                if($numRowsRadiologi > 0){
                                            ?>

                                                <tr>
                                                    <td colspan="3" style="font-weight: bold;">Radiologi</td>
                                                </tr>

                                                <?php
                                                    foreach($radiologi->result() as $rd){
                                                ?>
                                                <tr>
                                                    <td style="padding-left: 30px;"><?php echo $rd->namaRadiologi; ?></td>
                                                    <td>Rp.</td>
                                                    <td style="text-align: right;"><?php echo number_format($rd->harga,'0',',','.'); ?></td>
                                                </tr>
                                                <?php } ?>

                                            <?php } ?>
                                            <!--end radiologi-->

                                            <?php } ?>

                                            <tr style="border-top: solid 1px #ccc;">
                                                <td style="text-align: center;font-size: 13px;"><b>TOTAL</b></td>
                                                <td>Rp.</td>
                                                <td style="text-align: right;font-weight: bold;font-size: 13px; ">
                                                    <?php
                                                        echo number_format($total,'0',',','.');
                                                    ?>
                                                </td>
                                            </tr>
                                        </table>
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

