<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
                <h3 class="title"><i class="fa fa-ambulance"></i> Master Tarif VK</h3> 
            </div>
        </div>

        <div class="col-md-6" style="text-align:right;">
            <a class='btn btn-info' id="tambah"><i class="fa fa-plus"></i> Tambah</a>
        </div>
    </div>
    

    <div class="portlet" style="border-top:solid 4px #03a9f4;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12 table-responsive" id="loadDatatables">
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>

<div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo base_url('tindakan/tarifVKSQL'); ?>" method="POST" id="userForm">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="tombol" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  

