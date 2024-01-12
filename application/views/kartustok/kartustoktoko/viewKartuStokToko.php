<table class='table table-striped'>
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th>No Transaksi</th>
            <th>Jenis</th>
            <th>Tanggal</th>
            <th style="width:12%;text-align:center;">Masuk</th>
            <th style="width:12%;text-align:center;">Keluar</th>
            <th style="width:12%;text-align:center;">Stok Akhir</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td></td>
            <td colspan="5" style='font-weight:bold;'>STOK AWAL</td>
            <td style="text-align:center;">
                <?php 
                    if(isset($stokAwal)){
                        echo number_format($stokAwal->currentStok,'0',',','.'); 
                    } else {
                        echo "0";
                    }
                ?>
            </td>
        </tr>
        <?php
            $i = 1;
            foreach($viewData as $row){
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row->noRefference; ?></td>
            <td><?php echo $row->jenisTrx; ?></td>
            <td><?php echo date_format(date_create($row->tanggal),'d/m/Y'); ?></td>
            <td style="text-align:center;">
                <?php
                    $masuk = $row->barangMasuk;

                    if(!empty($masuk)){
                        echo number_format($masuk,'0',',','.');
                    } else {
                        echo "-";
                    }
                ?>
            </td>
            <td style="text-align:center;">
                <?php
                    $keluar = $row->barangKeluar;

                    if(!empty($keluar)){
                        echo number_format($keluar,'0',',','.');
                    } else {
                        echo "-";
                    }
                ?>
            </td>
            <td style="text-align:center;">
                <?php
                    $stokAkhir = ($row->currentStok+$row->barangMasuk)-$row->barangKeluar;
                    echo number_format($stokAkhir,'0',',','.'); 
                ?>
            </td>
        </tr>
        <?php $i++; } ?>
    </tbody>
</table>