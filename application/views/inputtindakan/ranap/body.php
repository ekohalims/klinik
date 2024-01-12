<div class="wraper container-fluid">
    <div class="page-title"> 
    	<h3 class="title"><i class="fa fa-bed"></i> Input Tindakan Rawat Inap</h3> 
	</div>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs"> 
                <?php
                    foreach($pos as $ps){
                ?>  
                <li class=""> 
                    <a class="filterInputTindakan" data-toggle="tab" aria-expanded="false" id="<?php echo $ps->idPos; ?>"> 
                        <span class="visible-xs"><i class="fa fa-home"></i></span> 
                        <span class="hidden-xs"><?php echo $ps->pos; ?></span> 
                    </a> 
                </li> 
                <?php } ?>
            </ul> 
        </div>
    </div>

    <div class="portlet"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12" id="contentDatatable">
                        
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>

