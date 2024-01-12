<?php
    $numRows = $viewJurnal->num_rows();
    if($numRows > 0){
        $totalDebit = 0;
        $totalKredit = 0;
        foreach($viewJurnal->result() as $row){
?>
<tr>
    <td><?php echo $row->kodeSubAkun." - ".$row->namaAkun; ?></td>
    <td><input type="text" class="form-control debit" id="<?php echo $row->id; ?>" value="<?php echo $row->debit; ?>"></td>
    <td><input type="text" class="form-control kredit" id="<?php echo $row->id; ?>" value="<?php echo $row->kredit; ?>"></td>
    <td><input type="text" class="form-control deskripsi" id="<?php echo $row->id; ?>" value="<?php echo $row->deskripsi; ?>"></td>
    <td style="text-align:right;"><a class='hapus' id="<?php echo $row->id; ?>"><i class="fa fa-trash"></i></a></td>
</tr>
<?php $totalDebit = $totalDebit+$row->debit; $totalKredit=$totalKredit+$row->kredit; } } else { ?>
<tr>
    <td colspan="5">--Belum ada data--</td>
</tr>
<?php } ?>

<?php
    if($numRows > 0){
?>
<tr>
    <td></td>
    <td style="text-align:right;font-weight:bold;"><?php echo number_format($totalDebit,'0',',','.'); ?></td>
    <td style="text-align:right;font-weight:bold;"><?php echo number_format($totalKredit,'0',',','.'); ?></td>
    <td></td>
    <td></td>
</tr>
<?php } ?>

<script type="text/javascript">
    $('.debit').on("change",function(){
        var kodeAkun = this.id;
        var value = $(this).val();

        $.ajax({
            method : "POST",
            url : "<?php echo base_url('jurnalUmum/updateDebit'); ?>",
            data : {kodeAkun : kodeAkun, value : value},
            success : function(){
                viewJurnal();
            }
        });
    });

    $('.kredit').on("change",function(){
        var kodeAkun = this.id;
        var value = $(this).val();

        $.ajax({
            method : "POST",
            url : "<?php echo base_url('jurnalUmum/updateKredit'); ?>",
            data : {kodeAkun : kodeAkun, value : value},
            success : function(){
                viewJurnal();
            }
        });
    });

    $('.deskripsi').on("change",function(){
        var kodeAkun = this.id;
        var value = $(this).val();

        $.ajax({
            method : "POST",
            url : "<?php echo base_url('jurnalUmum/updateDeskripsi'); ?>",
            data : {kodeAkun : kodeAkun, value : value},
            success : function(){
                viewJurnal();
            }
        });
    });

    $('.hapus').on("click",function(){
        var kodeAkun = this.id;

        $.ajax({
            method : "POST",
            url : "<?php echo base_url('jurnalUmum/hapusAkun'); ?>",
            data : {kodeAkun : kodeAkun},
            success : function(){
                viewJurnal();
            }
        });        
    });
</script>