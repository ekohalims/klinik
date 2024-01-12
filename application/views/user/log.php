<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
            <h3 class="title"><i class="fa fa-list"></i> User Log</h3> 
            </div>
        </div>
    

        <div class="col-md-6" style="text-align:right;">
            <a onclick="printContent('dataReport')" class="btn btn-info"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-3">
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
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
                            <label>User</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-user"></i></span>
                              <select class="select2" id="user">
                                <option value="">--Tampilkan Semua--</option>
                                <?php
                                    foreach($user as $us){
                                ?>
                                    <option value="<?php echo $us->id; ?>"><?php echo $us->first_name." ".$us->last_name; ?></option>    
                                <?php
                                    }
                                ?>
                              </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-success" id="viewReport" style="width: 100%;"><i class="fa fa-search"></i> Submit</button>
                        </div>
                    </div>
                </div>
            </div> <!-- /Portlet -->
        </div>

        <div class="col-md-9">
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body" id="dataReport">
                        
                    </div>
                </div>
            </div> <!-- /Portlet -->
        </div>
    </div>	
</div>