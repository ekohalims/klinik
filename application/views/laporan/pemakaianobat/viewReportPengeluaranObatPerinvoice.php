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

<?php
    $grandTotal = 0;
    foreach($headerResep->result() as $row){
?>
<div class="row" style="margin-top:10px;"> 
    <div class="col-md-12">
        <div style="border-top:solid 2px #12a89d;border-bottom:solid 1px grey;padding-bottom:5px;">
            <div class="row" style="margin-top:5px;">
                <div class="col-md-6">
                    <table width="100%">
                        <tr>
                            <td width="30%" style="font-weight:bold;">No Pendaftaran</td>
                            <td width="2%">:</td>
                            <td><?php echo $row->noPendaftaran; ?></td>
                        </tr>

                        <tr>
                            <td style="font-weight:bold;">Nama Pasien</td>
                            <td>:</td>
                            <td><?php echo $row->namaPasien; ?></td>
                        </tr>

                        <tr>
                            <td style="font-weight:bold;">Tanggal</td>
                            <td>:</td>
                            <td><?php echo date_format(date_create($row->tanggal),'d M Y H:i'); ?></td>
                        </tr>
                    </table>
                </div>
                
                <div class="col-md-6">
                    <table width="100%">
                        <tr>
                            <td width="30%" style="font-weight:bold;">Poliklinik</td>
                            <td width="2%">:</td>
                            <td><?php echo $row->poliklinik ?></td>
                        </tr>

                        <tr>
                            <td style="font-weight:bold;">Dokter</td>
                            <td>:</td>
                            <td><?php echo $row->namaDokter; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-top:5px;">
    <div class="col-md-12" style="padding-left:30px;">
        <table width="100%">
            <tr style="font-weight:bold;border-bottom:solid 1px #ccc;">
                <td width="5%">No</td>
                <td>Kode Item</td>
                <td width="25%">Nama Item</td>
                <td width="15%">Harga</td>
                <td width="15%">Qty</td>
                <td width="10%">Satuan</td>
                <td width="15%" style="text-align:right;">Total</td>
            </tr>

            <?php
                $daftarObat = $this->modelLaporan->daftarObatPerinvoice($row->noPendaftaran);
                $i = 1;
                $total = 0;
                foreach($daftarObat->result() as $dt){
           ?>

            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $dt->id_produk; ?></td>
                <td><?php echo $dt->nama_produk; ?></td>
                <td><?php echo number_format($dt->harga,'0',',','.'); ?></td>
                <td><?php echo $dt->jumlah; ?></td>
                <td><?php echo $dt->satuan; ?></td>
                <td style="text-align:right;"><?php echo number_format($dt->harga*$dt->jumlah,'0',',','.'); ?></td>
            </tr>
            <?php $i++; $total = $total+($dt->harga*$dt->jumlah); } ?>

            <tr style="border-top:solid 1px #ccc;border-bottom:solid 1px grey;height:30px;">
                <td colspan="6" style="text-align:center;font-weight:bold;">TOTAL</td>
                <td  style="text-align:right;font-weight:bold;"><?php echo number_format($total,'0',',','.'); ?></td>
            </tr>
        </table>
    </div>
</div>
<?php $grandTotal = $grandTotal + $total; } ?>

<div class="row" style="margin-top:5px;">
    <div class="col-md-12">
        <table width="100%">
            <tr style="border-bottom:double;">
                <td style="font-weight:bold;font-size:14px;">GRAND TOTAL</td>
                <td style="text-align:right;font-weight:bold;font-size:14px;"><?php echo number_format($grandTotal,'0',',','.'); ?></td>
            </tr>
        </table>
    </div>
</div>