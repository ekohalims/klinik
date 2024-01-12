<label for="inputEmail3" class="col-sm-2 control-label">Dokter</label>
<div class="col-sm-10">
    <select class="select2" id="dokter">
        <option value="">--Pilih Dokter</option>

        <?php
            foreach($dokter->result() as $row){
        ?>
        <option value="<?php echo $row->id_dokter; ?>"><?php echo $row->nama; ?></option>
        <?php } ?>
    </select>
</div>