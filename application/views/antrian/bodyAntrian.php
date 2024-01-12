<div id="CssLoader" style="display: none;">
    <div class='spinftw'></div>
</div>

<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
                <h3 class="title"><i class="fa fa-user-md"></i> Tindakan Pasien</h3> 
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-inline pull-right">
                <div class="form-group" style="text-align: right;">
                    <a href="#myModal" data-toggle="modal" class="btn btn-success btn-rounded"><i class="fa fa-filter"></i> Filter</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="mini-stat clearfix" id="hover0" style="border-top:solid 4px rgba(235, 193, 66, 0.8);">
                <a class="daftarOrder" id="0">
                    <span class="mini-stat-icon bg-warning"><i class="fa fa-exchange"></i></span>
                    <div class="mini-stat-info text-right">
                        <span class="counter"><?php //echo $belumDiProses; ?></span>
                        Belum Diproses
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mini-stat clearfix" id="hover2">
                <a class="daftarOrder" id="1">
                    <span class="mini-stat-icon bg-success"><i class="fa fa-check-square-o"></i></span>
                    <div class="mini-stat-info text-right">
                        <span class="counter"><?php //echo $selesai; ?></span>
                        Selesai
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mini-stat clearfix" id="hover3">
                <a class="daftarOrder" id="3">
                    <span class="mini-stat-icon bg-danger"><i class="fa fa-close"></i></span>
                    <div class="mini-stat-info text-right">
                        <span class="counter"><?php //echo $batal; ?></span>
                        Batal
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
            	<div class="row" style="margin-top: 10px;">
                    <div class="col-md-12" id="viewContent">
                       
                    </div>
            	</div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Filter Data</h4>
            </div>

            <div class="modal-body">     
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-hospital-o"></i></span>
                        <select class="select2" id="poliklinik">
                            <option value="">--Pilih Poliklinik--</option>
                            <?php
                                foreach($poliklinik as $plk){
                            ?>
                                <option value="<?php echo $plk->id_poliklinik; ?>"><?php echo $plk->poliklinik; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group" id="dokterSelect2">
                        <span class="input-group-addon"><i class="fa fa fa-user-md"></i></span>
                        <select class="select2" id="dokter">
                            <option value="">--Pilih Dokter--</option>
                        </select>
                    </div>
                </div> 

                <div class="form-group" style="text-align: right;">
                    <a class="btn btn-success btn-rounded" id="lihatAntrian"><i class="fa fa-filter"></i> Filter</a>
                </div>                            
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->