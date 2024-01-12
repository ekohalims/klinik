<div class="wraper container-fluid">
    <div class="page-title"> 
    	<h3 class="title"><i class="fa fa-book"></i> Saldo Kas</h3> 
        <h6> <a href="<?php echo base_url('kasDanBank'); ?>">Kas dan Bank</a> / Saldo Kas</h6>
	</div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th style="width:10%">Kode Akun</th>
                                    <th width="43%">Akun</th>
                                    <th style="text-align:right;">Saldo</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    foreach($saldoKas as $row){
                                ?>
                                <tr>
                                    <td><?php echo $row->kodeSubAkun; ?></td>
                                    <td><?php echo $row->namaSubAkun; ?></td>
                                    <td style="text-align:right"><?php echo number_format($row->saldo,'0',',','.'); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>
