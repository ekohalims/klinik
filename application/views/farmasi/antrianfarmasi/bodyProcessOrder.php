<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title">
                <h3 class="title"><i class="fa fa-h-square"></i> Proses Permintaan Farmasi</h3>
                <h6> <a href="<?php echo base_url('antrianFarmasi'); ?>">Antrian Farmasi</a> / Proses Permintaan</h6>
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
                                <td style="font-weight: bold;width:50%;">No Pendaftaran</td>
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
                                    <?php echo $dataOrderRow->namaLengkap; ?>
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
                                <td style="font-weight: bold;">Dokter</td>
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
                                <td style="font-weight: bold;">Status Permintaan</td>
                                <td id="statusOrder"></td>
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
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="portlet" style="border-top:solid 4px #12a89d;">
                <!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div style="text-align:right;" id="addItemButton">
                            
                        </div>
                                    
                        <br>
                    
                        <table class="table">
                            <thead>
                                <tr style="font-weight: bold;">
                                    <td width="5%">No</td>
                                    <td>Kode Item</td>
                                    <td>Nama Item</td>
                                    <td style="text-align:center;">Qty</td>
                                    <td>Satuan</td>
                                    <td width="10%">Tuslah</td>
                                    <td>Aturan</td>
                                    <td>Expired Date</td>
                                    <td>No Batch</td>
                                    <td width="5%"></td>
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

<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
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
    </div>
</div>


<div class="modal fade bs-example-modal-sm" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="mySmallModalLabel">Update</h4>
            </div>
            
            <div class="modal-body" id="expiredDateContent">
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Tambah Resep</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group" style="width:250px;">
                            <span class="input-group-addon"><i class="fa fa-list"></i></span>
                            <select class="form-control" id="kategori">
                                <option value="">--Kategori--</option>
                                
                                <?php
                                    foreach($kategori as $kg){
                                ?>
                                <option value="<?php echo $kg->id_kategori; ?>"><?php echo $kg->kategori; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-group pull-right" style="width:250px;">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" class="form-control" id="pencarian" placeholder="Pencarian..."/>
                        </div>
                    </div>
                </div>                        
                
                <div class="row" style="margin-top:20px;">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width:5%;">No</th>
                                    <th>Kode Item</th>
                                    <th>Nama Item</th>
                                    <th>Satuan</th>
                                    <th>Kategori</th>
                                    <th style="width:1%;"></th>
                                </tr>
                            </thead>

                            <tbody id="viewItem">
                            </tbody>
                        </table>
                    </div>
                </div>

                <br>

                <div class="row" id="pagination">
                    <div class="col-md-6">
                        <button id="previous" class="btn btn-default"><img src="<?php echo base_url('assets/btnleft.png'); ?>" height="20px"/> Previous </button>
                        <span id="jumlahData"></span>
                    </div>

                    <div class="col-md-6" style="text-align: right;">
                        <button id="next" class="btn btn-default">Next <img src="<?php echo base_url('assets/btn.png'); ?>" height="20px"/></button>
                        <input type="hidden" id="currentPage" value="1"/>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</div>