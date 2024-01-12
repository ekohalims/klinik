<div class="wraper container-fluid">
    <div class="row">
    	<div class="col-md-6">
            <div class="page-title">
                <h3 class="title"><i class="fa fa-book"></i> Penerimaan Piutang</h3>
            </div>
        </div>

        <div class="col-md-6" style="text-align: right;">
            <a href="#myModal" data-toggle="modal" class="btn btn-success btn-rounded"><i class="fa fa-filter"></i> Filter</a> <a class="btn btn-info btn-rounded" onclick="printContent('viewReportData')"><i class="fa fa-print"></i> Print</a>
    	</div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body" id="viewReportData">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Filter Piutang</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Penanggung</label>
                    <select class="form-control" id="penanggung">
                        <option value="">--Tampilkan Semua--</option>
                        <?php
                            foreach($layanan as $ly){
                        ?>
                        <option value="<?php echo $ly->id_layanan; ?>"><?php echo $ly->layanan; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group" id="asuransiForm">
                    <input type='hidden' id='asuransi' value=''/>
                </div>

                <div class="form-group">
                    <label>Pasien</label>
                    <input type="hidden" id="pasienSelect2" style="width:100%;"/>
                </div>

                <div class="form-group">
                    <label>Jatuh Tempo</label>
                    <select class="form-control" id="tempo">
                        <option value="">--Tampilkan Semua--</option>
                        <option value="1"> Belum Jatuh Tempo </option>
                        <option value="2"> Melebihi Tempo</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" id="status">
                        <option value="">--Tampilkan Semua--</option>
                        <option value="0"> Belum Melakukan Pembayaran </option>
                        <option value="1"> Terbayar</option>
                        <option value="2"> Lunas</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="filterPiutang">Filter</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
