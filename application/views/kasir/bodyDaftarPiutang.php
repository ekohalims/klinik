<div class="wraper container-fluid">
    <div class="page-title"> 
    	<h3 class="title"><i class="fa fa-credit-card"></i> Daftar Piutang</h3> 
        <h6> <a href="<?php echo base_url('kasir'); ?>">Kasir</a> / Daftar Piutang</h6>
	</div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-inline"  style="text-align:right;">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Search..." id="query"/>
                            </div>

                            <div class="form-group">
                                <select class="form-control" id="column">
                                    <option value="kl_daftar.noPendaftaran">No Pendaftaran</option>
                                    <option value="kl_pasien.noPasien">No Pasien</option>
                                    <option value="kl_pasien.noID">No ID</option>
                                    <option value="kl_pasien.namaLengkap">Nama</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-success" id="search"><i class="fa fa-search"></i> Cari</button>
                            </div>
                        <div>
                    </div>
                </div>

                <div class="row" style="margin-top:10px;">
                    <div class="col-md-12 table-responsive" id="content">
                        <table class="table table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th style="width:4%;">No</th>
                                    <th>No Pendaftaran</th>
                                    <th>No Pasien</th>
                                    <th>Nama Pasien</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Total Pembayaran</th>
                                    <th>Terbayar</th>
                                    <th>Sisa Pembayaran</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>

