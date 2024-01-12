<div class="wraper container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="page-title"> 
          <h3 class="title"><i class="fa fa-book"></i> Laporan Retur Pembelian</h3> 
          <h6><a href="<?php echo base_url('laporan'); ?>">Laporan</a> / Laporan Retur Pembelian</h6>
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
                            <label>Supplier</label>
                            

                            <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-inbox"></i></span>
                            <select class="select2" id="supplier">
                              <option value="">--Semua--</option>
                              <?php
                                foreach($supplier as $sp){
                              ?>
                              <option value="<?php echo $sp->id_supplier; ?>"><?php echo $sp->supplier; ?></option>
                              <?php } ?>
                            </select>
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


