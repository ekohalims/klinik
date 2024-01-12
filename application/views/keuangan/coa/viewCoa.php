<?php
    foreach($header as $hd){
?>
<tr>
    <td><?php echo $hd->kode; ?></td>
    <td><?php echo $hd->akun; ?></td>
    <td></td>
</tr>
    <?php
        $subCoa = $this->modelCoa->getSubCoa($hd->kode);
        foreach($subCoa as $sb){
    ?>
<tr>
    <td style='padding-left:30px;'><?php echo $sb->kodeAkun; ?></td>
    <td style='padding-left:30px;'><?php echo $sb->namaAkun; ?></td>
    <td></td>
</tr>
<?php
    $akun = $this->modelCoa->subCoa($sb->kodeAkun);
    foreach($akun as $ak){
?>
<tr>
    <td style="padding-left:60px;"><?php echo $ak->kodeSubAkun; ?></td>
    <td style="padding-left:60px;"><?php echo $ak->namaSubAkun; ?></td>
    <td style="text-align:right;">
        <?php
            $lock = $ak->locked;
            if($lock==1){
        ?>
            <i class='fa fa-lock'></i>
        <?php } else { ?>
            <a class='editCoa' id='<?php echo $ak->kodeSubAkun; ?>'><i class='fa fa-pencil'></i></a> <a class='hapusCoa' id='<?php echo $ak->kodeSubAkun; ?>'><i class='fa fa-trash'></i></a>
        <?php } ?>
    </td>
</tr>
<?php
  } } }
?>


