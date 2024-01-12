<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Nama Tarif <?php echo $tarif->jenis; ?></label>
            <input type="text" class="form-control" placeholder="Nama Tarif" id="namaTarif" value="<?php echo $tarif->namaTarif; ?>"/>
        </div>

        <?php
            if($table=='kl_tarifranap'){
        ?>
            <div class="form-group">
                <label>Kelas</label>
                <select class="form-control" id="kelas">
                    <option value="NON" <?php if($tarif->kelas=='NON'){echo "selected";} ?>>NON</option>
                    <option value="VIP" <?php if($tarif->kelas=='VIP'){echo "selected";} ?>>VIP</option>
                    <option value="I" <?php if($tarif->kelas=='I'){echo "selected";} ?>>I</option>
                    <option value="II" <?php if($tarif->kelas=='II'){echo "selected";} ?>>II</option>
                    <option value="III" <?php if($tarif->kelas=='III'){echo "selected";} ?>>III</option>
                </select>
            </div>
        <?php
            } else {
                echo "<input type='hidden' id='kelas' value=''/>";
            }
        ?>

        <div class="form-group">
            <label>Jenis</label>
            <select class="form-control" id="jenisTarif">
                <?php
                    foreach($masterjenis as $row){
                ?>
                    <option value="<?php echo $row->id; ?>" <?php if($row->id==$tarif->jenis){echo "selected";} ?>><?php echo $row->nama; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Tarif</label>
            <input type="text" class="form-control" placeholder="Tarif" id="tarif" value="<?php echo $tarif->tarif; ?>"/>
        </div>

        <div class="form-group">
            <label>Sarana</label>
            <input type="text" class="form-control" placeholder="Sarana" id="sarana" value="<?php echo $tarif->sarana; ?>"/>
        </div>

        <div class="form-group">
            <label>Dokter</label>
            <input type="text" class="form-control" placeholder="Dokter" id="dokter" value="<?php echo $tarif->dokter; ?>"/>
        </div>  

        <div class="form-group">
            <label>BHP</label>
            <input type="text" class="form-control" placeholder="BHP" id="bhp" value="<?php echo $tarif->bhp; ?>"/>
        </div>

        <div class="form-group">
            <label>Alat</label>
            <input type="text" class="form-control" placeholder="Alat" id="alat" value="<?php echo $tarif->alat; ?>"/>
        </div>

        <input type="hidden" id="kode" value="<?php echo $kode; ?>"/>
        <input type="hidden" id="jenis" value="edit"/>

    </div>
</div>