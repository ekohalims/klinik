<?php
    foreach($itemCetak->result() as $row){
?>
<div class="col-md-2" style="page-break-before: always"> 
    <?php echo substr($row->nama_produk,0,25); ?> <BR>
    <?php
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo '<img width="100%" height="30px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($row->idProduk, $generator::TYPE_CODE_128)) . '">';
    ?> <BR>
    <span style='text-align:center;'><?php echo number_format($row->harga,'0',',','.'); ?></span>
</div>
<?php } ?>