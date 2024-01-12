<div id="CssLoader" style="display: none;">
    <div class='spinftw'></div>
</div>

<div class="wraper container-fluid">
    <div class="page-title"> 
      <h3 class="title"><i class="fa fa-truck"></i> Purchase Order</h3> 
    </div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
            	<div class="row">
            		<div class="col-md-12" style="text-align: right;font-size:15px;"> 
            			<a href="<?php echo base_url('purchase_order/daftar_po'); ?>"><i class="fa fa-book"></i> Daftar PO</a>
            		</div>
            	</div>

            	<div class="row" style="margin-top: 20px;">
            		<div class="col-md-12">
                        <input type="hidden" id="sku" style="width:100%;"/>
            		</div>
            	</div> 
                
            	<div class="row" style="margin-top: 20px;">
            		<div class="col-md-6">
            			<div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control datepicker" placeholder="Jatun Tempo" id="jatuhTempo" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control datepicker" placeholder="Tanggal Kirim" id="tanggalKirim" readonly>
                            </div>
                        </div>

            			<div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-car"></i></span>
                                <select class="select2" id="supplier" required>
                                    <option value="">--Pilih Supplier--</option>
                                    <?php
                                        foreach($supplier->result() as $sp){
                                    ?>
                                    <option value="<?php echo $sp->id_supplier; ?>"><?php echo $sp->supplier; ?></option>
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

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-rocket"></i></span>
                                <textarea id="alamatPengiriman" class="form-control" placeholder="Alamat Pengiriman"></textarea>
                            </div>
                        </div>
            		</div>
            	</div>  

            	<div class="row" style="margin-top: 20px;">
                    <div class="col-md-12" style="text-align: right;">
                        <button class="btn btn-success btn-rounded" id="prosesPO"><i class="fa fa-save"></i> Simpan</button>
                    </div>

            		<div class="col-md-12" style="margin-top: 20px;">
		            		<table class="table table-bordered" style="font-size:12px;">
		            			<thead>
			            			<tr style="font-weight: bold;">
			            				<td width="15%">SKU</td>
			            				<td width="30%">Nama Produk</td>
			            				<td width="15%">Jumlah Beli</td>
			            				<td width="5%">Satuan</td>
                                        <td align="right" width="15%">Harga Satuan</td>
			            				<td align="right" width="15%">Total Harga</td>
			            				<td></td>
			            			</tr>
		            			</thead>

		            			<tbody id="data-input">
                                    <tr>
                                        <td colspan="7" align="center"><b>--BELUM ADA DATA TERINPUT--</b></td>
                                    </tr>
		            			</tbody>
		            		</table>
            		</div>
            	</div>      
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>
