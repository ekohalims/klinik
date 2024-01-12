<?php
    $numRows = $headerPenjualan->num_rows();

    if($numRows > 0){
    foreach($headerPenjualan->result() as $row){
        $nilai = $this->encryption->encrypt($row->noPendaftaran);
		$encoded = strtr($nilai,array('+' => '.', '=' => '-', '/' => '~'));
?>
<div style="border-top:solid 2px #ddd;border-bottom:solid 2px #ccc;padding-top:5px;padding-bottom:5px;margin-top:10px;">
    <a href="<?php echo base_url('kasir/bayarPiutang/'.$encoded); ?>">
    <div class="row">
        <div class="col-md-6">
            <table style="width:100%;">
                <tr>
                    <td style="font-weight:bold;width:40%;">No Pendaftaran</td>
                    <td><?php echo $row->noPendaftaran; ?></td>
                </tr>

                <tr>
                    <td style="font-weight:bold;">No RM</td>
                    <td><?php echo $row->noPasien;?></td>
                </tr>

                <tr>
                    <td style="font-weight:bold;">No ID</td>
                    <td><?php echo $row->noID;?></td>
                </tr>

                <tr>
                    <td style="font-weight:bold;">Nama</td>
                    <td><?php echo $row->namaLengkap; ?></td>
                </tr>

                <tr>
                    <td style="font-weight:bold;">Tempat, Tgl Lahir</td>
                    <td><?php echo $row->tempatLahir.",".date_format(date_create($row->tanggalLahir),'d M Y'); ?></td>
                </tr>

                <tr>
                    <td style="font-weight:bold;">Poliklinik</td>
                    <td><?php echo $row->poliklinik; ?></td>
                </tr>

                <tr>
                    <td style="font-weight:bold;">Dokter</td>
                    <td><?php echo $row->namaDokter; ?></td>
                </tr>

                <tr>
                    <td style="font-weight:bold;">Status Piutang</td>
                    <td>
                        <?php
                            $status = $row->status;

                            if($status==0){
                                echo "<span class='label label-danger'>Belum Terbayar</span>";
                            } elseif($status==1){
                                echo "<span class='label label-info'>Terbayar</span>";
                            } elseif($status==2){
                                echo "<span class='label label-success'>Selesai</span>";
                            } elseif($status==3){
                                echo "<span class='label label-warning'>Batal</span>";
                            }
                        ?>
                    </td>
                </tr>
            </table>
        </div>

        <div class="col-md-6">
            <?php
                $noPendaftaran = $row->noPendaftaran;
                $totalTindakan = $this->modelKasir->totalTindakan($noPendaftaran);
                $totalObat = $this->modelKasir->totalObat($noPendaftaran);
                $totalLab = $this->modelKasir->totalLab($noPendaftaran);
                $totalRad = $this->modelKasir->totalRadiologi($noPendaftaran);
            ?>  

            <table style="width:100%;">
                <?php
                    if($totalTindakan > 0){
                ?>
                <tr>
                    <td style="font-weight:bold;">Total Tindakan</td>
                    <td style="text-align:right;"><?php echo number_format($totalTindakan,'0',',','.'); ?></td>
                </tr>
                <?php } ?>
                
                <?php
                    if($totalObat > 0){
                ?>
                <tr>
                    <td style="font-weight:bold;">Total Obat</td>
                    <td style="text-align:right;"><?php echo number_format($totalObat,'0',',','.'); ?></td>
                </tr>
                <?php } ?>
                
                <?php
                    if($totalLab > 0){
                ?>
                <tr>
                    <td style="font-weight:bold;">Total Laboratorium</td>
                    <td style="text-align:right;"><?php echo number_format($totalLab,'0',',','.'); ?></td>
                </tr>
                <?php } ?>
                
                <?php
                    if($totalRad > 0){
                ?>
                <tr>    
                    <td style="font-weight:bold;">Total Radiologi</td>
                    <td style="text-align:right;"><?php echo number_format($totalRad,'0',',','.'); ?></td>
                </tr>
                <?php } ?>

                <tr style="border-top:solid 1px #ddd;">
                    <td style="font-weight:bold;">GRAND TOTAL</td>
                    <td style="text-align:right;font-weight:bold;"><?php echo number_format($this->modelKasir->totalTransaksi($noPendaftaran),'0',',','.'); ?></td>
                </tr>
            </table>
        </div>
    </div>
    </a>
</div>
<?php } } else {?>
    <div class="alert alert-danger">
        --Data tidak ditemukan--
    </div>
<?php } ?>