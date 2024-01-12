<table width="100%">
    <tr style="border-bottom:solid 1px #ccc;">
        <td with="60%" style="font-size:14px;">
            <?php 
                echo "<b>".$header->namaKlinik."</b><br>";
                echo $header->alamat."<br>";
                echo "Telepon ".$header->telepon;
            ?>
        </td>
        <td style="text-align:right;vertical-align:bottom;font-weight:bold;">
            JURNAL UMUM<br>
            <?php echo $periode; ?>

        </td>
    </tr>
</table>

<div class="row" style="margin-top:10px;">
    <div class="col-md-12">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th style="width:8%;">Reff</th>
                    <th style="width:20%;text-align:right;">Debit</th>
                    <th style="width:20%;text-align:right;">Kredit</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    $totalDebit = 0;
                    $totalKredit = 0;
                    foreach($viewJurnal as $row){
                        $statusAccount = $row->kredit;
                ?>
                <tr>
                    <td><?php if(empty($statusAccount)){echo date_format(date_create($row->tanggal),'d/m/Y');} ?></td>
                    <td style="<?php if(!empty($statusAccount)){echo 'padding-left:40px;';} ?>"><?php echo $row->namaAkun; ?></td>
                    <td><?php echo $row->kodeAkun; ?></td>
                    <td style="text-align:right;">
                        <?php
                            if($row->debit != ''){
                                echo number_format($row->debit,'0',',','.');
                            } else {
                                echo "-";
                            }
                        ?>
                    </td>
                    <td style="text-align:right;">
                        <?php
                            if($row->kredit != ''){
                                echo number_format($row->kredit,'0',',','.');
                            } else {
                                echo "-";
                            }
                        ?>
                    </td>
                </tr>
                <?php 
                        $totalDebit = $totalDebit+$row->debit; 
                        $totalKredit = $totalKredit+$row->kredit;
                    } 
                ?>
            </tbody>

            <tfoot>
                <tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right;font-weight:bold;"><?php echo number_format($totalDebit,'0',',','.'); ?></td>
                        <td style="text-align:right;font-weight:bold;"><?php echo number_format($totalKredit,'0',',','.'); ?></td>
                    </tr>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
