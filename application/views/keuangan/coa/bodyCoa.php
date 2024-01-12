<div class="wraper container-fluid">
    <div class="page-title"> 
    	<h3 class="title"><i class="fa fa-list"></i> Chart of Account</h3> 
	</div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12" style="text-align:right;">
                        <a class="btn btn-success btn-rounded showModal"><i class="fa fa-plus"></i> Tambah Akun</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width:15%;">Kode Akun</th>
                                    <th>Nama Akun</th>
                                    <th style="width:8%;"></th>
                                </tr>
                            </thead>

                            <tbody id="content">
                            </tbody>
                        </table>
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
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
