<div class="wraper container-fluid">
    <div class="row">
    	<div class="col-md-6">
    		<div class="page-title"> 
		    	<h3 class="title"><i class="fa fa-envelope"></i> Cetak Surat Sakit</h3> 
			</div>
    	</div>

    	<div class="col-md-6" style="text-align: right;">
            <a class="btn btn-success btn-rounded" onclick="printContent('viewContent')"><i class="fa fa-print"></i> Print</a>
    	</div>
    </div>
   
   	<div class="row">        
        <div class="col-md-4">
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
				<div id="portlet2" class="panel-collapse collapse in">
				   	<div class="portlet-body" id="content">
	                </div>
	    		</div> <!-- /Portlet -->
	        </div> 	
	    </div>

        <div class="col-md-8">
           	<div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
				<div id="portlet2" class="panel-collapse collapse in">
					<div class="portlet-body table-responsive" id="viewContent">
					   	<div class="alert alert-danger" style="text-align: center;">
                			--Belum memilih tanggal pemeriksaan--
                		</div>
                	</div>
               	</div>
            </div>
        </div>
    </div>
</div>