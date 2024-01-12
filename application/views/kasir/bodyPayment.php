<div id="CssLoader" style="display: none;">
    <div class='spinftw'></div>
</div>

<div class="wraper container-fluid">
    <div class="page-title"> 
    	<h3 class="title"><i class="fa fa-money"></i> Payment</h3> 
	</div>

    <div id="payment_total_notif" style="width: 350px;position: fixed;z-index: 1;left: 8px;top:8px;display: none;" >
        <div class="alert alert-danger" style="opacity: 0.9;">
            <table width="100%" style="font-size: 18px;">
                <tr>
                    <td width="50%">Grand Total</td>
                    <td align="right" id="totalKeseluruhan"></td>
                </tr>

                <tr>
                    <td width="50%">Jumlah Bayar</td>
                    <td align="right" id="jumlahBayarNotif"></td>
                </tr>

                <tr>
                    <td width="50%">Kembali</td>
                    <td align="right" id="kembaliNotif"></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-3">
                        <div style="font-weight:bold;font-size: 14px;border-bottom: solid 1px #dfdfdf;margin-bottom: 5px;"><i class="fa fa-user"></i> Data Pasien </div>
                        <table width="100%" style="font-size: 13px;">
                            <tr>
                                <td width="40%">No Pendaftaran</td>
                                <td width="2%">:</td>
                                <td><?php echo $dataOrder->noPendaftaran; ?></td>
                            </tr>

                            <tr>
                                <td>No KTP</td>
                                <td>:</td>
                                <td><?php echo $dataOrder->noID; ?></td>
                            </tr>

                            <tr>
                                <td>No RM</td>
                                <td>:</td>
                                <td><?php echo $dataOrder->noPasien; ?></td>
                            </tr>

                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td><?php echo $dataOrder->namaLengkap; ?></td>
                            </tr>

                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td style="vertical-align: top;"><?php echo $dataOrder->alamat; ?></td>
                            </tr>

                            <tr>
                                <td>Kontak</td>
                                <td>:</td>
                                <td><?php echo $dataOrder->noHP; ?></td>
                            </tr>

                            <tr>
                                <td>Tanggal Datang</td>
                                <td>:</td>
                                <td style="vertical-align: top;"><?php echo date_format(date_create($dataOrder->tanggalDaftar),'d M Y H:i'); ?></td>
                            </tr>

                            <tr>
                                <td style="vertical-align: top;">Dokter</td>
                                <td style="vertical-align: top;">:</td>
                                <td><?php echo $dataOrder->namaDokter; ?></td>
                            </tr>

                            <tr>
                                <td>Poli</td>
                                <td>:</td>
                                <td><?php echo $dataOrder->poliklinik; ?></td>
                            </tr>

                            <tr>
                                <td>Penanggung</td>
                                <td>:</td>
                                <td><?php echo $dataOrder->layanan; ?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <div style="font-size: 14px;font-weight:bold;"><i class="fa fa-list"></i> Daftar Biaya </div>
                        <div style="border:solid 1px #ccc;padding: 10px;">
                            <table width="100%">
                                <!-- TAB KAMAR-->
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
                                        <td><?php echo $td->namaTindakan." x ".$td->qty; ?></td>
                                        <td>Rp.</td>
                                        <td style="text-align: right;"><?php echo number_format($td->harga*$td->qty,'0',',','.'); ?></td>
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
                                                echo "&nbsp @".$fm->jumlah." x ".number_format($fm->harga,'0',',','.'); 
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
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div style="font-weight:bold;font-size: 14px;border-bottom: solid 1px #dfdfdf;"><i class="fa fa-credit-card"></i> Jenis Pembayaran </div>

                        <div class="form-inline">
                            <?php
                                foreach($paymentType as $py){
                            ?>
                            <div class="form-group" style="margin-top: 5px;">
                                <a class="btn btn-success btn-rounded typeBayar button<?php echo $py->id; ?>" id="<?php echo $py->id; ?>"><?php echo $py->payment_type; ?></a> 
                            </div>
                            <?php } ?>
                        </div>

                        <div class="form-group" id="inputPaymentType" style="margin-top: 10px;">
                        </div>

                        <div>
                            <input type="hidden" id="idPaymentValue"/>
                            <input type="hidden" id="subPaymentValue"/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>

