<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title">
                <h3 class="title"><i class="fa fa-h-square"></i> Proses Permintaan Laboratorium</h3>
                <h6> <a href="<?php echo base_url('orderLaboratorium'); ?>">Order Laboratorium</a> / Proses Permintaan</h6>
            </div>
        </div>

        <div class="col-md-6" style="text-align:right;" id="tombolProses">
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="portlet" style="border-top:solid 4px #12a89d;">
                <!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <table class="table">
                            <tr>
                                <td width="45%" style="font-weight: bold;">No Pendaftaran</td>
                                <td>
                                    <?php echo $dataOrderRow->noPendaftaran; ?>
                                </td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">No Pasien</td>
                                <td>
                                    <?php echo $dataOrderRow->noPasien; ?>
                                </td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Nama</td>
                                <td>
                                    <?php echo $dataOrderRow->namaPasien; ?>
                                </td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Sex/Umur</td>
                                <td>
                                    <?php echo $dataOrderRow->jenisKelamin." / ".$umur." Thn"; ?>
                                </td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Tanggal Permintaan</td>
                                <td>
                                    <?php echo date_format(date_create(),'d M Y H:i'); ?>
                                </td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Dokter Pengirim</td>
                                <td>
                                    <?php echo $dataOrderRow->namaDokter; ?>
                                </td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Poli</td>
                                <td>
                                    <?php echo $dataOrderRow->poliklinik; ?>
                                </td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Status</td>
                                <td id="statusOrder">

                                </td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Status Pembayaran</td>
                                <td>
                                    <?php
                                        $status = $dataOrderRow->statusPembayaran;

                                        if($status==1){
                                            echo "<span class='label label-danger'>Belum Terbayar</span>";
                                        } elseif($status==2){
                                            echo "<span class='label label-success'>Terbayar</span>";
                                        }
                                    ?>
                                </td>
                            </tr>

                            <tr id="dokterPemeriksaForm">
                                <input type="hidden" id="dokter" value=""/>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="portlet" style="border-top:solid 4px #12a89d;">
                <!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body" id="area-print">
                        <div class="row">
                            <div class="col-md-12" id="tombolAddItem" style="text-align:right;">
                            </div>
                        </div>
                
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
                                            HASIL LABORATORIUM<br>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row" style="margin-top:5px;">
                            <div class="col-md-6 col-xs-6">
                                <table style="width:100%;">
                                    <tr>
                                        <td style="width:40%;">No Pendaftaran</td>
                                        <td width="2%">:</td>
                                        <td><?php echo $dataOrderRow->noPendaftaran; ?></td>
                                    </tr>

                                    <tr>
                                        <td>No Pasien</td>
                                        <td>:</td>
                                        <td><?php echo $dataOrderRow->noPasien; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Tanggal Daftar</td>
                                        <td>:</td>
                                        <td><?php echo date_format(date_create($dataOrderRow->tanggalDaftar),'d M Y H:i'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Dokter Pengirim</td>
                                        <td>:</td>
                                        <td><?php echo $dataOrderRow->namaDokter; ?></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6 col-xs-6">
                                <table style="width:100%;">
                                    <tr>
                                        <td style="width:40%;">Nama Pasien</td>
                                        <td width="2%">:</td>
                                        <td><?php echo $dataOrderRow->namaPasien; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Tanggal Lahir</td>
                                        <td>:</td>
                                        <td><?php echo date_format(date_create($dataOrderRow->tanggalLahir),'d M Y')." / ".$umur." Thn"; ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td><?php echo $dataOrderRow->alamat; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                

                                <table class="table">
                                    <thead>
                                        <tr style="font-weight: bold;">
                                            <th width="5%">No</th>
                                            <th>Jenis Permintaan</th>
                                            <th>Catatan</th>
                                            <th>Hasil</th>
                                            <th>Nilai Normal</th>
                                            <th width="7%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataOrder">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myLargeModalLabel">Hasil Laboratorium</h4>
                </div>

                <div class="modal-body">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveHasil">Save changes</button>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div id="modalLab" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Item</h4>
                </div>
                <div class="modal-body" id="isiContent">
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
