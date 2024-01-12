<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
                <h3 class="title"><i class="fa fa-list"></i> List Kas Masuk</h3> 
                <h6> <a href="<?php echo base_url('kasDanBank'); ?>">Kas dan Bank</a> / <a href="<?php echo base_url('kasDanBank/kasMasuk'); ?>">Kas Masuk</a> / List Kas Masuk</h6>
            </div>
        </div>
    </div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class='table table-striped' id="datatable">
                            <thead>
                                <tr>
                                    <th style="width:5%;">No</th>
                                    <th>No Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Akun Kas</th>
                                    <th>PIC</th>
                                    <th>Memo</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>
