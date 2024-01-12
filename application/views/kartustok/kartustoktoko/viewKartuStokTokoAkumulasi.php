<table class='table table-striped'>
    <thead>
        <tr>
            <th style="width:5%;text-align:center;">No</th>
            <th>Kode Item</th>
            <th>Nama Item</th>
            <th style="width:10%;text-align:center;">Stok Awal</th>
            <th style="width:10%;text-align:center;">Masuk</th>
            <th style="width:10%;text-align:center;">Keluar</th>
            <th style="width:10%;text-align:center;">Retur</th>
            <th style="width:10%;text-align:center;">Stok Akhir</th>
        </tr>
    </thead>

    <tbody>
        <?php
            $i = 1;
            foreach($viewData->result() as $row){
        ?>
        <tr>
            <td style="text-align:center;"><?php echo $i; ?></td>
            <td><?php echo $row->idProduk;?></td>
            <td><?php echo $row->nama_produk; ?></td>
            <td style="text-align:center;"><?php echo number_format($row->currentStok,'0',',','.'); ?></td>
            <td style="text-align:center;"><?php echo number_format($row->totalBarangMasuk,'0',',','.'); ?></td>
            <td style="text-align:center;"><?php echo number_format($row->totalBarangKeluar,'0',',','.'); ?></td>
            <td style="text-align:center;"><?php echo number_format($row->totalRetur,'0',',','.'); ?></td>
            <td style="text-align:center;">
                <?php
                    $stokAkhir = ($row->currentStok+$row->totalBarangMasuk)-($row->totalBarangKeluar+$row->totalRetur);
                    echo number_format($stokAkhir,'0',',','.');
                ?>
            </td>
        </tr>
        <?php $i++; } ?>
    </tbody>
</table>