<div class="wraper container-fluid">
    <div class="row">
    	<div class="col-md-6">
    		<div class="page-title"> 
		    	<h3 class="title"><i class="fa fa-bug"></i> Laporan Rekam Medis</h3> 
			</div>
    	</div>

    	<div class="col-md-6" style="text-align: right;" id="buttonPrint">
    	</div>
    </div>
   
   	<div class="row">        
        <div class="col-md-3">
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
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
                            <label>Poli</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-hospital-o"></i></span>
                              
                              <select class="select2" id="poli">
                              	<option value="">--Tampilkan Semua--</option>
                              	<?php
	                            	foreach($poli as $poli){
	                            ?>
                              	<option value="<?php echo $poli->id_poliklinik; ?>"><?php echo $poli->poliklinik; ?></option>
                              	<?php } ?>
                              </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Dokter</label>
                            <div class="input-group" id="dokterForm">
                              <span class="input-group-addon"><i class="fa fa-user-md"></i></span>
                              <select class="select2" id="dokter">
                              	<option value="">--Tampilkan Semua--</option>
                              </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Diagnosa</label>
                            <div class="input-group" id="dokterForm">
                              <span class="input-group-addon"><i class="fa fa-stethoscope"></i></span>
                              <input type="hidden" id="diagnosa" style="width: 100%;" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Pasien</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-user"></i></span>
                              <input type="hidden" id="dataPasien" style="width: 100%;" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Jenis Pasien</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-money"></i></span>
                              <select class="select2" id="jenisPasien">
                              	<option value="">--Tampilkan Semua--</option>


                              	<option value="RAJAL">Rawat Jalan</option>
                              	<option value="RANAP">Rawat Inap</option>

                              </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-success" id="viewReport" style="width: 100%;"><i class="fa fa-search"></i> Submit</button>
                        </div>
	                </div>
	    		</div> <!-- /Portlet -->
	        </div> 	
	    </div>

        <div class="col-md-9">
           	<div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
				<div id="portlet2" class="panel-collapse collapse in">
					<div class="portlet-body table-responsive" id="viewReportData">
					   	<div class="alert alert-danger" style="text-align: center;">
                			--Belum ada data untuk ditampilkan--
                		</div>
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
                <h4 class="modal-title" id="myModalLabel">Jadwal Dokter</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="simpanJadwal">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  

