<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
                <h3 class="title"><i class="fa fa-ambulance"></i> Master Tarif <?php echo $dekrip; ?></h3> 
            </div>
        </div>

        <div class="col-md-6" style="text-align:right;">
            <a class="btn btn-info tambahTarif" id="<?php echo $dekrip; ?>"><i class="fa fa-plus"></i> Tambah</a>
        </div>
    </div>

    <div class="portlet" style="border-top:solid 4px #0081c3;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12 table-responsive" id="loadDatatables">
                    </div>

                    <input type="hidden" id="uri" value="<?php echo $tableName; ?>"/>;
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="simpan">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
