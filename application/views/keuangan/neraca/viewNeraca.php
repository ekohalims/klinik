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
            NERACA SALDO<br>
            <?php echo $periode; ?>

        </td>
    </tr>
</table>

<br>
<table class='table table-bordered'>
    <thead>
        <tr>
            <th style="width:10%">Kode</th>
            <th>Akun</th>
            <th style="width:20%;text-align:center;">Debit</th>
            <th style="width:20%;text-align:center;">Kredit</th>
        </tr>
    </thead>

    <tbody>
        <?php
            $totalDebit = 0;
            $totalKredit = 0;
            foreach($akun as $row){
        ?>
        <tr>
            <td><?php echo $row->kodeAkun; ?></td>
            <td><?php echo $row->namaSubAkun; ?></td>
            <td style="text-align:right;">
                <?php 
                    $debit = $row->debit-$row->kredit;

                    if($debit > 0){
                        echo number_format($debit,'0',',','.'); 
                    }
                ?>
                </td>
            <td style="text-align:right;">
                <?php 
                    $kredit = $row->kredit-$row->debit;
                    if($kredit > 0){
                        echo number_format($kredit,'0',',','.'); 
                    }
                ?>
            </td>
        </tr>
        <?php 
                if($debit > 0){
                    $totalDebit = $totalDebit+$debit;
                }

                if($kredit > 0){
                    $totalKredit = $totalKredit+$kredit;
                }
            } 
        ?>
    </tbody>

    <tfoot>
        <tr>
            <td colspan="2" style="text-align:center;font-weight:bold;">TOTAL</td>
            <td style='text-align:right;font-weight:bold;'><?php echo number_format($totalDebit,'0',',','.'); ?></td>
            <td style='text-align:right;font-weight:bold;'><?php echo number_format($totalKredit,'0',',','.'); ?></td>
        </tr>
    </tfoot>
</table>