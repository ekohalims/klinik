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
            LAPORAN HASIL LABORATORIUM<br>
            <?php echo $periode; ?>
        </td>
    </tr>
</table>

<?php
    foreach($laporanLab->result() as $row){
?>
<div class="row" style="margin-top:10px;">
    <div class="col-md-12">
        <div style="border-top:solid 2px #12a89d;padding-top:5px;border-bottom:solid 1px grey;padding-bottom:5px;">
            <div class="row">
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
                            <td><?php echo $row->poliklinik; ?></td>
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

<div class="row" style="margin-top:10px;">
    <div class="col-md-12">
        <table width="100%" border="1">
            <?php
                $itemLab = $this->modelLaporan->itemLabResult($row->noPendaftaran);

                foreach($itemLab as $dt){
            ?>
            <tr style=";border-bottom:solid 1px grey;">
                <td style="font-weight:bold;padding-left:20px;"> 
                    <?php
                        echo $dt->namaLab."<br>";
                        echo number_format($dt->harga,'0',',','.'); 
                    ?>
                </td>
            </tr>

            <tr style="border-bottom:solid 1px grey;">
                <td style="padding-left:20px;">
                    <?php echo $dt->hasil; ?>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
<?php } ?>