<div id="CssLoader" style="display: none;">
    <div class='spinftw'></div>
</div>

<div class="wraper container-fluid">
    <div class="page-title"> 
      <h3 class="title"><i class="fa fa-trash"></i> Waste</h3> 
    </div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-12">
                        <input type="hidden" id="sku" style="width: 100%;" />
                    </div>
                </div> 
                
                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-trash"></i></span>
                                <select class="select2" id="idWaste">
                                    <option value="">--Kategori Waste--</option>
                                    <?php
                                        foreach($keterangan_waste->result() as $ws){
                                    ?>
                                    <option value="<?php echo $ws->id_keterangan; ?>"><?php echo $ws->keterangan; ?></option>
                                    <?php } ?>
                            </select>
                            </div>      
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-list"></i></span>
                                <textarea id="keterangan" class="form-control" placeholder="Keterangan"></textarea>
                            </div>
                        </div>
                    </div>
                </div>  

                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-12">
                            <table class="table table-bordered" style="font-size:12px;">
                                <thead>
                                    <tr style="font-weight: bold;">
                                        <td>SKU</td>
                                        <td>Nama Produk</td>
                                        <td width="15%">Jumlah Waste</td>
                                        <td width="15%">Expired Date</td>
                                        <td width="15%">No Batch</td>
                                        <td width="15%">Satuan</td>
                                        <td width="5%"></td>
                                    </tr>
                                </thead>

                                <tbody id="data-input">
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="7" style="text-align: right;">
                                            <input type="submit" class="btn btn-primary" value="Submit" id="waste-click">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                    </div>
                </div>        
            </div>
        </div>
    </div> <!-- /Portlet -->    
</div>

<div class="modal fade bs-example-modal-sm" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="mySmallModalLabel">Update</h4>
            </div>
            
            <div class="modal-body" id="expiredDateContent">
            </div>
        </div>
    </div>
</div>
