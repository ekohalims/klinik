<table class='table table-striped'>
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th>No Transaksi</th>
            <th>Jenis</th>
            <th>Tanggal</th>
            <th style="text-align:center;">Masuk</th>
            <th style="text-align:center;">Keluar</th>
            <th style="text-align:center;">Stok Akhir</th>
            <th style="text-align:right;">Harga</th>
            <th style="text-align:right;">Total</th>
            <th style="text-align:right;">Saldo</th>
            <th style="text-align:right;">Harga Average</th>
            <th>Nama Pasien/Supplier</th>
            <th style="text-align:right;">Tgl Exp</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td></td>
            <td colspan="7" style='font-weight:bold;'>STOK AWAL</td>
            <td style="text-align:center;">
                <?php 
                    if(isset($stokAwal)){
                        echo number_format($stokAwal->currentStok,'0',',','.'); 
                    } else {
                        echo "0";
                    }
                ?>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <?php
            $i = 1;
            $currentSaldo = 0;
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
            <td style="text-align:right;"><?php echo number_format($row->hargaSatuan,'0',',','.'); ?></td>
            
            <td style="text-align:right;">
                <?php 

                    if($row->barangMasuk > 0){
                        $totalHarga = $row->hargaSatuan*$row->barangMasuk;
                        echo number_format($totalHarga,'0',',','.'); 
                    } else {
                        $totalHarga = $row->hargaSatuan*$row->barangKeluar;
                        echo number_format($totalHarga,'0',',','.'); 
                    }
                ?>
            </td>
            
            <td style="text-align:right;">
                <?php
                    if($row->barangMasuk > 0){
                        $currentSaldo = $currentSaldo+$totalHarga;
                    } else {
                        $currentSaldo = $currentSaldo-$totalHarga;
                    }

                    echo number_format($currentSaldo,'0',',','.'); 
                ?>
            </td>
            <td style="text-align:right;">
                <?php
                   echo number_format($currentSaldo/$stokAkhir,'0',',','.'); 
                ?>
            </td>
            <td>
                <?PHP 
                    echo $row->namaLengkap." ".$row->supplier
                ?>
            </td> <!-- pasien or supplier-->
            <td>
                <?php 
                    echo date_format(date_create($row->tanggalExpired),'d/m/y');
                ?>
            </td> <!-- tgl exp-->
        </tr>
        <?php $i++; } ?>
    </tbody>
</table>