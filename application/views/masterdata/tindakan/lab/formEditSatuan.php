<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Nama Tarif</label> <label id="namaTarifLabel" style="color:red;"></label>
            <input type="hidden" id="kode" value="<?php echo $tarif->kode; ?>"/>
            <input type="text" class="form-control" placeholder="Nama Tarif" id="namaTarif" value="<?php echo $tarif->namaTarif; ?>"/>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Golongan</label>  <label id="golonganLabel" style="color:red;"></label>
            <select class="form-control" id="golongan">
                <option value="">--Pilih Golongan--</option>

                <?php
                    foreach($kategori as $kt){
                ?>
                <option value="<?php echo $kt->idKategori; ?>" <?php if($tarif->idKategori==$kt->idKategori){echo "selected";} ?>><?php echo $kt->kategori; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label>Nilai Min</label> <label id="nilaiMinLabel" style="color:red;"></label>
            <input type="text" class="form-control" placeholder="Nilai Min" id="nilaiMin" value="<?php echo $tarif->nmin; ?>"/>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Nilai Max</label> <label id="nilaiMaxLabel" style="color:red;"></label>
            <input type="text" class="form-control" placeholder="Nilai Max" id="nilaiMax" value="<?php echo $tarif->nmax; ?>"/>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Nilai</label> <label id="nilaiLabel" style="color:red;"></label>
            <input type="text" class="form-control" placeholder="Nilai" id="nilai" value="<?php echo $tarif->nilai; ?>"/>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Satuan</label> <label id="satuanLabel" style="color:red;"></label>
            <input type="text" class="form-control" placeholder="Satuan" id="satuanNilai" value="<?php echo $tarif->satuan; ?>"/>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Nilai Lain</label>
            <input type="text" class="form-control" placeholder="Nilai Lain" id="nilaiLain" value="<?php echo $tarif->nilaiLain; ?>"/>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Tarif</label> <label id="tarifLabel" style="color:red;"></label>
            <input type="number" class="form-control" placeholder="Tarif" id="tarif" value="<?php echo $tarif->tarif; ?>"/>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>Keterangan</label>
            <textarea class="form-control" id="keterangan"><?php echo $tarif->keterangan; ?></textarea>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>Harga Normal</label>
            <textarea class="form-control" id="hargaNormal"><?php echo $tarif->hargaNormal; ?></textarea>
        </div>
    </div>
</div>

<input type="hidden" id="jenis" value="edit"/>