<label>Asuransi</label>
<select class="form-control" id="asuransi">
    <option value="">--Tampilkan Semua--</option>
    <?php
        foreach($asuransi as $row){
    ?>
    <option value="<?php echo $row->idAsuransi; ?>"><?php echo $row->namaAsuransi; ?></option>
    <?php } ?>
</select>