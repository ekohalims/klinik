<div class="wraper container-fluid">
    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->    
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
            	<div class="row">
	                <div class="col-md-12" style="text-align: right;">
	                    <!--<a onclick="printContent('area-print')" class="btn btn-default"><i class="fa fa-print"></i> Print </a>-->
	                    <?php
	                    	$no_po 		= $_GET['no_po']; 
                        	$status_po 	= $this->modelBahanMasukMaterial->status_po($no_po);
                        	
                        	if($status_po < 1){
                        ?>
	                    <a onclick="return confirm('Are You Sure ?')" href="<?php echo base_url('bahan_masuk/change_po_status?status=1'.'&no_po='.$_GET['no_po']); ?>" class="btn btn-success btn-rounded"><i class="fa fa-check"></i> Accept </a>
	                    <a onclick="return confirm('Are You Sure ?')" href="<?php echo base_url('bahan_masuk/change_po_status?status=2'.'&no_po='.$_GET['no_po']); ?>" class="btn btn-danger btn-rounded"><i class="ion-close"></i> Decline </a>
	                	<?php } ?>

                        <?php
                            if($status_po==1){
                        ?>
                            <a class='btn btn-success btn-rounded' onclick="return confirm('Are You Sure Close This Transaction ?')" href="<?php echo base_url('bahan_masuk/change_po_status?status=3'.'&no_po='.$_GET['no_po']); ?>"><i class='fa fa-power-off'></i> Tutup Transaksi </a>
                        <?php   
                            }
                        ?>
	                </div>
                </div>

                <div class="row">
                	<div class="col-md-12">
                		<table width="100%">

                            <tr>
                                <td style="text-align: center;">
                                    <?php echo $header->namaKlinik; ?><br>
                                    <?php echo $header->alamat; ?> <br>
                                    Telepon. <?php echo $header->telepon; ?> <br>
                                    <h5>Goods Received Note</h5>
                                </td>
                            </tr>

                        </table>

                        <table width="100%" style="margin-top: 30px;">
                            <tr>
                                <td width="50%">
                                    <table width="100%">
                                        <tr>
                                            <td style="font-weight:  bold;width: 15%;">Date</td>
                                            <td style="width: 3%;">:</td>
                                            <td>
                                                <?php
                                                    $date_po = date_create($noteInfo->tanggal_po);

                                                    echo date_format($date_po,'d M Y');
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="font-weight:  bold;width: 15%;">No PO</td>
                                            <td style="width: 3%;">:</td>
                                            <td><?php echo $_GET['no_po']; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="font-weight:  bold;width: 15%;">Status</td>
                                            <td style="width: 3%;">:</td>
                                            <td>
                                            	<?php
                                            		$no_po 		= $_GET['no_po']; 
                                            

                                            		if($status_po==0){
			                                            echo "<span class='label label-primary'>Menunggu Approve</span>";
			                                        } elseif($status_po=='1') {
			                                            echo "<span class='label label-success'>Diterima</span>";
			                                        } elseif($status_po=='2') {
			                                            echo "<span class='label label-danger'>Ditolak</span>";
			                                        } elseif($status_po=='3'){
                                                         echo "<span class='label label-info'>Transaksi Selesai</span>";
                                                    }
                                            	?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                                <td>
                                    
                                </td>
                            </tr>
                        </table>

                        <table style="margin-top: 20px;" width="100%">
                            <tr>
                                <td width="50%">
                                    <table class="table table-bordered" style="font-size: 12px;">
                                        <tr style="font-weight: bold;">
                                            <td>Nama Perusahaan</td>
                                        </tr>
                                        
                                        <tr height="100px">
                                            <td>
                                            <?php echo $header->namaKlinik; ?><br>
                                    <?php echo $header->alamat; ?> <br>
                                    Telepon. <?php echo $header->telepon; ?> <br>
                                            </td>
                                        </tr>
                                       
                                    </table>
                                </td>

                                <td width="50%">
                                    <table class="table table-bordered" style="font-size: 12px;">
                                        <tr style="font-weight: bold;">
                                            <td>Vendor / Supplier</td>
                                        </tr>
                                        
                                        <tr height="100px">
                                            <td>
                                                <b><?php echo $noteInfo->supplier; ?></b> <br>
                                                <?php echo $noteInfo->alamat; ?> <br>
                                                <?php echo $noteInfo->kontak; ?>
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>
                        </table>

                        <table class="table table-bordered" style="margin-top: 20px;font-size:12px;">
                            <thead>
                                <tr style="font-weight: bold;">
                                    <td width="5%" align="center">No</td>
                                    <td width="15%">SKU</td>
                                    <td width="25%">Nama Produk</td>
                                    <td width="8%" style="text-align: center;">Jumlah Order</td>
                                    <td width="10%" style="text-align: center;">Order Diterima</td>
                                    <td width="8%" style="text-align: center;">Sisa</td>
                                    <td width="8%" style="text-align: center;">Satuan</td>
                                    <!--<td width="14%" style="text-align: right;">Unit Price</td>
                                    <td width="14%" style="text-align: right;">Ext Price</td>-->
                                </tr>
                            </thead>

                            <tbody id="detailOrder">
                                
                            </tbody>
                        
                        </table>

                        <table class="table table-bordered" style="font-size: 12px;margin-top: 20px;">
                            <tr style="font-weight: bold;">
                                <td style="text-align: left;">Alamat Pengiriman</td>
                            </tr>

                            <tr>
                                <td>
                                    <ul>
                                        <li>Alamat Pengiriman : <?php echo $noteInfo->alamat_pengiriman; ?></li>
                                        <li>Tanggal Pengiriman : <?php
                                                    $date_send = date_create($noteInfo->tanggal_kirim);

                                                    echo date_format($date_send,'d M Y');
                                                ?></li>
                                    </ul>
                                </td>
                            </tr>
                        </table>

                        <?php 
                            if($status_po=='1'){
                        ?>
                        <table class="table table-bordered" style="font-size: 12px;margin-top: 20px;">
                            <tr style="font-weight: bold;">
                                <td style="text-align: left;">Good Receive</td>
                                <td style="text-align: left;">Riwayat Penerimaan</td>
                            </tr>

                            <tr>
                                <td>
                                    <form method="post" id="user_form"> 
	                                    <table class="table">
	                                    	<tr style="font-weight: bold;">
                                                <td>SKU</td>
	                                    		<td>Nama Produk</td>
                                                <td>Produk Diterima</td>
                                                <td>Tanggal Expired</td>
                                                <td>No Batch</td>
	                                    		<td>Satuan</td>
	                                    		<!--<td width="15%">Unit Price</td>-->
	                                    	</tr>

	                                    	<?php
                                                $y = 1;
				                                foreach($purchase_item->result() as $dt){
				                            ?>
	                                    	<tr>
                                                <td style="vertical-align: middle;"><?php echo $dt->id_produk; ?></td>
	                                    		<td style="vertical-align: middle;"><?php echo $dt->nama_produk; ?></td>
	                                    		<td>
	                                    			<input type="number" name='qty[]' id="qtyProduk<?php echo $y; ?>" data-urut="<?php echo $y; ?>" data-id="<?php echo $dt->id_produk; ?>" data-max="<?php echo $dt->qty; ?>" min="0" class="form-control qtyAjax" value="0"/>
                                                    <input type="hidden" name="id[]" value="<?php echo $dt->id_produk; ?>"/>
                                            	</td>
                                                <td>
                                                    <input type="text" class="form-control datepicker" name="tanggalExpired[]" readonly/>
                                                </td>

                                                <td><input type="text" class="form-control" name="noBatch[]"/></td>

                                                <td><?php echo $dt->satuan; ?></td>
	                                    	</tr>
	                                    	<?php $y++; } ?>

	                                    	<tr>
	                                    		<td colspan="3"><b>Diterima Oleh</b> <label id="diterimaAlert" style="color: red;"></label></td>
	                                    		<td colspan="3">
                                                    <input type="hidden" name="noPO" id="noPo" value="<?php echo $_GET['no_po']; ?>"/>
                                                    <input type="hidden" name="idSupplier" id="idSupplier" value="<?php echo $noteInfo->id_supplier; ?>"/>
	                                    			<input type="text" class="form-control" name="diterimaOleh" id="diterimaOleh" required>
	                                    		</td>
	                                    	</tr>

	                                    	<tr>
	                                    		<td colspan="3"><b>Diperiksa Oleh</b> <label id="diperiksaAlert" style="color: red;"></label></td>
	                                    		<td colspan="3"><input type="text" class="form-control" name="diperiksaOleh" id="diperiksaOleh" required></td>
	                                    	</tr>

	                                    	<tr>
	                                    		<td colspan="3"><b>Tanggal Kedatangan</b></td>
	                                    		<td colspan="3"><input type="text" class="form-control" name="tanggalTerima" id="tanggalTerima" value="<?php echo date('Y-m-d'); ?>" readonly> <input type="hidden" name="diterimaDi" id="diterimaDi" value="0"/></td>
	                                    	</tr>
                                        </table>
                                        
                                        <table class="table" width="100%" id="payment">
                                            
                                        </table>

                                        <table width="100%">
	                                    	<tr>
	                                    		<td colspan="4" align="right"><button type="submit" id="submitPenerimaan" class="btn btn-primary">Submit</button></td>
	                                    	</tr>
	                                    </table>
                                    </form>
                                </td>

                                <td width="40%">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>SKU</th>
                                                <th>Nama Produk</th>
                                                <th>Tanggal</th>
                                                <th>Qty</th>
                                            </tr>
                                        </thead>

                                        <tbody id="riwayatPenerimaan">
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <?php } ?>

                        <table class="table table-bordered" style="font-size: 12px;margin-top: 20px;">
                            <tr style="font-weight: bold;">
                                <td style="text-align: left;">Invoice Penerimaan</td>
                            </tr>

                            <tr>
                                <td>
                                	<table class="table" style="font-size:12px;">
                                        <thead>
                                    		<tr>
                                    			<th width="5%">No</th>
                                    			<th width="25%">No Receive</th>
                                    			<th>Tanggal Terima</th>
                                    			<th>Diterima Oleh</th>
                                    			<th>Diperiksa Oleh</th>
                                                <th>Diterima Di</th>
                                    		</tr>
                                        </thead>

                                        <tbody id="invoiceReceive">
                                        </tbody>
                                        
                                	</table>
                                </td>
                            </tr>
                        </table>
                	</div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->    
</div>
