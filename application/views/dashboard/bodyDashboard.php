<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6 col-xs-6 col-sm-6">
            <div class="page-title"> 
                <h3 class="title" id="periode"></h3> 
            </div>
        </div>

        <div class="col-md-6 col-xs-6 col-sm-6" style="text-align:right;" id="buttonFilter">
        </div>
    </div>

    <div class="row" style="margin-top:5px;">
        <div class="col-md-3 col-sm-6">
            <div class="widget-panel widget-style-1 bg-danger">
                <i class="fa fa-users"></i> 
                <h2 class="m-0 counter text-white" id="jumlahPasien"></h2>
                <div class="text-white">Jumlah Pasien Berkunjung</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="widget-panel widget-style-1 bg-warning">
                <i class="fa fa-credit-card"></i> 
                <h2 class="m-0 counter text-white" id="menungguPembayaran"></h2>
                <div class="text-white">Invoice Menunggu Pembayaran</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="widget-panel widget-style-1 bg-success">
                <i class="fa fa-hospital-o"></i> 
                <h2 class="m-0 counter text-white" id="permintaanLaboratorium"></h2>
                <div class="text-white">Permintaan Laboratorium</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="widget-panel widget-style-1 bg-info">
                <i class="fa fa-stethoscope"></i> 
                <h2 class="m-0 counter text-white" id="permintaanRadiologi"></h2>
                <div class="text-white">Permintaan Radiologi</div>
            </div>
        </div>
    </div> 

    <div class="row">
        <div class="col-md-6">
            <div class="portlet">
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark text-uppercase">
                        Pasien Berdasarkan Usia
                    </h3>
                </div>
                
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body" id="pasienByAge">            
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="portlet">
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark text-uppercase">
                        Pasien Berdasarkan Jenis Kelamin
                    </h3>
                </div>
                
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body" id="pasienByGender">            
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet">
                <div class="portlet-heading">
                    <div class="row">
                        <h3 class="portlet-title text-dark text-uppercase">
                            Kunjungan Pasien
                        </h3>
                    </div>
                    
                </div>
                
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body" id="pasienVisit">            
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="portlet">
                <div class="portlet-heading">
                    <div class="row">
                        <h3 class="portlet-title text-dark text-uppercase">
                           Diagnosa 
                        </h3>
                    </div>
                    
                </div>
                
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body" id="diagnosaICD">            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>