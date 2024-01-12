<div class="row">
    <div class="col-md-12">
    <h5 style="text-align:right;font-weight:bold;">Tanggal : <?php echo date_format(date_create($tanggal),'d/m/Y'); ?></h5>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width:5%;vertical-align:middle;" rowspan="2">No</th>
                    <th rowspan="2" style="vertical-align:middle;">Nama</th>
                    <th colspan="4" style="text-align:center;">Pemasukan</th>
                    <th rowspan="2" style="text-align:right;vertical-align:middle;">Total</th>
                    <th rowspan="2" style="vertical-align:middle;">Status</th>
                </tr>

                <tr>
                    <th style="text-align:right;">Cash</th>
                    <th style="text-align:right;">Debit</th>
                    <th style="text-align:right;">Kredit</th>
                    <th style="text-align:right;">Transfer</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    $i = 1;
                    $totalCashT = 0;
                    $totalDebitT = 0;
                    $totalKreditT = 0;
                    $totalTransferT = 0;
                    foreach($pemasukan as $row){
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><a href="<?php echo base_url('tutupKasir/formClosing/'.$row->id.'/'.$tanggal); ?>"><?php echo $row->first_name." ".$row->last_name; ?></a></td>
                    <td style="text-align:right;">
                        <?php
                            $totalCash = $this->modelKasir->pendapatanPerkasirPertipeBayar($tanggal,$row->id,1);
                            echo number_format($totalCash,'0',',','.');
                        ?>
                    </td>
                    <td style="text-align:right;">
                        <?php
                            $totalDebit = $this->modelKasir->pendapatanPerkasirPertipeBayar($tanggal,$row->id,2);
                            echo number_format($totalDebit,'0',',','.');
                        ?>
                    </td>
                    <td style="text-align:right;">
                        <?php
                            $totalKredit = $this->modelKasir->pendapatanPerkasirPertipeBayar($tanggal,$row->id,3);
                            echo number_format($totalKredit,'0',',','.');
                        ?>
                    </td>
                    <td style="text-align:right;">
                        <?php
                            $totalTransfer = $this->modelKasir->pendapatanPerkasirPertipeBayar($tanggal,$row->id,4);
                            echo number_format($totalTransfer,'0',',','.');
                        ?></td>
                    <td style="text-align:right;">
                        <?php
                            $grandTotal = $totalCash+$totalDebit+$totalKredit+$totalTransfer;
                            
                            echo number_format($grandTotal,'0',',','.');
                        ?>
                    </td>
                    <td>
                        <?php
                            $statusClosing = $this->modelKasir->statusClosing($tanggal,$row->id);

                            if($statusClosing < 1){
                                echo "<span class='label label-danger'>Belum Closing</span>";
                            } else {
                                echo "<span class='label label-success'>Sudah Closing</span>";
                            }
                        ?>
                    </td>
                </tr>
                <?php 
                        $totalCashT = $totalCashT+$totalCash;
                        $totalDebitT = $totalDebitT+$totalDebit;
                        $totalKreditT = $totalKreditT+$totalKredit;
                        $totalTransferT = $totalTransferT+$totalTransfer; 
                        $i++; 
                    } 
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="font-weight:bold;text-align:center;">TOTAL</td>
                    <td style="font-weight:bold;text-align:right;"><?php echo number_format($totalCashT,'0',',','.'); ?></td>
                    <td style="font-weight:bold;text-align:right;"><?php echo number_format($totalDebitT,'0',',','.'); ?></td>
                    <td style="font-weight:bold;text-align:right;"><?php echo number_format($totalKreditT,'0',',','.'); ?></td>
                    <td style="font-weight:bold;text-align:right;"><?php echo number_format($totalTransferT,'0',',','.'); ?></td>
                    <td style="font-weight:bold;text-align:right;">
                        <?php
                            echo number_format($totalCashT+$totalDebitT+$totalKreditT+$totalTransferT,'0',',','.');
                        ?>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>