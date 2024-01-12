<?php
    $i = 1;
    foreach($riwayatPenerimaan->result() as $row){
        $nilai = $this->encryption->encrypt($row->no_receive);
		$encoded = strtr($nilai,array('+' => '.', '=' => '-', '/' => '~'));
?>
<tr>
    <td><?php echo $i; ?></td>
    <td><a href="<?php echo base_url('pembayaranHutangPO/buktiPenerimaan/'.$encoded); ?>" target="__blank"><?php echo $row->no_receive; ?></a></td>
    <td><?php echo $row->first_name; ?></td>
    <td><?php echo date_format(date_create($row->tanggal_terima),'d/m/y H:i'); ?></td>
    <td>
        <?php
            $tempatPenerimaan = $row->diterimaDi;
            if($tempatPenerimaan==0){
                echo "Gudang";
            } else {
                $place = $this->modelPublic->tempatPenerimaan($tempatPenerimaan);
                echo $place;
            }
        ?>
    </td>
</tr>
<?php $i++; } ?>