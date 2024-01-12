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
            BUKU BESAR<br>
            <?php echo $periode; ?>

        </td>
    </tr>
</table>

<div class="row">
    <div class="col-md-12">
        Nama Akun : <?php echo $namaAkun; ?><br>
        Kode Akun : <?php echo $kodeAkun; ?>

        <table class="table table-bordered">
            <thead>
                 <tr>
                     <th rowspan="2" style="text-align:center;vertical-align:middle;">Tanggal</th>
                     <th rowspan="2" style="text-align:center;vertical-align:middle;">Uraian</th>
                     <th rowspan="2" style="text-align:center;vertical-align:middle;">Ref</th>
                     <th rowspan="2" style="text-align:center;vertical-align:middle;width:10%;">Debit</th>
                     <th rowspan="2" style="text-align:center;vertical-align:middle;width:10%;">Kredit</th>
                     <th colspan="2" style="text-align:center;">Saldo</th>
                 </tr>

                 <tr>
                     <th style="text-align:center;width:10%;">Debit</th>
                     <th style="text-align:center;width:10%;">Kredit</th>
                 </tr>
            </thead>

            <tbody>
                <?php
                    $totalDebit = 0;
                    $totalKredit = 0;
                    foreach($viewBukuBesar as $row){
                        $totalDebit = $totalDebit+$row->debit;
                        $totalKredit = $totalKredit+$row->kredit;
                ?>
                <tr>
                    <td style="width:5%;"><?php echo date_format(date_create($row->tanggal),'d/m/y'); ?></td>
                    <td><?php echo $row->keterangan; ?></td>
                    <td></td>
                    <td style="text-align:right;"><?php echo number_format($row->debit,'0',',','.'); ?></td>
                    <td style="text-align:right;"><?php echo number_format($row->kredit,'0',',','.'); ?></td>
                    <td style="text-align:right;">
                        <?php 
                            $debit = $totalDebit-$totalKredit;
                            if($debit > 0){
                                echo number_format($debit,'0',',','.'); 
                            }
                        ?>
                    </td>
                    <td style="text-align:right;">
                        <?php   
                            $kredit = $totalKredit-$totalDebit;
                            if($kredit > 0){
                                echo number_format($kredit,'0',',','.');
                            }
                        ?>
                    </td>
                </tr>
                <?php 
            
                    } 
                ?>
            </tbody>
        </table>
    </div>
</div>