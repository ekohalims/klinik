<div class="row">
    <div class="col-md-6">
        <table width="100%">
            <tr>
                <td width="25%">Ruang</td>
                <td width="1%">:</td>
                <td><?php echo $ruangGroup->namaGroup; ?></td>
            </tr>

            <tr>
                <td>POS</td>
                <td>:</td>
                <td><?php echo $ruangGroup->pos; ?></td>
            </tr>

            <tr>
                <td>Tarif</td>
                <td>:</td>
                <td><?php echo number_format($ruangGroup->tarif,'0',',','.'); ?></td>
            </tr>
        </table>
    </div>

    <div class="col-md-6">
        <table width="100%">
            <tr>
                <td width="25%">Kelas</td>
                <td width="1%">:</td>
                <td><?php echo $ruangGroup->kelasruang; ?></td>
            </tr>

            <tr>
                <td>Kapasitas</td>
                <td>:</td>
                <td><?php echo $ruangGroup->kapasitas; ?> Bed</td>
            </tr>
        </table>
    </div>

    <div class="col-md-12">
        <div style="border-bottom:solid 1px #ddd;"></div>
    </div>
</div>

<div class="row" style="margin-top:10px;">
    <?php
        $i = 1;
        foreach($daftarRuangGroup as $row){
    ?>  

    <div class="col-md-3">
        <div class="form-group">
            <label>Ruang <?php echo $i; ?></label>
            <input type="hidden" name="kodeRuang[]" value="<?php echo $row->kodeRuang; ?>"/>
            <input type="text" name="namaRuang[]" class="form-control" value="<?php echo $row->namaRuang; ?>"/>
            <input type="radio" name="status<?php echo $row->kodeRuang; ?>" value="1" <?php if($row->status==1){echo "checked";} ?>/> Tersedia <input type="radio" name="status<?php echo $row->kodeRuang; ?>" value="0"  <?php if($row->status==0){echo "checked";} ?>/> Tidak Tersedia
        </div>
    </div>

    <?php $i++; } ?>
</div>