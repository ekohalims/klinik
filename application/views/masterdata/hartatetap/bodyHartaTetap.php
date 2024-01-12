<div class="wraper container-fluid">
    <div class="page-title"> 
    	<h3 class="title"><i class="fa fa-car"></i> Harta Tetap</h3> 
	</div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12" style="text-align:right;">
                        <a href="<?php echo base_url('hartaTetap/tambahAset'); ?>" class="btn btn-success btn-rounded"><i class='fa fa-plus'></i> Tambah Harta Tetap</a>
                    </div>
                </div>
            
                <div class="row" style="margin-top:30px;">
                    <div class="col-md-12 table-responsive">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Aset</th>
                                    <th>Nama</th>
                                    <th>Kelompok</th>
                                    <th>Nilai Perolehan</th>
                                    <th>Umur</th>
                                    <th>Akumulasi Beban</th>
                                    <th>Beban Perbulan</th>
                                    <th>Nilai Buku</th>
                                    <th style='width:5%;'></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>
