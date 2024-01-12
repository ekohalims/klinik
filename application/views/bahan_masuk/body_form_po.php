<div class="wraper container-fluid">
    <div class="portlet"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12" style="text-align: right;">
                        <a onclick="printContent('area-print')" class="btn btn-default"> <i class="fa fa-print"></i> Print </a>
                        
                        <?php
                            if($this->uri->segment(1) != 'bahan_masuk'){
                        ?>    
                        <a class="btn btn-info sendEmail" id="<?php echo $_GET['no_po']; ?>" data-idsupplier="<?php echo $idSupplier?>"> <i class="fa fa-envelope"></i> Send By Email </a>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" id="area-print" style="padding:5px;font-size: 13px;">
                        <table width="100%">

                            <tr>
                                <td style="text-align: center;">
                                    <?php echo $header->namaKlinik; ?><br>
                                    <?php echo $header->alamat; ?> <br>
                                    Telepon. <?php echo $header->telepon; ?> <br>
                                    PURCHASE ORDER
                                </td>
                            </tr>
                        </table>

                        <table width="100%" style="margin-top: 5px;font-size: 12px;">
                            <tr>
                                <td width="50%">
                                    <table width="100%">
                                        <tr>
                                            <td style="width: 15%;">Tanggal</td>
                                            <td style="width: 1%;">:</td>
                                            <td>
                                                <?php
                                                    $date_po = date_create($tanggal_po);

                                                    echo date_format($date_po,'d M Y');
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="width: 15%;">No PO</td>
                                            <td style="width: 1%;">:</td>
                                            <td><?php echo $_GET['no_po']; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width: 15%;">Keterangan</td>
                                            <td style="width: 1%;">:</td>
                                            <td><?php echo $keterangan; ?></td>
                                        </tr>
                                                                            
                                    </table>
                                </td>

                                <td>
                                    <table width="100%">
                                        <tr>
                                            <td style="width: 25%;">Supplier</td>
                                            <td style="width: 1%;">:</td>
                                            <td>
                                                <?php echo $supplier; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="width: 25%;">Tanggal Pengiriman</td>
                                            <td style="width: 1%;">:</td>
                                            <td>
                                                <?php
                                                    $date_send = date_create($tanggal_kirim);

                                                    echo date_format($date_send,'d M Y');
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="width: 25%;">Dikirim Ke</td>
                                            <td style="width: 1%;">:</td>
                                            <td>
                                                <?php echo $alamat_pengiriman; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <table style="margin-top: 5px;width: 100%;border:solid 1px black;font-size: 12px;">
                            <tr style="font-weight: bold;border-bottom: solid 1px black;">
                                <td width="5%" style="border-right: solid 1px black;text-align: center;">No</td>
                                <td style="border-right: solid 1px black;padding-left: 1px;">SKU</td>
                                <td style="border-right: solid 1px black;padding-left: 1px;">Nama Produk</td>
                                <td width="8%" style="text-align: center;border-right: solid 1px black;">Qty</td>
                                <td width="8%" style="text-align: center;border-right: solid 1px black;">Satuan</td>

                                <?php
                                    $uri = $this->uri->segment(1);

                                    if($uri!='bahan_masuk'){
                                ?>
                                <td width="20%" style="text-align: right;border-right: solid 1px black;padding-right: 1px;">Harga Satuan</td>
                                <td width="20%" style="text-align: right;border-right:solid 1px black;padding-right: 1px;">Total</td>
                                <?php } ?>
                            </tr>

                            <?php
                                $i=1;
                                $value = 0;
                                foreach($purchase_item->result() as $row){
                            ?>
                            <tr>
                                <td style="border-right: solid 1px black;text-align: center;"><?php echo $i; ?></td>
                                <td style="border-right: solid 1px black;padding-left: 1px;"><?php echo $row->id_produk; ?></td>
                                <td style="border-right: solid 1px black;padding-left: 1px;"><?php echo $row->nama_produk; ?></td>
                                <td style="text-align: center;border-right: solid 1px black;"><?php echo $row->qty; ?></td>
                                <td style="text-align: center;border-right: solid 1px black;"><?php echo $row->satuan; ?></td>
                                <?php
                                    $uri = $this->uri->segment(1);

                                    if($uri!='bahan_masuk'){
                                ?>
                                <td style="text-align: right;border-right: solid 1px black;padding-right: 1px;"><?php echo number_format($row->harga,'0',',','.'); ?></td>
                                <td style="text-align: right;border-right: solid 1px black;padding-right: 1px;"><?php echo number_format($row->total,'0',',','.'); ?></td>
                                <?php } ?>
                            </tr>
                            <?php $value = $value+$row->total; $i++; } ?>

                            <?php
                                    $uri = $this->uri->segment(1);

                                    if($uri!='bahan_masuk'){
                            ?>
                            <tr style="font-weight: bold;border-top:solid 1px black;">
                                <td colspan="6" style="text-align: center;font-weight: bold;">TOTAL</td>
                                <td style="text-align: right;"><?php echo number_format($value,'0',',','.'); ?></td>
                            </tr>

                            <?php } ?>
                        </table>

                        <center>
                        <table style="margin-top: 10px;font-size: 12px;" width="70%">
                            <tr>
                                <td width="33.3%">
                                    <table style="width: 90%">
                                        <tr style="font-weight: bold;">
                                            <td style="text-align: center;">Prepared By</td>
                                        </tr>
                                        <tr height="10px">
                                            <td>
                                                
                                            </td>
                                        </tr>  
                                        <tr height="10px">
                                            <td style="border-bottom: solid 1px black;">
                                               
                                            </td>
                                        </tr> 
                                    </table>
                                </td>

                                <td width="33.3%">
                                    <table style="width: 90%;">
                                        <tr style="font-weight: bold;">
                                            <td style="text-align: center;">Verified By</td>
                                        </tr>
                                        <tr height="10px">
                                            <td>
                                                
                                            </td>
                                        </tr>
                                        <tr height="10px" style="border-bottom: solid 1px black;">
                                            <td></td>
                                        </tr>
                                    </table>
                                </td>

                                <td width="33.3%">
                                    <table style=";width: 90%;">
                                        <tr style="font-weight: bold;">
                                            <td style="text-align: center;">Approve By</td>
                                        </tr>
                                        <tr height="10px">
                                            <td>
                                                
                                            </td>
                                        </tr>
                                        <tr height="10px">
                                            <td style="border-bottom: solid 1px black;"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        </center>
                    </div>
                </div>    
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>
