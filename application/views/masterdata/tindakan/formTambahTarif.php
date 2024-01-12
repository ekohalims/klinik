<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Nama Tarif</label>
            <input type="text" class="form-control" placeholder="Nama Tarif" id="namaTarif"/>
        </div>
        
        <?php
            if($id=='Ranap'){
        ?>
            <div class="form-group">
                <label>Kelas</label>
                <select class="form-control" id="kelas">
                    <option value="NON">NON</option>
                    <option value="VIP">VIP</option>
                    <option value="I">I</option>
                    <option value="II">II</option>
                    <option value="III">III</option>
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
                    <option value="<?php echo $row->id; ?>"><?php echo $row->nama; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Tarif</label>
            <input type="text" class="form-control" placeholder="Tarif" id="tarif"/>
        </div>

        <div class="form-group">
            <label>Sarana</label>
            <input type="text" class="form-control" placeholder="Sarana" id="sarana"/>
        </div>

        <div class="form-group">
            <label>Dokter</label>
            <input type="text" class="form-control" placeholder="Dokter" id="dokter"/>
        </div>  

        <div class="form-group">
            <label>BHP</label>
            <input type="text" class="form-control" placeholder="BHP" id="bhp"/>
        </div>

        <div class="form-group">
            <label>Alat</label>
            <input type="text" class="form-control" placeholder="Alat" id="alat"/>
        </div>

        <input type="hidden" id="jenis" value="tambah"/>

    </div>
</div>