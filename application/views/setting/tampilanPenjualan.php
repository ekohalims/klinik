<div class="wraper container-fluid">
    <div class="page-title"> 
        <h3 class="title">Tampilan Penjualan</h3> 
    </div>

    <div class="portlet"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12" style="text-align: right;">
                        <a class="btn btn-primary" id="simpan"><i class="fa fa-save"></i> Simpan</a>
                    </div>
                </div>

                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-6">
                        <input type="radio" name="setting" value="1" <?php if($setting->setting==1){echo "checked"; } ?>/> Versi 1<br> 
                        <img src="<?php echo base_url('assets/setting/penjualanv1.png'); ?>" width="500px"/>
                    </div>

                    <div class="col-md-6">
                        <input type="radio" name="setting" value="2" <?php if($setting->setting==2){echo "checked"; } ?>/> Versi 2<br> 
                        <img src="<?php echo base_url('assets/setting/penjualanv1.png'); ?>" width="500px"/>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->     
</div>

