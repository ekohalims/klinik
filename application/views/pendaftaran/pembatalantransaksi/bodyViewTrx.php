<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
                <h3 class="title"><i class="fa fa-list"></i> Daftar Transaksi Pasien</h3> 
                <h6><a href="<?php echo base_url('pembatalanTransaksi'); ?>">Pembatalan Transaksi</a> / <a href="<?php echo base_url('pembatalanTransaksi/daftarTransaksiDibatalkan'); ?>">Daftar Transaksi Dibatalkan</a> / Daftar Transaksi Pasien</h6>
            </div>
        </div>
    </div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-6">
                        <table width="100%">
                            <tr>
                                <td width="25%">No Pendaftaran</td>
                                <td width="1%">:</td>
                                <td><?php echo $dataTransaksi->noPendaftaran; ?></td>
                            </tr>

                            <tr>
                                <td width="25%">No RM</td>
                                <td width="1%">:</td>
                                <td><?php echo $dataTransaksi->idPasien; ?></td>
                            </tr>

                            <tr>
                                <td width="25%">Nama Lengkap</td>
                                <td width="1%">:</td>
                                <td><?php echo $dataTransaksi->namaLengkap; ?></td>
                            </tr>

                            <tr>
                                <td width="25%">TTL</td>
                                <td width="1%">:</td>
                                <td><?php echo $dataTransaksi->tempatLahir.", ".date_format(date_create($dataTransaksi->tanggalLahir),'d M Y'); ?></td>
                            </tr>

                            <tr>
                                <td width="25%">Jenis Kelamin</td>
                                <td width="1%">:</td>
                                <td><?php echo $dataTransaksi->jenisKelamin; ?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <table width="100%">
                            <tr>
                                <td width="25%">Tanggal</td>
                                <td width="1%">:</td>
                                <td><?php echo date_format(date_create($dataTransaksi->tanggalDaftar),'d M Y H:i'); ?></td>
                            </tr>

                            <tr>
                                <td width="25%">Poliklinik</td>
                                <td width="1%">:</td>
                                <td><?php echo $dataTransaksi->poliklinik; ?></td>
                            </tr>
                            
                            <tr>
                                <td width="25%">Dokter</td>
                                <td width="1%">:</td>
                                <td><?php echo $dataTransaksi->nama; ?></td>
                            </tr>

                            <tr>
                                <td width="25%">Tipe Pembayaran</td>
                                <td width="1%">:</td>
                                <td><?php echo $typeBayar; ?></td>
                            </tr>

                            <tr>
                                <td width="25%">Status</td>
                                <td width="1%">:</td>
                                <td>
                                    <?php 
                                        $status =  $dataTransaksi->status; 

                                        if($status==2){
                                            echo "<span class='label label-success'>Terbayar</span>";
                                        } else {
                                            echo "<span class='label label-danger'>Belum Terbayar</span>";
                                        }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row" style="margin-top:20px;">
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <td style="font-weight:bold;"><i class="fa fa-stethoscope"></i> Tindakan</td>
                            </tr>

                            <tr>
                                <td>
                                    <?php
                                        $numRowsTindakan = $tindakan->num_rows();

                                        if($numRowsTindakan < 1){
                                            echo "Tidak ada tindakan";
                                        } else {
                                    ?>

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Nama Tindakan</th>
                                                    <th style="text-align:right;">Harga</th>
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                                <?php
                                                    foreach($tindakan->result() as $tt){
                                                ?>
                                                <tr>
                                                    <td><?php echo $tt->namaTindakan; ?></td>
                                                    <td style="text-align:right;"><?php echo number_format($tt->harga,'0',',','.'); ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>

                                            <tfoot>
                                            <tfoot>
                                        </table>

                                    <?php
                                        }
                                    ?>
                                </td>
                            </tr>   
                        </table> 
                    </div>

                    <div class="col-md-6">
                        <table class="table">
                                <tr>
                                    <td style="font-weight:bold;"><i class="fa fa-medkit"></i> Farmasi</td>
                                </tr>

                                <tr>
                                    <td>
                                        <?php
                                            $numRowsFarmasi = $farmasi->num_rows();

                                            if($numRowsFarmasi < 1){
                                                echo "Tidak ada farmasi";
                                            } else {
                                                $statusFarmasi = $this->modelPembatalanTransaksi->statusFarmasi($noPendaftaran);

                                                if($statusFarmasi==0){
                                                    $statusFarmasi = "<span class='label label-warning'>Belum Diproses</span>";
                                                } elseif($statusFarmasi==1){
                                                    $statusFarmasi =  "<span class='label label-info'>Dalam Proses</span>";
                                                } elseif($statusFarmasi==2){
                                                    $statusFarmasi =  "<span class='label label-success'>Selesai</span>";
                                                } elseif($statusFarmasi==3){
                                                    $statusFarmasi =  "<span class='label label-danger'>Batal</span>";
                                                }
                                        ?> 
                                            Status : <?php echo  $statusFarmasi; ?>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Item</th>
                                                        <th>Qty</th>
                                                        <th style="text-align:right;">Harga</th>
                                                        <th style="text-align:right;">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    <?php
                                                        foreach($farmasi->result() as $fr){
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $fr->nama_produk; ?></td>
                                                            <td><?php echo $fr->jumlah; ?></td>
                                                            <td style="text-align:right;"><?php echo number_format($fr->harga,'0',',','.'); ?></td>
                                                            <td style="text-align:right;"><?php echo number_format($fr->harga*$fr->jumlah,'0',',','.'); ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>

                                                <tfoot>
                                                <tfoot>
                                            </table>

                                        <?php
                                            }
                                        ?>
                                    </td>
                                </tr>                    
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                    <table class="table">
                            <tr>
                                <td style="font-weight:bold;"><i class="fa fa-heartbeat"></i> Radiologi</td>
                            </tr>

                            <tr>
                                <td>
                                    <?php
                                        $numRowsRadiologi = $radiologi->num_rows();

                                        if($numRowsRadiologi < 1){
                                            echo "Tidak ada radiologi";
                                        } else {

                                            $statusRadiologi = $this->modelPembatalanTransaksi->statusRadiologi($noPendaftaran);
                                    
                                            if($statusRadiologi==0){
                                                $statusRadiologi = "<span class='label label-warning'>Belum Diproses</span>";
                                            } elseif($statusRadiologi==1){
                                                $statusRadiologi =  "<span class='label label-info'>Dalam Proses</span>";
                                            } elseif($statusRadiologi==2){
                                                $statusRadiologi =  "<span class='label label-success'>Selesai</span>";
                                            } else {
                                                $statusRadiologi =  "<span class='label label-danger'>Batal</span>";
                                            }
                                    ?>
                                        Status : <?php echo $statusRadiologi; ?>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Nama Rad</th>
                                                    <th style="text-align:right;">Harga</th>
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                                <?php
                                                    foreach($radiologi->result() as $rd){
                                                ?>
                                                <tr>
                                                    <td><?php echo $rd->namaRadiologi; ?></td>
                                                    <td style="text-align:right;"><?php echo number_format($rd->harga,'0',',','.'); ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>

                                            <tfoot>
                                            <tfoot>
                                        </table>

                                    <?php
                                        }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                    <table class="table">   
                            <tr>
                                <td style="font-weight:bold;"><i class="fa fa-medkit"></i> Laboratorium</td>
                            </tr>

                            <tr>
                                <td>
                                    <?php
                                        $numRowsLaboratorium = $laboratorium->num_rows();

                                        if($numRowsLaboratorium < 1){
                                            echo "Tidak ada laboratorium";
                                        } else {

                                            $statusLaboratorium = $this->modelPembatalanTransaksi->statusLaboratorium($noPendaftaran);
                                    
                                            if($statusLaboratorium==0){
                                                $statusLaboratorium = "<span class='label label-warning'>Belum Diproses</span>";
                                            } elseif($statusLaboratorium==1){
                                                $statusLaboratorium =  "<span class='label label-info'>Dalam Proses</span>";
                                            } elseif($statusLaboratorium==2){
                                                $statusLaboratorium =  "<span class='label label-success'>Selesai</span>";
                                            } elseif($statusLaboratorium==3){
                                                $statusLaboratorium =  "<span class='label label-danger'>Batal</span>";
                                            }
                                    ?>
                                        Status : <?php echo $statusLaboratorium; ?>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Nama Lab</th>
                                                    <th style="text-align:right;">Harga</th>
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                                <?php
                                                    foreach($laboratorium->result() as $lb){
                                                ?>
                                                <tr>
                                                    <td><?php echo $lb->namaLab; ?></td>
                                                    <td style="text-align:right;"><?php echo number_format($lb->harga,'0',',','.'); ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>

                                            <tfoot>
                                            <tfoot>
                                        </table>

                                    <?php
                                        }
                                    ?>
                                </td>
                            </tr> 
                        </table>
                    </div>
                </div>

                <div class="row" style="margin-top:20px;">
                    <div class="col-md-12">
                        
                        <?php
                          if($cekInvoice > 0){
                              if($idPaymentType==5){
                        ?>
                            <div style="border-top:solid 2px #12a89d;padding-bottom:10px;">
                        </div>
                            <b><i class="fa fa-calendar"></i> Riwayat Pembayaran</b>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No Pembayaran</th>
                                        <th>Tanggal</th>
                                        <th>Penginput</th>
                                        <th>Tipe Bayar</th>
                                        <th>Keterangan</th>
                                        <th style="text-align:right;">Nilai Pembayaran</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php
                                    $numRows = $riwayatPembayaran->num_rows();

                                    if($numRows > 0){
                                        $i = 1;
                                        foreach($riwayatPembayaran->result() as $row){
                                ?>
                                <tr>    
                                    <td><?php echo $row->noPembayaran; ?></td>
                                    <td><?php echo date_format(date_create($row->tanggalBayar),'d/m/Y H:i'); ?></td>
                                    <td><?php echo $row->first_name; ?></td>
                                    <td><?php echo $row->payment_type." ".$row->account; ?></td>
                                    <td><?php echo $row->keterangan; ?></td>
                                    <td style="text-align:right;"><?php echo number_format($row->nilaiBayar,'0',',','.'); ?></td>
                                </tr>
                                <?php $i++; } } else { ?>
                                <tr>
                                    <td colspan="7">--Belum ada riwayat pembayaran--</td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        <?php
                              }
                          }  
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="text-align:right;font-weight:bold;font-size:15px;">
                          Grand Total : <?php echo number_format($total,'0',',','.'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Pembatalan Transaksi</h4>
            </div>
            <div class="modal-body">
                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  


