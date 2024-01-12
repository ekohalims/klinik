<div id="CssLoader" style="display: none;">
    <div class='spinftw'></div>
</div>

<div class="wraper container-fluid">
    <div class="page-title"> 
      <h3 class="title"><i class="fa fa-car"></i> Retur Form</h3> 
      <h6><a href="<?php echo base_url('retur'); ?>">Retur</a> / <a href="<?php echo base_url('retur/returPO'); ?>"> Retur PO</a> / Retur Form</h6>
    </div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
            	<div class="row" style="font-weight: bold;">
            		<div class="col-md-6">
                        <table width="100%">
                            <tr>
                                <td width="25%">NO PO</td>
                                <td width="1%">:</td>
                                <td>
                                    <?php echo $infoPO->no_po; ?>
                                </td>
                            </tr>

                            <tr>
                                <td width="25%">Tanggal</td>
                                <td width="1%">:</td>
                                <td>
                                    <?php echo date_format(date_create($infoPO->tanggal_po),'d M Y'); ?>
                                </td>
                            </tr>

                            <tr>
                                <td width="25%">Jatuh Tempo</td>
                                <td>:</td>
                                <td>
                                    <?php echo date_format(date_create($infoPO->jatuh_tempo),'d M Y'); ?>
                                </td>
                            </tr>

                            <tr>
                                <td width="25%">Tanggal Kirim</td>
                                <td>:</td>
                                <td>
                                    <?php echo date_format(date_create($infoPO->tanggal_kirim),'d M Y'); ?>
                                </td>
                            </tr>
                        </table>
            		</div>

                    <div class="col-md-6">
                        <table width="100%">
                            <tr>
                                <td width="25%">Supplier</td>
                                <td width="1%">:</td>
                                <td><?php echo $infoPO->supplier; ?></td>
                            </tr>

                            <tr>
                                <td width="25%">Alamat Pengiriman</td>
                                <td>:</td>
                                <td><?php echo $infoPO->alamat_pengiriman; ?></td>
                            </tr>

                            <tr>
                                <td width="25%">Keterangan</td>
                                <td>:</td>
                                <td><?php echo $infoPO->keterangan; ?></td>
                            </tr>
                        </table>
                    </div>
            	</div> 
                 

            	<div class="row" style="margin-top: 20px;">
                    <form method="post" id="user_form">
                    <div class="col-md-12" style="text-align: right;">
                        <button class="btn btn-success btn-rounded" id="prosesRetur"><i class="fa fa-save"></i> Retur</button>
                        <input type="hidden" name="noPO" value="<?php echo $this->input->get('noPO'); ?>"/>
                    </div>

            		<div class="col-md-12" style="margin-top: 20px;">
		            		<table class="table table-bordered" style="font-size:12px;">
		            			<thead>
			            			<tr style="font-weight: bold;">
			            				<td>SKU</td>
			            				<td>Nama Produk</td>
                                        <td>Jumlah Beli</td>
                                        <td>Diterima</td>
                                        <td>Retur</td>
                                        <td>Expired Date</td>
			            				<td>Retur</td>
			            				<td>Satuan</td>
                                        <td align="right">Harga Satuan</td>
			            				<td align="right">Total Harga</td>
			            			</tr>
		            			</thead>

		            			<tbody id="data-input">
                                    <?php
                                        $i = 1;
                                        foreach($purchase_item as $row){
                                    ?>
                                    <tr>
                                        <td><?php echo $row->id_produk; ?></td>
                                        <td><?php echo $row->nama_produk; ?></td>
                                        <td align="center"><?php echo $row->qty; ?></td>
                                        <td align="center">
                                            <?php
                                                echo number_format($this->modelRetur->barangDiterima($row->id_produk,$infoPO->no_po),'0',',','.');
                                            ?>
                                        </td>
                                        <td align="center">
                                            <?php
                                                $qtyRetur = $this->modelRetur->returHistory($row->id_produk,$infoPO->no_po);
                                                echo number_format($qtyRetur,'0',',','.');
                                            ?>
                                        </td>
                                        <td align="center">
                                            <?php
                                                $cekIfHaveExpired = $this->modelRetur->cekIfHaveExpiredDate($row->id_produk);
                                                if($cekIfHaveExpired > 0){
                                            ?>
                                            <select class="form-control" id="expiredDate" name="expiredDate[]" style="width:100px;">
                                                <?php
                                                    $listExpiredDate = $this->modelRetur->listExpiredDate($row->id_produk);
                                                    foreach($listExpiredDate as $exp){
                                                ?>
                                                <option value="<?php echo $exp->expiredDate; ?>"><?php echo date_format(date_create($exp->expiredDate),'d M Y'); ?></option>
                                                <?php } ?>
                                            </select>
                                            <?php } else { ?>
                                                - <input type="hidden" id="expiredDate" name="expiredDate[]" value=""/>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <input type="hidden" name="idProduk[]" value="<?php echo $row->id_produk; ?>"/>
                                            <input type="number" class="form-control retur" name="retur[]" id="row<?php echo $i; ?>" data-id_produk="<?php echo $row->id_produk; ?>" data-row="<?php echo $i; ?>" style="width:80px;"/>
                                        </td>
                                        <td><?php echo $row->satuan; ?></td>
                                        <td align="right"><?php echo number_format($row->harga,'0',',','.'); ?></td>
                                        <td align="right"><?php echo number_format($row->total,'0',',','.'); ?></td>
                                    </tr>
                                    <?php $i++; } ?>
		            			</tbody>
		            		</table>
            		    </div>
                    </form>
            	</div>      
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>
