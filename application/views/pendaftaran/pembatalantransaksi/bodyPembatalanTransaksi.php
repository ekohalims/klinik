<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
                <h3 class="title"><i class="fa fa-warning"></i> Pembatalan Transaksi</h3> 
            </div>
        </div>

        <div class="col-md-6" style="text-align:right;">
            <a href="<?php echo base_url('pembatalanTransaksi/daftarTransaksiDibatalkan'); ?>" class="btn btn-default btn-rounded"><i class="fa fa-list"></i> Daftar Transaksi Dibatalkan</a>
        </div>
    </div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th style="width:5%;">No</th>
                                    <th>No Pendaftaran</th>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>No ID</th>
                                    <th>No RM</th>
                                    <th>Kelurahan</th>
                                    <th>Tempat, Tanggal Lahir</th>
                                    <th>Status Bayar</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>
