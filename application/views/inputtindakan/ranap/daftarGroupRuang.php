<div class="col-md-12">
    <label>Kategori Ruangan</label>
</div>
<?php
    foreach($groupRuang as $row){
        $ruanganTerpakaiPergroup = $this->modelPendaftaranRanap->ruanganTerpakaiPergroup($row->kodeGroup);
?>  
<div class="col-md-3" style="min-height:50px;padding:0px 1px 1px 1px;">
    <div style="border:solid 1px #ddd;padding:5px;">
        <a class="pilihGroupRuang" id="<?php echo $row->kodeGroup; ?>">
            <p style="font-weight:bold;font-size:12px;"><?php echo $row->namaGroup; ?></p>
            <table width='100%'>
                <tr>
                    <td><i class="fa fa-exchange"></i> Kelas</td>
                    <td style="text-align:right;"><?php echo $row->kelasruang; ?></td>
                </tr>

                <tr>
                    <td><i class="fa fa-money"></i> Tarif</td>
                    <td style="text-align:right;"><?php echo number_format($row->tarif,'0',',','.'); ?></td>
                </tr>

                <tr>
                    <td><i class="fa fa-book"></i> Kapasitas</td>
                    <td style="text-align:right;"><?php echo $row->kapasitas; ?> Bed</td>
                </tr>

                <tr>
                    <td><i class="fa fa-users"></i> Tersedia</td>
                    <td style="text-align:right;"><?php echo ($row->jumlahRuang*$row->kapasitas)-$ruanganTerpakaiPergroup; ?> Bed</td>
                </tr>
            </table>
        </a>
    </div>
</div>
<?php } ?>

<script type="text/javascript">
    var ruangAsal = "<?php echo $ruangAsal; ?>";

    $('.pilihGroupRuang').on("click",function(){
        var idGroup = this.id;
        var url = "<?php echo base_url('inputTindakanRanap/formPilihRuang'); ?>";

        $('#formPilihRuangan').load(url,{idGroup : idGroup, ruangAsal : ruangAsal});
    });
</script>