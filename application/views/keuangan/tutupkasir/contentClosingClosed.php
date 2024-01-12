<div class="col-md-6">
    <div >
        <table style="width:100%;font-size:13px;">
            <tr>
                <td width="30%" style="font-weight:bold;">Nama Kasir</td>
                <td>
                    <?php echo $namaKasir->first_name." ".$namaKasir->last_name; ?>
                </td>
            </tr>

            <tr>
                <td style="font-weight:bold;">Tanggal</td>
                <td><?php echo date_format(date_create($tanggal),'d F Y'); ?></td>
            </tr>
        </table>
    </div>
</div>

<div class="col-md-6">
    <div>
        <table style="width:100%;font-size:13px;">
            <tr>
                <td width="30%" style="font-weight:bold;">No Closing</td>
                <td>
                    <?php echo $headerClosing->noClosing; ?>
                </td>
            </tr>

            <tr>
                <td width="30%" style="font-weight:bold;">Admin</td>
                <td>
                <?php echo $headerClosing->first_name." ".$headerClosing->last_name; ?>
                </td>
            </tr>

            <tr>
                <td style="font-weight:bold;">Tanggal Closing</td>
                <td><?php echo date_format(date_create($headerClosing->tanggalClosing),'d M Y H:i'); ?></td>
            </tr>
        </table>
    </div>
</div>

<div class="col-md-6">
    <table class="table">
        <thead>
            <tr>
                <th>Tipe Bayar</th>
                <th style="width:20%;text-align:right;">Total</th>
                <th style="width:20%;text-align:right;">Actual</th>
                <th style="width:20%;text-align:right;">Selisih</th>
            </tr>            
        </thead>

        <tbody>
            <tr>
                <td style="font-weight:bold;">Cash</td>
                <td style="text-align:right;">
                    <?php  
                        $totalCash = $this->modelKasir->pendapatanPerkasirPertipeBayar($tanggal,$idKasir,1);
                        echo number_format($totalCash,'0',',','.'); 
                    ?>
                </td>
                <td style="text-align:right;"> 
                    <?php
                        $cashActual = $this->modelKasir->pendapatanActual($noClosing,1,NULL);
                        echo number_format($cashActual,'0',',','.'); 
                    ?>
                </td>
                <td style="text-align:right;"><?php echo number_format($cashActual-$totalCash,'0',',','.'); ?></td>
            </tr>

            <tr>
                <td colspan="4" style="font-weight:bold;">Debit</td>
            </tr>
            
            <?php
                foreach($debit as $deb){
            ?>
            <tr>
                <td style="padding-left:30px;"><?php echo $deb->account; ?></td>
                <td style="text-align:right;">
                    <?php
                        $totalDebit = $this->modelKasir->pembayaranCardPerkasirPertipeBayar($tanggal,$idKasir,2,$deb->id_payment_account);
                        echo number_format($totalDebit,'0',',','.');
                    ?>
                </td>
                <td style="text-align:right;">
                    <?php
                        $debitActual = $this->modelKasir->pendapatanActual($noClosing,2,$deb->id_payment_account);
                        echo number_format($debitActual,'0',',','.'); 
                    ?>
                </td>
                <td style="text-align:right;">
                    <?php
                        echo number_format($debitActual-$totalDebit,'0',',','.'); 
                    ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="col-md-6">
    <table class="table">
        <thead>
            <tr>
                <th>Tipe Bayar</th>
                <th style="width:20%;text-align:right;">Total</th>
                <th style="width:20%;text-align:right;">Actual</th>
                <th style="width:20%;text-align:right;">Selisih</th>
            </tr>            
        </thead>

        <tbody>
            <tr>
                <td style="font-weight:bold;">Transfer</td>
                <td style="text-align:right;"> 
                    <?php
                        $totalTransfer = $this->modelKasir->pendapatanPerkasirPertipeBayar($tanggal,$idKasir,4);
                        echo number_format($totalTransfer,'0',',','.'); 
                    ?>
                </td>   
                <td style="text-align:right;">
                    <?php
                        $transferActual = $this->modelKasir->pendapatanActual($noClosing,4,NULL);
                        echo number_format($transferActual,'0',',','.'); 
                    ?></td>
                <td style="text-align:right;">
                    <?php
                        echo number_format($transferActual-$totalTransfer,'0',',','.');
                    ?>
                </td>
            </tr>

            <tr>
                <td colspan="4" style="font-weight:bold;">Kredit</td>
            </tr>

            <?php
                foreach($kredit as $kr){
            ?>
            <tr>
                <td style="padding-left:30px;"><?php echo $kr->account; ?></td>
                <td style="text-align:right;">
                    <?php
                        $totalKredit = $this->modelKasir->pembayaranCardPerkasirPertipeBayar($tanggal,$idKasir,3,$kr->id_payment_account);
                        echo number_format($totalKredit,'0',',','.');
                    ?>
                </td>
                <td style="text-align:right;">
                    <?php
                        $kreditActual = $this->modelKasir->pendapatanActual($noClosing,3,$kr->id_payment_account);
                        echo number_format($kreditActual,'0',',','.'); 
                    ?>
                </td>
                <td style="text-align:right;">
                    <?php
                        echo number_format($kreditActual-$totalKredit,'0',',','.');
                    ?>
                </td>
            </tr>
            <?php } ?>
        <tbody>
    </table>
</div>