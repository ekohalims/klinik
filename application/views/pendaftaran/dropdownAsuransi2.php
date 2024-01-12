    <label>Asuransi</label>
    <select class="form-control" id="asuransi" style="width:300px;">
        <?php
            foreach($asuransi as $dt){
        ?>

            <option value="<?php echo $dt->idAsuransi; ?>"><?php echo $dt->namaAsuransi; ?></option>

        <?php  } ?>
    </select>

