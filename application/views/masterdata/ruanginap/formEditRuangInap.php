<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Nama Ruang</label> <label id="namaRuangLabel" style="color:red;"></label>
            <input type="text" class="form-control" id="namaRuang" value="<?php echo $ranap->namaGroup; ?>"/>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>POS</label>
            <select class="form-control" id="pos">
                <?php
                    foreach($pos as $ps){
                ?>
                <option value="<?php echo $ps->idPos; ?>" <?php if($ps->idPos==$ranap->idKategori){echo "selected";}?>><?php echo $ps->pos; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Kelas</label>
            <select class="form-control" id="kelas">
                <?php
                    foreach($kelas as $kl){
                ?>
                <option value="<?php echo $kl->idKelas; ?>" <?php if($kl->idKelas==$ranap->idKelas){echo "selected";}?>><?php echo $kl->kelasruang; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Kapasitas (Bed)</label> <label id="kapasitasLabel" style="color:red;"></label>
            <input type="number" class="form-control" id="kapasitas" value="<?php echo $ranap->kapasitas; ?>"/>
        </div>
    </div>

    <div class="col-md-6"> 
        <div class="form-group">
            <label>Tarif</label> <label id="tarifLabel" style="color:red;"></label>
            <input type="number" class="form-control" id="tarif" value="<?php echo $ranap->tarif; ?>"/>
        </div>
    </div>
</div>


<input type="hidden" id="aksi" value="edit"/>
<input type="hidden" id="jenisForm" value="ruangInap"/>
<input type="hidden" id="id" value="<?php echo $ranap->kodeGroup; ?>"/>