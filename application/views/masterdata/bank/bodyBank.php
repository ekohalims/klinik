<div class="wraper container-fluid">
    <div class="page-title"> 
    	<h3 class="title"><i class="fa fa-bank"></i> Bank</h3> 
	</div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12" style="text-align:right;">
                        <a href='#myModal' id="tambahBank" data-toggle="modal" class='btn btn-success btn-rounded'><i class='fa fa-plus'></i> Tambah Bank</a>
                    </div>
                </div>
                
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-12 table-responsive" id="contentBank">
                    </div>
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
                <button type="button" class="btn btn-primary" id="buttonPoli">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

