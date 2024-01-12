<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
                <h3 class="title"><i class="fa fa-money"></i> Kasir</h3> 
            </div>
        </div>

        <div class="col-md-6" style="text-align:right;">
            <a class="btn btn-info btn-rounded" href="<?php echo base_url('kasir/daftarPiutang'); ?>"><i class="fa fa-list"></i> Penerimaan Piutang</a>
            <a class="btn btn-inverse btn-rounded" href="<?php echo base_url('kasir/daftarInvoicePasien'); ?>"><i class="fa fa-book"></i> Daftar Invoice Pasien</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">     
            <ul class="nav nav-tabs"> 
                <li class=""> 
                    <a id="RAJAL" class="filter"data-toggle="tab" aria-expanded="false"> 
                        <span class="visible-xs"><i class="fa fa-home"></i></span> 
                        <span class="hidden-xs">Rawat Jalan</span> 
                    </a> 
                </li> 

                <li class=""> 
                    <a id="RANAP" class="filter"data-toggle="tab" aria-expanded="false"> 
                        <span class="visible-xs"><i class="fa fa-home"></i></span> 
                        <span class="hidden-xs">Rawat Inap</span> 
                    </a> 
                </li> 
            </ul> 
        </div>
    </div>

    <div class="portlet"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">   
                    <div class="col-md-6" style="text-align: right;">
                        <!--<div class="form-inline">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Pencarian" id="query">
                            </div>

                            <div class="form-group">
                                <select class="form-control" id="cariBerdasarkan">
                                    <option>--Cari Berdasarkan--</option>
                                    <option value="kl_daftar.noPendaftaran">No Pendaftaran</option>
                                    <option value="kl_daftar.idPasien">No Pasien</option>
                                    <option value="kl_pasien.noID">No KTP</option>
                                    <option value="kl_pasien.namaLengkap">Nama</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary btn-rounded" id="cari"><i class="fa fa-search"></i> Cari</button>
                            </div>
                        </div>-->
                    </div>
                </div>

                <div class="row" style="margin-top:30px;">
                    <div class="col-md-12" id="content">
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>

