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
            LAPORAN PERUBAHAN MODAL<br>
            <?php echo $periode; ?>
        </td>
    </tr>
</table>

<table class="table">
    <tr>
        <td colspan="2" style="font-weight:bold;">MODAL</td>
    </tr>   

    <tr>
        <td>Modal</td>
        <td style="text-align:right;"><?php echo number_format($modal,'0',',','.'); ?></td>
    </tr>

    <?php
        if($prive > 0){
    ?>
    <tr>
        <td>Prive</td>
        <td style="text-align:right;"><?php echo number_format($prive,'0',',','.'); ?></td>
    </tr>
    <?php } ?>

    <tr>
        <td>Laba Bersih</td>
        <td style="text-align:right;"><?php echo number_format($labaBersih,'0',',','.'); ?></td>
    </tr>

    <tr>
        <td>Modal akhir</td>
        <td style="text-align:right;"><?php echo number_format(($modal+$labaBersih)-$prive,'0',',','.'); ?></td>
    </tr>
</table>