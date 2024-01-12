<div class="wraper container-fluid">
   <div class="row">
      <div class="col-md-6">
         <div class="page-title">
            <h3 class="title"><i class="fa fa-money"></i> Laporan Purchase Order</h3>
         </div>
      </div>
      <div class="col-md-6" style="text-align: right;" id="buttonPrint">
      </div>
   </div>
   <div class="row">
      <div class="col-md-3">
         <div class="portlet" style="border-top:solid 4px #12a89d;">
            <!-- /primary heading -->        
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
                     <label>Supplier</label>
                     <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-truck"></i></span>
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
                     <label>Status</label>
                     <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-plug"></i></span>
                        <select class="select2" id="status">
                           <option value="">--Semua--</option>
                           <option value="0">Menunggu Approve</option>
                           <option value="1">Diterima</option>
                           <option value="2">Ditolak</option>
                           <option value="3">Selesai</option>
                        </select>
                     </div>
                  </div>
                  <div class="form-group">
                     <button class="btn btn-success" style="width:100%;" id="viewReport"><i class="fa fa-search"></i> Submit</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-9">
         <div class="portlet" style="border-top:solid 4px #12a89d;">
            <!-- /primary heading -->        
            <div id="portlet2" class="panel-collapse collapse in">
               <div class="portlet-body table-responsive" id="dataReport">
                    <div class="alert alert-danger" style="text-align: center;">
                			--Belum ada data untuk ditampilkan--
                		</div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>