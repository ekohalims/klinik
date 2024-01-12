<div class="wraper container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="page-title"> 
          <h3 class="title"><i class="fa fa-trash"></i> Laporan Waste</h3>
          <h6><a href="<?php echo base_url('laporan'); ?>">Laporan</a> / Laporan Waste</h6>
        </div>
      </div>
    </div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->        
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-3" style="border-right: solid 1px #ddd;">
                        <div class="form-group">
                          <label>Date Start</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" class="form-control datepicker" placeholder="Date Start" id="dateStart" readonly>
                          </div>
                        </div>

                         <div class="form-group">
                            <label>Date End</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                              <input type="text" class="form-control datepicker" placeholder="Date End" id="dateEnd" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                          <label>Produk</label>
                          <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-inbox"></i></span>
                              <input type="hidden" id="sku" style="width:100%;"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-info" id="viewReport">Submit</button>
                        </div>
                    </div>

                    <div class="col-md-9" id="dataReport">
                    </div>
                </div>

            </div>
        </div>
    </div> <!-- /Portlet -->    
</div>

<div id="modalDetail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Data Penjualan</h4>
            </div>
            <div class="modal-body" id="dataPenjualan">
                                                
            </div>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>


