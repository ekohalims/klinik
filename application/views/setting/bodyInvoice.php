<div class="wraper container-fluid">
    <div class="page-title"> 
    	<h3 class="title"><i class="fa fa-book"></i> Setting Invoice</h3> 
	</div>

    <div class="row">
        <div class="col-md-3"> 
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <form action="<?php echo base_url('invoice/simpan'); ?>" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="radio" name="jenis" value="rekap" <?php if($setting=='rekap'){echo "checked";} ?>/> Rekap
                                    <input type="radio" name="jenis" value="detail" <?php if($setting=='detail'){echo "checked";} ?>/> Detail
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12" style="text-align:right;">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- /Portlet -->	
        </div>
    </div>
</div>
