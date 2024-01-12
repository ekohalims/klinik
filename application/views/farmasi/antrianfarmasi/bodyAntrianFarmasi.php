<div class="wraper container-fluid">
    <div class="page-title"> 
    	<h3 class="title"><i class="fa fa-sort-alpha-asc"></i> Antrian Farmasi</h3> 
	</div>

    <div class="row">
        <div class="col-md-3">
            <div class="mini-stat clearfix" id="hover0" style="border-top:solid 4px rgba(235, 193, 66, 0.8);">
                <a class="daftarOrder" id="0">
                    <span class="mini-stat-icon bg-warning"><i class="fa fa-exchange"></i></span>
                    <div class="mini-stat-info text-right">
                        <span class="counter"><?php echo $belumDiProses; ?></span>
                        Belum Diproses
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="mini-stat clearfix" id="hover1">
                <a class="daftarOrder" id="1">
                    <span class="mini-stat-icon bg-info"><i class="fa fa-sign-in"></i></span>
                    <div class="mini-stat-info text-right">
                        <span class="counter"><?php echo $dalamProses; ?></span>
                        Dalam Proses
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="mini-stat clearfix" id="hover2">
                <a class="daftarOrder" id="2">
                    <span class="mini-stat-icon bg-success"><i class="fa fa-check-square-o"></i></span>
                    <div class="mini-stat-info text-right">
                        <span class="counter"><?php echo $selesai; ?></span>
                        Selesai
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="mini-stat clearfix" id="hover3">
                <a class="daftarOrder" id="3">
                    <span class="mini-stat-icon bg-danger"><i class="fa fa-close"></i></span>
                    <div class="mini-stat-info text-right">
                        <span class="counter"><?php echo $batal; ?></span>
                        Batal
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="portlet" style="border-top:solid 4px rgba(235, 193, 66, 0.8);"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
            	<div class="row" style="margin-top: 10px;">
            		<div class="col-md-12" style="text-align: right;">
            			<div class="form-inline">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Pencarian" id="query">
                            </div>

                            <div class="form-group">
                                <select class="form-control" id="cariBerdasarkan">
                                    <option>--Cari Berdasarkan--</option>
                                    <option value="kl_resepheader.noPendaftaran">No Pendaftaran</option>
                                    <option value="kl_daftar.idPasien">No Pasien</option>
                                    <option value="kl_pasien.noID">No KTP</option>
                                    <option value="kl_pasien.namaLengkap">Nama</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary" id="cari"><i class="fa fa-search"></i> Cari</button>
                            </div>
                        </div>
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

