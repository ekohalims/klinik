<div class="wraper container-fluid">
    <div class="row">
    	<div class="col-md-6">
            <div class="page-title">
                <h3 class="title"><i class="fa fa-book"></i> Neraca Saldo</h3>
            </div>
        </div>

        <div class="col-md-6" style="text-align: right;" id="buttonPrint">
    	</div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="portlet" style="border-top:solid 4px #12a89d;">
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="form-group">
                          <label>Bulan</label>
                          <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <select class="form-control" id="bulan">
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label>Tahun</label>
                          <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <select class="form-control" id="tahun">
                                    <?php
                                        $max = date('Y');

                                        for($i=$max;$i>=2016;$i--){
                                    ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                          </div>
                        </div>

                        <div class="form-group">
                            <button class='btn btn-success btn-rounded' id="preview" style="width:100%;"><i class='fa fa-search'></i> Preview</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="portlet" style="border-top:solid 4px #12a89d;">
                <!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12" id="viewReportData">
                                <div class="alert alert-danger">
                                    Belum ada data untuk ditampilkan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>