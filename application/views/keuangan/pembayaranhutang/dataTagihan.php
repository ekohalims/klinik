<?php
  $i = 1;
  $total = 0;
  foreach($purchaseItem as $row){
?>
<tr>
  <td align="center"><?php echo $i; ?></td>
  <td><?php echo $row->id_produk; ?></td>
  <td><?php echo $row->nama_produk; ?></td>
  <td align="center"><?php echo $row->qty; ?></td>
  <td align="center">
    <?php 
      $sku            = $row->id_produk;
      $delivered_qty  = $this->modelPembayaranHutang->delivered_qty($noTagihan,$sku);

      echo $delivered_qty;
    ?>
  </td>
  <td align="center"><?php echo $row->qty-$delivered_qty; ?></td>
  <td align="center">
    <?php
      $returItem = $this->modelPembayaranHutang->returItem($noTagihan,$sku);

      echo $returItem;
    ?>
  </td>
  <td align="center"><?php echo $row->satuan; ?></td>
  <td align="right"><?php echo number_format($row->harga,'0',',','.'); ?></td>
  <td align="right"><?php echo number_format($row->harga*($delivered_qty-$returItem),'0',',','.'); ?></td>
</tr>
<?php $i++; $total = $total+($row->harga*($delivered_qty-$returItem)); } ?>  

<tr>
  <td align="center" colspan="9" style="font-weight: bold;">TOTAL</td>
  <td align="right" style="font-weight: bold;"><?php echo number_format($total,'0',',','.'); ?></td>
</tr>

<tr>
  <td align="center" colspan="9" style="font-weight: bold;">TERBAYAR</td>
  <td align="right" style="font-weight: bold;"><?php echo number_format($hutangTerbayar,'0',',','.'); ?></td>
</tr>

<tr>
  <td align="center" colspan="9" style="font-weight: bold;">SISA PEMBAYARAN</td>
  <td align="right" style="font-weight: bold;"><?php echo number_format($total-$hutangTerbayar,'0',',','.'); ?></td>
</tr>