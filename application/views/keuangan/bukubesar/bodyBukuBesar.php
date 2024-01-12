<div class="wraper container-fluid">
    <div class="row">
    	<div class="col-md-6">
            <div class="page-title">
                <h3 class="title"><i class="fa fa-book"></i> Buku Besar</h3>
            </div>
        </div>

        <div class="col-md-6" style="text-align: right;" id="buttonPrint">
    	</div>
    </div>

    <div class="row">
        <div class="col-md-3 table-responsive" id="loadDatatables">
            <div class="portlet" style="border-top:solid 4px #12a89d;">
                <!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="form-group">
                            <label>Date Start</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control datepicker" placeholder="Date Start" id="dateStart" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Date End</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control datepicker" placeholder="Date End" id="dateEnd" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Akun</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-book"></i></span>
                                <select class="select2" id="akun">
                                    <option value="">--Pilih Akun--</option>

                                    <?php
                                        foreach($viewAkun as $dt){
                                    ?>
                                        <option value="<?php echo $dt->kodeSubAkun; ?>">
                                            <?php echo $dt->namaSubAkun; ?>
                                        </option>
                                        <?php } ?>
                                </select>
                            </div>

                        </div>

                        <div class="form-group" style="border-top:20px;">
                            <button class="btn btn-success" id="viewReport" style="width: 100%;"><i class="fa fa-search"></i> Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9 table-responsive" id="loadDatatables">
            <div class="portlet" style="border-top:solid 4px #12a89d;">
                <!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body" id="viewReportData"></div>
                </div>
            </div>
        </div>
    </div>
</div>