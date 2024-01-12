<div class="wraper container-fluid">
    <div class="portlet"><!-- /primary heading -->        
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
            	<div class="row">
                    <div class="col-md-12" style="text-align: right;">
                        <a onclick="printContent('area-print')" class="btn btn-default"> <i class="fa fa-print"></i> Print </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" id="area-print">
                        <table width="100%" style="font-size: 12px;">

                            <tr>
                                <td style="text-align: center;">
                                <?php echo $header->namaKlinik; ?><br>
                                    <?php echo $header->alamat; ?> <br>
                                    Telepon. <?php echo $header->telepon; ?> <br>
                                    WASTE
                                </td>
                            </tr>
                        </table>

                        <table style="margin-top:5px;font-size: 12px;" width="100%">
                            <tr>
                                <td width="50%">
                                    <table width="100%">
                                    	<?php
                                    		foreach($info_waste->result() as $in){
                                    	?>	
                                    	<tr>
                                    		<td width="30%" style="font-weight: bold;">No Waste</td>
                                    		<td width="2%">:</td>
                                    		<td><?php echo $in->no_waste; ?></td>
                                    	</tr>

                                    	<tr>
                                    		<td style="font-weight: bold;">Tanggal Input</td>
                                    		<td>:</td>
                                    		<td><?php echo $in->tanggal_waste; ?></td>
                                    	</tr>

                                    	<tr>
                                    		<td style="font-weight: bold;">PIC</td>
                                    		<td>:</td>
                                    		<td><?php echo $in->nama_user; ?></td>
                                    	</tr>
                                    </table>
                                </td>

                                <td style="vertical-align: top;">
                                    <table width="100%">
                                        <tr>
                                            <td width="30%" style="font-weight: bold;">Jenis Waste</td>
                                            <td width="2%">:</td>
                                            <td><?php echo $in->tipe_waste; ?></td>
                                        </tr>

                                        <tr>
                                            <td width="30%" style="font-weight: bold;">Keterangan</td>
                                            <td width="2%">:</td>
                                            <td><?php echo $in->keterangan; ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <?php } ?>

                        <table style="font-size:12px;margin-top: 5px;border:solid 1px black;" width="100%">
                        	<tr style="font-weight: bold;border-bottom: solid 1px black;">
                                <td width="5%" align="center" style="border-right: solid 1px black;">No</td>
                                <td style="border-right: solid 1px black;">SKU</td>
                                <td style="border-right: solid 1px black;">Nama Produk</td>
                                <td width="8%" style="text-align: center;border-right: solid 1px black;">Qty</td>
                                <td width="8%" style="text-align: center;border-right: solid 1px black;">Satuan</td>
                                <td width="20%" style="text-align: right;border-right: solid 1px black;">Harga</td>
                                <td width="20%" style="text-align: right;">Subtotal</td>
                            </tr>

                            <?php
                            	$x=1;
                            	$total = 0;
                            	foreach($item_waste->result() as $dt){
                            	$total=$total+($dt->harga*$dt->qty);
                            ?>
                            <tr>
                            	<td style="text-align: center;border-right: solid 1px black;"><?php echo $x; ?></td>
                                <td style="border-right: solid 1px black;"><?php echo $dt->id_produk; ?></td>
                            	<td style="border-right: solid 1px black;"><?php echo $dt->nama_produk; ?></td>
                            	<td style="text-align: center;border-right: solid 1px black;"><?php echo $dt->qty; ?></td>
                            	<td style="text-align: center;border-right: solid 1px black;"><?php echo $dt->satuan; ?></td>
                            	<td align="right" style="border-right: solid 1px black;"><?php echo number_format($dt->harga,'0',',','.'); ?></td>
                            	<td align="right"><?php echo number_format($dt->harga*$dt->qty,'0',',','.'); ?></td>
                            </tr>
                            <?php $x++; } ?>

                            <tr style="font-weight: bold;border-top: solid 1px black;">
                            	<td colspan="6" align="center">TOTAL</td>
                            	<td align="right"><?php echo number_format($total,'0',',','.'); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->    
</div>
