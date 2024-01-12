<div id="CssLoader" style="display: none;">
    <div class='spinftw'></div>
</div>

<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
                <h3 class="title"><i class="fa fa-user"></i> Pendaftaran Rawat Jalan</h3> 
            </div>
        </div>

        <div class="col-md-6" style="text-align:right;">
            <a href="<?php echo base_url('pendaftaranRajal/daftar'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Pendaftaran</a>
        </div>
    </div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group m-t-10  pull-right" style="width:300px;">
                            <input type="text" class="form-control" placeholder="Pencarian" id="pencarian">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top:10px;">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Register</th>
                                    <th>Tanggal</th>
                                    <th>Medrec</th>
                                    <th>Nama Pasien</th>
                                    <th>Tgl Lahir</th>
                                    <th>Poli</th>
                                    <th>Dokter</th>
                                    <th>Penanggung</th>
                                    <th>Status</th>
                                    <th>STS</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody id="dataPasien">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>

