<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title">
                <h3 class="title"><i class="fa fa-h-square"></i> Proses Permintaan Radiologi</h3>
                <h6> <a href="<?php echo base_url('orderRadiologi'); ?>">Order Radiologi</a> / Proses Permintaan</h6>
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
                                <td width="45%" style="font-weight: bold;">No Pasien</td>
                                <td>
                                    <?php echo $dataOrderRow->noPasien; ?>
                                </td>
                            </tr>

                            <tr>
                                <td width="45%" style="font-weight: bold;">Nama</td>
                                <td>
                                    <?php echo $dataOrderRow->namaPasien; ?>
                                </td>
                            </tr>

                            <tr>
                                <td width="45%" style="font-weight: bold;">Sex/Umur</td>
                                <td>
                                    <?php echo $dataOrderRow->jenisKelamin." / ".$umur." Thn"; ?>
                                </td>
                            </tr>

                            <tr>
                                <td width="45%" style="font-weight: bold;">Tanggal Permintaan</td>
                                <td>
                                    <?php echo date_format(date_create(),'d M Y H:i'); ?>
                                </td>
                            </tr>

                            <tr>
                                <td width="45%" style="font-weight: bold;">Dokter Pengirim</td>
                                <td>
                                    <?php echo $dataOrderRow->namaDokter; ?>
                                </td>
                            </tr>

                            <tr>
                                <td width="45%" style="font-weight: bold;">Poli</td>
                                <td>
                                    <?php echo $dataOrderRow->poliklinik; ?>
                                </td>
                            </tr>

                            <tr>
                                <td width="45%" style="font-weight: bold;">Status</td>
                                <td id="statusOrder">

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
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12" id="tombolAddItem" style="text-align:right;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                        <tr style="font-weight: bold;">
                                            <th width="5%">No</th>
                                            <th>Jenis Permintaan</th>
                                            <th>Penginput</th>
                                            <th>Tanggal Input</th>
                                            <th>Catatan</th>
                                            <th width="5%"></th>
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

</div>

<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Hasil Radiologi</h4>
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

    <div id="modalRad" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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