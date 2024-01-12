<div id="CssLoader" style="display: none;">
    <div class='spinftw'></div>
</div>

<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
                <h3 class="title"><i class="fa fa-credit-card"></i> Daftar Piutang</h3> 
                <h6> <a href="<?php echo base_url('kasir'); ?>">Kasir</a> / <a href="<?php echo base_url('kasir/daftarPiutang'); ?>"> Daftar Piutang</a> / Pembayaran Piutang</h6>
            </div>
        </div>

        <div class="col-md-6" style="text-align:right;" id="buttonTrx">
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12" style="text-align:right;">
                                <a target="__blank" href="<?php echo base_url('kasir/viewInvoice/'.$noInvoie) ?>" class="btn btn-success btn-rounded"><i class="fa fa-print"></i> Cetak Invoice</a>
                            </div>
                        </div>
          
                        <table class="table table-bordered" style="margin-top:5px;">
                            <tr>
                                <td width="50%" style="font-weight:bold;">No Invoice</td>
                                <td><?php echo $dataPiutang->noInvoice; ?></td>
                            </tr>

                            <tr>
                                <td style="font-weight:bold;">No Pendaftaran</td>
                                <td><?php echo $dataPiutang->noPendaftaran; ?></td>
                            </tr>

                            <tr>
                                <td style="font-weight:bold;">No Pasien</td>
                                <td><?php echo $dataPiutang->noPasien; ?></td>
                            </tr>

                            <tr>
                                <td style="font-weight:bold;">Nama Pasien</td>
                                <td><?php echo $dataPiutang->namaPasien; ?></td>
                            </tr>

                            <tr>
                                <td style="font-weight:bold;">Tanggal Daftar</td>
                                <td><?php echo date_format(date_create($dataPiutang->tanggalDaftar),'d M Y H:i'); ?></td>
                            </tr>

                            <tr>
                                <td style="font-weight:bold;">Jatuh Tempo</td>
                                <td><?php echo date_format(date_create($dataPiutang->jatuhTempo),'d M Y'); ?></td>
                            </tr>

                            <tr>
                                <td style="font-weight:bold;">Jenis Kelamin</td>
                                <td><?php echo $dataPiutang->jenisKelamin; ?></td>
                            </tr>

                            <tr>
                                <td style="font-weight:bold;">Tempat, Tgl Lahir</td>
                                <td><?php echo $dataPiutang->tempatLahir.", ".date_format(date_create($dataPiutang->tanggalLahir),'d M Y'); ?></td>
                            </tr>

                            <tr>
                                <td style="font-weight:bold;">Dokter</td>
                                <td><?php echo $dataPiutang->namaDokter; ?></td>
                            </tr>

                            <tr>
                                <td style="font-weight:bold;">Poliklinik</td>
                                <td><?php echo $dataPiutang->poliklinik; ?></td>
                            </tr>

                            <tr>
                                <td style="font-weight:bold;">Status Piutang</td>
                                <td id="statusPiutang">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="row" style="margin-top:5px;">
                            <div class="col-md-12">
                                <table style="width:100%;">
                                    <tr style="border-bottom:solid 1px #ccc;border-top:solid 3px #12a89d;height:30px;">
                                        <td colspan="3" style="font-weight:bold;"><i class="fa fa-money"></i> Piutang</td>
                                    </tr>

                                    <tr style="height:30px;">
                                        <td style="vertical-align:bottom;padding-left:20px;font-weight:bold;">Total Transaksi</td>
                                        <td width="3%" style="vertical-align:bottom;">Rp</td>
                                        <td id="totalTransaksi" width="15%" style="text-align:right;font-weight:bold;vertical-align:bottom"></td>
                                    </tr>

                                    <tr>
                                        <td style="padding-left:20px;font-weight:bold;">Terbayar</td>
                                        <td>Rp</td>
                                        <td id="terbayar" style="text-align:right;font-weight:bold;"></td>
                                    </tr>

                                    <tr>
                                        <td style="padding-left:20px;font-weight:bold;">Sisa Pembayaran</td>
                                        <td style="border-top:solid 1px black;">Rp</td>
                                        <td id="sisaPembayaran" style="text-align:right;font-weight:bold;border-top:solid 1px black;"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row" style="margin-top:20px;">
                            <div class="col-md-12">
                                <table style="width:100%;">
                                    <tr style="border-bottom:solid 1px #ccc;border-top:solid 3px #12a89d;height:30px;">
                                        <td colspan="2" style="font-weight:bold;"><i class="fa fa-credit-card"></i> Pembayaran</td>
                                    </tr>

                                    <tr style="height:50px;">
                                        <td style="vertical-align:middle;padding-left:20px;font-weight:bold;">Jumlah Bayar</td>
                                        <td style="vertical-align:middle;"><input type="text" class="form-control" id="jumlahBayar"></td>
                                    </tr>

                                    <tr style="height:40px;">
                                        <td style="padding-left:20px;font-weight:bold;">Jenis Pembayaran</td>
                                        <td>
                                            <select class="form-control" id="jenisPembayaran">
                                                <option value="">--Pilih Jenis Pembayaran--</option>

                                                <?php
                                                    foreach($jenisPembayaran as $py){
                                                        if($py->id < 5){
                                                ?>
                    
                                                <option value="<?php echo $py->id; ?>"><?php echo $py->payment_type; ?></option>
                                                
                                                <?php } } ?>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr id="subAccountForm">
                                        <input type='hidden' value='' id='subAccount'>
                                    </tr>

                                    <tr style="height:40px;">
                                        <td style="padding-left:20px;font-weight:bold;">Keterangan</td>
                                        <td><textarea class="form-control" id="keterangan"></textarea></td>
                                    </tr>

                                    <tr style="height:50px;">
                                        <td colspan="2" style="text-align:right;"><button class="btn btn-primary btn-rounded" id="prosesPembayaran"><i class="fa fa-save"></i> Proses Pembayaran</a></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row" style="margin-top:20px;">
                            <div class="col-md-12">
                                <table style="width:100%;">
                                    <tr style="border-bottom:solid 1px #ccc;border-top:solid 3px #12a89d;height:50px;">
                                        <td style="font-weight:bold;"><i class="fa fa-calendar"></i> Riwayat Pembayaran</td>
                                        <td style="text-align:right;"><a class="btn btn-success btn-rounded" href="<?php echo base_url('kasir/cetakBuktiBayar/'.$this->uri->segment(3)); ?>"><i class="fa fa-print"></i> Cetak Bukti bayar</a></td>
                                    </tr>
                                </table>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Pembayaran</th>
                                            <th>Tanggal</th>
                                            <th>Penginput</th>
                                            <th>Tipe Bayar</th>
                                            <th>Keterangan</th>
                                            <th style="text-align:right;">Nilai Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody id="riwayatPembayaran">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

