<div class="wraper container-fluid">
    <div class="row">
    	<div class="col-md-6">
    		<div class="page-title"> 
		    	<h3 class="title"><i class="fa fa-book"></i> Laporan Stock Opname</h3> 
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
                          <label>Tahun</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" class="form-control datepicker" placeholder="Tahun" id="tahun" readonly>
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
                	</div>
               	</div>
            </div>
        </div>
    </div>
</div>

