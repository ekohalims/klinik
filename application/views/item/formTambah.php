<div class="form-group">
    <label>Kode</label> <label id="labelKode" style="color:red;"></label>
    <input type="text" class="form-control" id="kode"/>
</div>

<div class="form-group">
    <label>Nama Item</label>
    <input type="text" class="form-control" id="namaItem"/>
</div>

<div class="form-group">
    <label>Kategori</label> <label id="labelKategori" style="color:red;"></label>
    <select class="form-control" id="kategori">
        <option value="">--Pilih Kategori--</option>

        <?php
            foreach($kategori as $kt){
        ?>
        <option value="<?php echo $kt->id_kategori; ?>"><?php echo $kt->kategori; ?></option>
        <?php } ?>
    </select>
</div>

<div class="form-group">
    <label>Satuan</label> <label id="labelSatuan" style="color:red;"></label>
    <select class="form-control" id="satuan">
        <option value="">--Pilih Satuan--</option>

        <?php
            foreach($satuan as $st){
        ?>
        <option value="<?php echo $st->satuan; ?>"><?php echo $st->satuan; ?></option>
        <?php } ?>
    </select>
</div>

<div class="form-group">
    <label>Stok Minimal</label>
    <input type="number" class="form-control" id="stokMinimal" value="0"/>
</div>

<div class="form-group">
    <label>Harga Beli</label>
    <input type="number" class="form-control" id="hargaBeli" value="0"/>
</div>

<div class="form-group">
    <label>Harga Jual</label>
    <input type="number" class="form-control" id="hargaJual" value="0"/>
</div>

<input type="hidden" id="jenis" value="tambah"/>

