<div class="form-group">
    <label>Kode</label>
    <input type="text" class="form-control" id="kode" value="<?php echo $item->id_produk; ?>" readonly/>
</div>

<div class="form-group">
    <label>Nama Item</label>
    <input type="text" class="form-control" id="namaItem" value="<?php echo $item->nama_produk; ?>"/>
</div>

<div class="form-group">
    <label>Kategori</label>
    <select class="form-control" id="kategori">
        <option value="">--Pilih Kategori--</option>

        <?php
            foreach($kategori as $kt){
        ?>
        <option value="<?php echo $kt->id_kategori; ?>" <?php if($item->id_kategori==$kt->id_kategori) {echo "selected";} ?>><?php echo $kt->kategori; ?></option>
        <?php } ?>
    </select>
</div>

<div class="form-group">
    <label>Satuan</label>
    <select class="form-control" id="satuan">
        <option value="">--Pilih Satuan--</option>

        <?php
            foreach($satuan as $st){
        ?>
        <option value="<?php echo $st->satuan; ?>" <?php if($item->satuan==$st->satuan){echo "selected";} ?>><?php echo $st->satuan; ?></option>
        <?php } ?>
    </select>
</div>

<div class="form-group">
    <label>Stok Minimal</label>
    <input type="number" class="form-control" id="stokMinimal" value="<?php echo $item->stokMinimal; ?>"/>
</div>

<div class="form-group">
    <label>Harga Beli</label>
    <input type="number" class="form-control" id="hargaBeli" value="<?php echo $item->hpp; ?>"/>
</div>

<div class="form-group">
    <label>Harga Jual</label>
    <input type="number" class="form-control" id="hargaJual" value="<?php echo $item->harga; ?>"/>
</div>
<input type="hidden" id="jenis" value="edit"/>