<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
            	<h3 class="title"><i class="fa fa-file-word-o"></i> Kwitansi Pembayaran</h3> 
        	    <h6> <a href="<?php echo base_url('kasir'); ?>">Kasir</a> / <a href="<?php echo base_url('kasir/daftarPiutang'); ?>"> Daftar Piutang</a> / <a href="<?php echo base_url('kasir/bayarPiutang/'.$this->uri->segment(3)); ?>">Pembayaran Piutang</a> / Cetak Bukti Pembayaran</h6>
            </div>
        </div>

        <div class="col-md-6" style="text-align: right;">
            <a class="btn btn-success btn-rounded" onclick="printContent('area-print')"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body" id="area-print">
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
                                    KWITANSI PEMBAYARAN<br>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row" style="margin-top:5px;">
                    <div class="col-md-6 col-xs-6">
                        <table style="width:100%;">
                            <tr>
                                <td style="width:40%;">No Invoice</td>
                                <td width="2%">:</td>
                                <td><?php echo $headerInvoice->noInvoice; ?></td>
                            </tr>

                            <tr>
                                <td>No Pendaftaran</td>
                                <td>:</td>
                                <td><?php echo $headerInvoice->noPendaftaran; ?></td>
                            </tr>

                            <tr>
                                <td>No Pasien</td>
                                <td>:</td>
                                <td><?php echo $headerInvoice->idPasien; ?></td>
                            </tr>

                            <tr>
                                <td>Tanggal Daftar</td>
                                <td>:</td>
                                <td><?php echo date_format(date_create($headerInvoice->tanggalDaftar),'d M Y H:i'); ?></td>
                            </tr>

                            <tr>
                                <td>Jatuh Tempo</td>
                                <td>:</td>
                                <td><?php echo date_format(date_create($headerInvoice->jatuhTempo),'d M Y'); ?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6 col-xs-6">
                        <table style="width:100%;">
                            <tr>
                                <td style="width:40%;">Nama Pasien</td>
                                <td width="2%">:</td>
                                <td><?php echo $headerInvoice->namaPasien; ?></td>
                            </tr>

                            <tr>
                                <td>Tanggal Lahir</td>
                                <td>:</td>
                                <td><?php echo date_format(date_create($headerInvoice->tanggalLahir),'d M Y'); ?></td>
                            </tr>

                            <tr>
                                <td>Dokter</td>
                                <td>:</td>
                                <td><?php echo $headerInvoice->namaDokter; ?></td>
                            </tr>

                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td><?php echo $headerInvoice->alamat; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row" style="margin-top:10px;">
                    <div class="col-md-12">
                        <table style="width:100%;border-bottom:solid 1px black;border-right:solid 1px black;border-left:solid 1px black;">
                            <tr style="border-top:solid 1px black;border-bottom:solid 1px black;">
                                <td style="font-weight:bold;width:3%;border-right:solid 1px black;padding-left:3px;">No</td>
                                <td style="font-weight:bold;border-right:solid 1px black;padding-left:3px;">Jenis Pembayaran</td>
                                <td style="font-weight:bold;border-right:solid 1px black;padding-left:3px;">Tanggal</td>
                                <td style="font-weight:bold;border-right:solid 1px black;padding-left:3px;">No Pembayaran</td>
                                <td style="font-weight:bold;border-right:solid 1px black;padding-left:3px;">Kasir</td>
                                <td style="font-weight:bold;text-align:right;padding-right:3px;">Total</td>
                            </tr>

                            <?php
                                $i = 1;
                                $total = 0;
                                foreach($riwayatPembayaran->result() as $row){
                            ?>
                            <tr>
                                <td style="border-right:solid 1px black;padding-left:3px;"><?php echo $i; ?></td>
                                <td style="border-right:solid 1px black;padding-left:3px;"><?php echo $row->payment_type." ".$row->account; ?></td>
                                <td style="border-right:solid 1px black;padding-left:3px;"><?php echo date_format(date_create($row->tanggalBayar),'d/m/y H:i'); ?></td>
                                <td style="border-right:solid 1px black;padding-left:3px;"><?php echo $row->noPembayaran; ?></td>
                                <td style="border-right:solid 1px black;padding-left:3px;"><?php echo $row->first_name; ?></td>
                                <td style="text-align:right;padding-right:3px;"><?php echo number_format($row->nilaiBayar,'0',',','.'); ?></td>
                            </tr>
                            <?php $i++; $total = $total+$row->nilaiBayar; } ?>
                        </table>

                        <table width="100%">
                            <tr style="height:30px;">
                                <td style="font-weight:bold;text-align:right;">Grand Total Pembayaran :</td>
                                <td style="text-align:right;font-weight:bold;"><?php echo number_format($total,'0',',','.'); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>

