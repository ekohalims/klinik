
<div class="wraper container-fluid">
    <div class="page-title"> 
      <h3 class="title">Laporan Penjualan</h3> 
    </div>
    <div class="portlet"><!-- /primary heading -->        
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
                          <label>Tipe Bayar</label>
                        
                          <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-money"></i></span>
                              <select class="form-control" id="type_bayar">
                                <option value="">Semua</option>
                                <?php
                                  foreach($payment_type as $py){
                                ?>
                                <option value="<?php echo $py->id; ?>"><?php echo $py->payment_type; ?></option>
                                <?php } ?>
                              </select>
                            </div>
                        </div>

                        <!-- id='subAccount'-->
                        <div class="form-group" id="sub-account">
                          <input type="hidden" id="subAccount" value=""/>
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


