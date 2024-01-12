<label for="inputEmail3" class="col-sm-3 control-label">Asuransi</label>
<div class="col-sm-9" id="layananLabel">
    <select class="form-control" id="asuransi">
        <?php
            foreach($asuransi as $dt){
        ?>

            <option value="<?php echo $dt->idAsuransi; ?>"><?php echo $dt->namaAsuransi; ?></option>

        <?php  } ?>
    </select>
</div>

