<div class="col-md-12" style="margin-bottom:10px;">

        <table style="width:100%;font-size:13px;">
            <tr>
                <td width="10%" style="font-weight:bold;">Nama Kasir</td>
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
            
<div class="col-md-6">
    <table class="table">
        <thead>
            <tr>
                <th>Tipe Bayar</th>
                <th>Total</th>
                <th width="40%">Actual</th>
            </tr>            
        </thead>

        <tbody>
            <tr>
                <td style="font-weight:bold;">Cash</td>
                <td>
                    <?php  
                        $totalCash = $this->modelKasir->pendapatanPerkasirPertipeBayar($tanggal,$idKasir,1);
                        echo number_format($totalCash,'0',',','.'); 
                    ?>
                </td>
                <td><input type="text" class="form-control" value="0" id="cash"/></td>
            </tr>

            <tr>
                <td colspan="3" style="font-weight:bold;">Debit</td>
            </tr>
            
            <?php
                foreach($debit as $deb){
            ?>
            <tr>
                <td style="padding-left:30px;"><?php echo $deb->account; ?></td>
                <td>
                    <?php
                        $totalDebit = $this->modelKasir->pembayaranCardPerkasirPertipeBayar($tanggal,$idKasir,2,$deb->id_payment_account);
                        echo number_format($totalDebit,'0',',','.');
                    ?>
                </td>
                <td><input type="text" class="form-control" value="0" id="debit" data-sub_account="<?php echo $deb->id_payment_account; ?>"/></td>
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
                <th>Total</th>
                <th width="40%">Actual</th>
            </tr>            
        </thead>

        <tbody>
            <tr>
                <td style="font-weight:bold;">Transfer</td>
                <td>
                    <?php
                        $totalTransfer = $this->modelKasir->pendapatanPerkasirPertipeBayar($tanggal,$idKasir,4);
                        echo number_format($totalTransfer,'0',',','.'); 
                    ?>
                </td>   
                <td><input type="text" class="form-control" value="0" id="transfer"/></td>
            </tr>

            <tr>
                <td colspan="3" style="font-weight:bold;">Kredit</td>
            </tr>

            <?php
                foreach($kredit as $kr){
            ?>
            <tr>
                <td style="padding-left:30px;"><?php echo $kr->account; ?></td>
                <td>
                    <?php
                        $totalKredit = $this->modelKasir->pembayaranCardPerkasirPertipeBayar($tanggal,$idKasir,3,$kr->id_payment_account);
                        echo number_format($totalKredit,'0',',','.');
                    ?>
                </td>
                <td><input type="text" class="form-control" value="0" id="kredit" data-sub_account="<?php echo $kr->id_payment_account; ?>"/></td>
            </tr>
            <?php } ?>
        <tbody>
    </table>
</div>