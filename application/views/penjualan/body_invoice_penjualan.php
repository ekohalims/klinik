<div class="wraper container-fluid">
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-6">
            <a href="<?php echo base_url('penjualan'); ?>" class="btn btn-info btn-rounded"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>

    </div>

    <div class="panel panel-default" >
        <div class="panel-body" id="print-area">
            <div class="hidden-print">
                <div class="pull-right">
                    <a href="#" onclick="printContent('print-area')" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                </div>
            </div>

            <div class="row">
                <div class= "col-md-12" id="dataContent">
                    <!--<img src="<?php echo base_url('assets/Batik-Salma-Cirebon.png'); ?>" style="margin-left:auto;margin-right:auto;display:block;height:80px;"/>-->
                    <?php
                        foreach($receipt->result() as $cf){
                    ?>
                    <h5 align="center"><?php echo $cf->namaKlinik; ?></h5>
                    <h5 align="center"><?php echo $cf->alamat; ?></h5>
                    <h5 align="center"><?php echo $cf->telepon; ?></h5>
                     
                    <center>
                    <table>
                        <tr style="border-top:dashed 1px #000;">
                            <td width="160px"></td>
                            <td width="20px"></td>
                            <td width="80px" align="right"></td>
                            <td align="right" width="80px"></td>
                        </tr>

                        <?php
                            foreach($no_invoice->result() as $ket){
                                $pay_type = $ket->tipe_bayar;
                                $account_bank = $ket->account;
                            }

                            $jumlah_item = 0;
                            $diskon_peritem = 0;
                            $item = 0;
                            foreach($invoice_item->result() as $dt){
                        ?>
                        <tr>
                            <td colspan="4"><?php echo $dt->nama_produk; ?></td> 
                        </tr>

                        <tr>
                            <td style="vertical-align:top;" colspan="2"><?php echo number_format($dt->harga_jual,'0',',','.'); ?></td>
                            <td style="vertical-align:top;" align="right">x <?php echo $dt->qty; ?></td>
                            <td align="right" style="vertical-align:top;"><?php echo number_format(($dt->harga_jual*$dt->qty),'0',',','.')?></td>    
                        </tr>

                        <?php
                            if($dt->diskon > 0){
                        ?>
                        <tr>
                            <td colspan="3" align="right">Diskon</td>
                            <td align="right">(<?php echo number_format($dt->diskon,'0',',','.'); ?>)</td>
                        </tr>
                        <?php 
                            $jumlah_item = $jumlah_item + $dt->qty;
                        } ?>

                        <!-- END DISKON-->

                        <?php $item = $item + $dt->qty; $diskon_peritem = $diskon_peritem + $dt->diskon; } ?>

                        <?php } ?>

                        <?php
                            foreach($no_invoice->result() as $st){
                        ?>

                        <tr style="border-top:dashed 1px #000;">
                            <td colspan="3" align="CENTER">Total Item</td>
                            <td align="right"><?php echo $item_barang;  ?></td>
                        </tr>

                        <tr>
                            <td colspan="3" align="CENTER">Qty</td>
                            <td align="right"><?php echo $qty_barang; ?></td>
                        </tr>

                        <tr>
                            <td colspan="3" align="CENTER">Subtotal</td>
                            <td align="right"><?php echo number_format($st->total-$diskon_peritem,'0',',','.'); ?></td>
                        </tr>
                        
                        <?php
                            if(!empty($st->ongkir)){
                        ?>    
                        <tr>
                            <td colspan="3" align="CENTER">Ongkir</td>
                            <td align="right"><?php echo number_format($st->ongkir,'0',',','.'); ?></td>
                        </tr>          
                        <?php } ?>

                        <?php
                            if($pajak > 0){
                        ?>    
                        <tr>
                            <td colspan="3" align="CENTER">PPN 10%</td>
                            <td align="right"><?php echo number_format($pajak,'0',',','.'); ?></td>
                        </tr>          
                        <?php } ?>

                        <?php
                            if(!empty($st->diskon)){
                        ?>    
                        <tr>
                            <td colspan="3" align="CENTER">Diskon Member</td>
                            <td align="right"><?php echo number_format($st->diskon,'0',',','.'); ?></td>
                        </tr>          
                        <?php } ?>

                        <?php
                            if(!empty($st->diskon_free)){
                        ?>    
                        <tr>
                            <td colspan="3" align="CENTER">Diskon</td>
                            <td align="right"><?php echo number_format($st->diskon_free,'0',',','.'); ?></td>
                        </tr>          
                        <?php } ?>

                        <?php
                            if(!empty($st->poin_value)){
                        ?>    
                        <tr>
                            <td colspan="3" align="CENTER">Poin Reimburs</td>
                            <td align="right"><?php echo number_format($st->poin_value,'0',',','.'); ?></td>
                        </tr>          
                        <?php } ?>

                        <tr>
                            <td colspan="3" align="CENTER">Grand Total</td>
                            <td align="right" style="border-top:dashed 1px #000;"><?php echo number_format(($st->ongkir+$st->total+$pajak)-($st->diskon+$st->diskon_free+$st->poin_value+$diskon_peritem),'0',',','.'); ?></td>
                        </tr> 

                        <tr>
                            <td colspan="3" align="CENTER"><?php echo $tipe_bayar; ?></td>
                            <td align="right" style="border-top:dashed 1px #000;"><?php echo number_format($st->jumlah_bayar,'0',',','.'); ?></td>
                        </tr>
                        
                        <?php
                            if($tipe_bayar != 'Hutang '){
                        ?>
                        <tr>
                            <td colspan="3" align="CENTER">Kembali</td>
                            <td align="right" style="border-top:dashed 1px #000;"><?php echo number_format($st->jumlah_bayar-(($st->ongkir+$st->total)-($st->diskon+$st->diskon_free+$st->poin_value+$diskon_peritem)),'0',',','.'); ?></td>
                        </tr>
                        <?php } ?>

                        <?php } ?>

                        <tr style="border-top: dashed 1px #000;">
                            <td colspan="4" align="center">
                                <?php echo $_GET['no_invoice']." | ".date_format(date_create($st->tanggal),'dmy')." | ".date_format(date_create($st->tanggal),'H:i:s'); ?>
                                <br>
                                <?php echo $nama_kasir;?>  
                            </td>
                        </tr>
                        
                        <tr style="border-top: dashed 1px #000;">
                            <td colspan="4" align="center"><?php echo $cf->footer; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
