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
            LAPORAN PEMAKAIAN OBAT<br>
            <?php echo $periode; ?>
        </td>
    </tr>
</table>

<table class="table table-bordered" style="margin-top:10px;">
    <thead>
        <tr style="font-weight:bold;">
            <td width="5%">No</td>
            <td width="15%">Kode Item</td>
            <td width="30%">Nama Item</td>
            <td width="15%">Harga</td>
            <td width="10%">Qty</td>
            <td>Satuan</td>
            <td width="15%" style="text-align:right;">Total</td>
        </tr>
    </thead>

    <tbody>
        <?php
            $i = 1;
            $total = 0;
            foreach($viewReport->result() as $row){
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row->id_produk; ?></td>
            <td><?php echo $row->nama_produk; ?></td>
            <td><?php echo number_format($row->harga,'0',',','.'); ?></td>
            <td><?php echo number_format($row->jumlah,0,',','.'); ?></td>
            <td><?php echo $row->satuan; ?></td>
            <td style="text-align:right;"><?php echo number_format($row->jumlah*$row->harga,'0',',','.'); ?></td>
        </tr>
        <?php $i++; $total = $total+($row->jumlah*$row->harga); } ?>
    </tbody>    
</table>

<table width="100%" style="margin-top:10px;">
    <tr style="border-bottom:double;">
        <td width="100%" style="font-weight:bold;font-size:14px;">GRAND TOTAL</td>
        <td style="text-align:right;font-weight:bold;font-size:14px;"><?php echo number_format($total,'0',',','.'); ?></td>
    </tr>
</table>