<div class="wraper container-fluid">
    <div class="page-title"> 
    	<h3 class="title"><i class="fa fa-suitcase"></i> Ruang Inap</h3> 
	</div>

    <div class="row">
        <div class="col-md-8">
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12" style="text-align:right;">
                            <a href='#myModal' id="tambahRanap" data-toggle="modal" class='btn btn-success btn-rounded'><i class='fa fa-plus'></i> Tambah Ruang Inap</a>
                            </div>
                        </div>
                        
                        <!--content ranap-->
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-12 table-responsive" id="contenRanap">
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /Portlet -->	
        </div>

        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12"> 
                    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                        <div id="portlet2" class="panel-collapse collapse in">
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-12" style="text-align:right;">
                                        <a href='#myModal' id="tambahPosRanap" data-toggle="modal" class='btn btn-success btn-rounded'><i class='fa fa-plus'></i> Tambah POS Ruang Inap</a>
                                    </div>
                                </div>
                                
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-md-12 table-responsive" id="contentPOSRanap">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- /Portlet -->
                </div>

                <div class="col-md-12"> 
                    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                        <div id="portlet2" class="panel-collapse collapse in">
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-12" style="text-align:right;">
                                        <a href='#myModal' id="tambahKelasRanap" data-toggle="modal" class='btn btn-success btn-rounded'><i class='fa fa-plus'></i> Tambah Kelas Ruang Inap</a>
                                    </div>
                                </div>
                                
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-md-12 table-responsive" id="contentKelasRanap">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- /Portlet -->
                </div>
            </div> 
        </div>
    </div>

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
                <button type="button" class="btn btn-primary" id="buttonSave">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id="modalDaftarRuang" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" id="userForm">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myLargeModalLabel">Nama Ruangan</h4>
                </div>
                <div class="modal-body" id="contentRuangInapDaftar">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="simpan">Save changes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

