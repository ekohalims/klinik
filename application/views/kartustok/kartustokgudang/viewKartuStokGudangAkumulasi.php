<table class='table table-striped'>
    <thead>
        <tr>
            <th style="width:5%;text-align:center;">No</th>
            <th>Kode Item</th>
            <th>Nama Item</th>
            <th style="text-align:center;">Stok Awal</th>
            <th style="text-align:center;">Masuk</th>
            <th style="text-align:center;">Keluar</th>
            <th style="text-align:center;">Retur</th>
            <th style="text-align:center;">Waste</th>
            <th style="text-align:center;">Stok Akhir</th>
            <th style="text-align:right;">Harga Pokok</th>
            <th style="text-align:right;">Saldo</th>
        </tr>
    </thead>

    <tbody>
        <?php
            $i = 1;
            $totalPersediaan = 0;
            foreach($viewData->result() as $row){
        ?>
        <tr>
            <td style="text-align:center;"><?php echo $i; ?></td>
            <td><?php echo $row->idProduk;?></td>
            <td><?php echo $row->nama_produk; ?></td>
            <td style="text-align:center;"><?php echo number_format($row->currentStok+$row->totalStokAwal,'0',',','.'); ?></td>
            <td style="text-align:center;"><?php echo number_format($row->totalBarangMasuk+$row->totalReturStore+$row->SOPlus,'0',',','.'); ?></td>
            <td style="text-align:center;"><?php echo number_format($row->totalBarangKeluar+$row->SOMin,'0',',','.'); ?></td>
            <td style="text-align:center;"><?php echo number_format($row->totalRetur,'0',',','.'); ?></td>
            <td style="text-align:center;"><?php echo number_format($row->totalWaste,'0',',','.'); ?></td>
            <td style="text-align:center;">
                <?php
                    $stokAkhir = ($row->currentStok+$row->totalStokAwal+$row->totalBarangMasuk+$row->totalReturStore+$row->SOPlus)-($row->totalBarangKeluar+$row->totalRetur+$row->totalWaste+$row->SOMin);
                    echo number_format($stokAkhir,'0',',','.');
                ?>
            </td>
            <td style="text-align:right;">
                <?php
                    $hargaAverage = round(($row->rpMasuk-$row->rpKeluar)/(($row->currentStok+$row->totalStokAwal+$row->totalBarangMasuk+$row->SOPlus)-($row->totalBarangKeluar+$row->totalRetur+$row->totalWaste+$row->SOMin)));
                    echo number_format($hargaAverage,'0',',','.');
                ?>
            </td>
            <td style="text-align:right;">
                <?php
                    echo number_format($hargaAverage*$stokAkhir,'0',',','.');
                ?>
            </td>
        </tr>
        <?php $i++; $totalPersediaan = $totalPersediaan+($hargaAverage*$stokAkhir); } ?>
    </tbody>

    <tfoot>
        <tr>
            <td colspan="10" style="text-align:center;font-weight:bold;">TOTAL PERSEDIAAN</td>
            <td style="text-align:right;font-weight:bold;"><?php echo number_format($totalPersediaan,'0',',','.'); ?></td>    
        </tr>
    </tfoot>
</table>