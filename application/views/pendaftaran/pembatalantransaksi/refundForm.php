<br>
<table width="100%" class="table">
    <tr>
        <td style="vertical-align:middle;">Akun</td>
        <td>
            <select class="form-control" id="akun">
                <option value="">--Pilih Akun--</option>
                <optgroup label="Kas">
                    <?php
                        foreach($akunKas as $ks){
                    ?>
                    <option value="<?php echo $ks->kodeSubAkun; ?>"><?php echo $ks->kodeSubAkun." - ".$ks->namaSubAkun; ?></option>
                    <?php } ?>
                </optgroup>

                <optgroup label="Bank">
                    <?php
                        foreach($akunBank as $bk){
                    ?>
                    <option value="<?php echo $bk->kodeSubAkun; ?>"><?php echo $bk->kodeSubAkun." - ".$bk->namaSubAkun; ?></option>
                    <?php } ?>
                </optgroup>
            </select>
        </td>
    </tr>
</table>

<script type="text/javascript">
    $('#akun').change(function(){
        var idAkun = $(this).val();

        //cek apakah saldo mencukupi
        var url = "<?php echo base_url('pembatalanTransaksi/cekSaldoAkun'); ?>";
        
        $.ajax({
            method : "POST",
            url : url,
            data : {idAkun : idAkun,noPendaftaran : noPendaftaran},
            success : function(response){
                if(response==0){
                    $.Notification.autoHideNotify('error', 'top right', 'Gagal','Saldo pada akun tidak mencukupi');
                    $('#akun').val('');
                } 
            }
        });
    });
</script>