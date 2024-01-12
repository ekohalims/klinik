<div class="row">
    <div class="col-md-12" style="text-align:right;">
        <a href="<?php echo base_url('inputTindakanRajal/cetakResep/'.$noPendaftaran); ?>" target="__blank" class="btn btn-info"><i class="fa fa-print"></i> Cetak</a>
    </div>
</div>
<br>
<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Qty</th>
            <th>Satuan</th>
            <th>Aturan</th>
        </tr>
    </thead>

    <tbody>
        <?php
            foreach($cart->result() as $row){
        ?>
        <tr>
            <td><?php echo $row->nama_produk; ?></td>
            <td><?php echo $row->jumlah; ?></td>
            <td><?php echo $row->satuan; ?></td>
            <td><?php echo $row->aturan; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>