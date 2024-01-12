<div class="wraper container-fluid">
    <div class="row">
    	<div class="col-md-6">
    		<div class="page-title"> 
		    	<h3 class="title"><i class="fa fa-sort-amount-asc"></i> Kartu Stok Toko</h3> 
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
                            <label>Item</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-list"></i></span>
                              <input type='hidden' id='item' style='width:100%;'/>
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

