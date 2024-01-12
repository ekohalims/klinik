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
            LAPORAN LABA RUGI<br>
            <?php echo $periode; ?>
        </td>
    </tr>
</table>

<table class="table">
    <tr>
        <td colspan="2" style="font-weight:bold;">Pendapatan</td>
    </tr>

    <?php
        $totalPendapatan = 0;
        foreach($pendapatanUsaha as $pdt){
            $debit = $pdt->debit;
            $kredit = $pdt->kredit;
    ?>

    <tr>
        <td style="padding-left:30px;"><?php echo $pdt->namaSubAkun; ?></td>
        <td style="text-align:right;">
            <?php

                echo number_format($kredit-$debit,'0',',','.');
            ?>
        </td>
    </tr>
    <?php $totalPendapatan = $totalPendapatan+($pdt->kredit-$pdt->debit); } ?>

    <tr>
        <td style="padding-left:30px;font-weight:bold;">TOTAL PENDAPATAN</td>
        <td style="text-align:right;font-weight:bold;">
            <?php
                echo number_format($totalPendapatan,'0',',','.');
            ?>
        </td>
    </tr>
    
    <tr>
        <td colspan="2" style="font-weight:bold;">Harga Pokok Penjualan</td>
    </tr>

    <tr>
        <td style="padding-left:30px;">Persediaan Awal</td>
        <td style="text-align:right;">
            <?php
                echo number_format($persediaanAwal,'0',',','.');
            ?>
        </td>
    </tr>

    <tr>
        <td style="padding-left:30px;">Pembelian</td>
        <td style="text-align:right;">
            <?php 
                $totalPembelian = ($totalHPP+$persediaanAkhir)-$persediaanAwal;
                echo number_format($totalPembelian,'0',',','.'); 
            ?>
        </td>
    </tr>

    <tr>
        <td style="padding-left:30px;">Barang yang tersedia untuk dijual</td>
        <td style="text-align:right;">
            <?php
                echo number_format($persediaanAwal+$totalPembelian,'0',',','.');
            ?>
        </td>
    </tr>

    <tr>
        <td style="padding-left:30px;">Persediaan Akhir</td>
        <td style="text-align:right;">
            <?php
                echo number_format($persediaanAkhir,'0',',','.');
            ?>
        </td>
    </tr>

    <tr>
        <td style="font-weight:bold;">HPP</td>
        <td style="text-align:right;">
            <?php
                echo number_format($totalHPP,'0',',','.');
            ?>
        </td>
    </tr>

    <tr>
        <td style="font-weight:bold;">Laba Kotor</td>
        <td style="text-align:right;font-weight:bold;">
            <?php
                $labaKotor = $totalPendapatan-$totalHPP;
                echo number_format($labaKotor,'0',',','.');
            ?>
        </td>
    </tr>
    
    <tr>
        <td colspan="2" style="font-weight:bold;">Beban</td>
    </tr>

    <?php
        $totalDebit = 0;
        $totalKredit = 0;
        foreach($beban as $dt){
    ?>
    <tr>
        <td style="padding-left:30px;"><?php echo $dt->namaSubAkun; ?></td>
        <td style="text-align:right;"><?php echo number_format($dt->debit-$dt->kredit,'0',',','.'); ?></td>
    </tr>
    <?php 
        $totalDebit = $totalDebit+$dt->debit;
        $totalKredit = $totalKredit+$dt->kredit;
        } 
    ?>

    <tr>
        <td style="padding-left:30px;font-weight:bold;">TOTAL BEBAN</td>
        <td style="text-align:right;">
            <?php
                $totalBeban = $totalDebit-$totalKredit;
                echo number_format($totalBeban,'0',',','.');
            ?>
        </td>
    </tr>

    <tr>
        <td style="font-weight:bold;">LABA/RUGI</td>
        <td style="text-align:right;font-weight:bold;">
            <?php
                $totalLabaRugi = $labaKotor-$totalBeban;
                echo number_format($totalLabaRugi,'0',',','.');
            ?>
        </td>
    </tr>
</table>