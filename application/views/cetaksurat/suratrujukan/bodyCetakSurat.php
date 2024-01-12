<div class="wraper container-fluid">
    <div class="row">
    	<div class="col-md-6">
    		<div class="page-title"> 
		    	<h3 class="title"><i class="fa fa-envelope"></i> Cetak Surat Rujukan</h3> 
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
				   	<div class="portlet-body">
                        <label>Pilih Tanggal Pemeriksaan</label>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Dokter</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    $numRows = $dataPemeriksaan->num_rows();

                                    if($numRows > 0){
                                        foreach($dataPemeriksaan->result() as $dt){
                                ?>
                                    <tr>
                                        <td class="cetakSurat" id="<?php echo $dt->noPendaftaran; ?>"><a><?php echo date_format(date_create($dt->tanggalDaftar),'d M Y'); ?></a></td>
                                        <td><?php echo $dt->nama; ?></td>
                                    </tr>
                                <?php
                                        } 
                                    } else {
                                ?>
                                
                                    <tr>
                                        <td colspan="2">--Belum ada data pemeriksaan--</td>
                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
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