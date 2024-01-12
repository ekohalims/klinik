<table style="width:100%;">
    <tr>
        <td style="width:35%;">Kode Item</td>
        <td width="3%">:</td>
        <td><?php echo $dataItem->id_produk; ?></td>
    </tr>

    <tr>
        <td>Nama Item</td>
        <td>:</td>
        <td><?php echo $dataItem->nama_produk; ?></td>
    </tr>
</table>

<br>

<table class="table">
    <?php
        $numRows = $batch->num_rows();

        if($numRows > 0){
        foreach($batch->result() as $row){
    ?>
    <tr>
        <td><?php echo $row->noBatch; ?></td>
        <td style="text-align:right;"> 
            <a class="btn btn-success btn-rounded btn-sm pilihBatch" id="<?php echo $row->noBatch; ?>" data-id_produk="<?php echo $row->id_produk; ?>"><i class="fa fa-check-square-o"></i> Pilih</a>
        </td>
    </tr>
    <?php } } else {?>
    
    <tr>
        <td colspan="2">Tidak ada no batch</td>
    </tr>

    <?php } ?>
</table>