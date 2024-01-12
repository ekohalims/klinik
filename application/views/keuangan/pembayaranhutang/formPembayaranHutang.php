<div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
    <div class="portlet-heading">
        <h3 class="portlet-title text-dark">
            Pembayaran Hutang
        </h3>
    </div>

    <div id="portlet2" class="panel-collapse collapse in">
        <div class="portlet-body"> 
            <table width="100%">
                <tr style="height:40px;">
                    <td width="30%">Jumlah Bayar</td>
                    <td><input type="text" class="form-control" id="jumlahBayar"/></td>
                </tr>

                <tr style="height:40px;"> 
                    <td width="30%">Jenis Bayar</td>
                    <td>
                        <select class="form-control" id="jenisBayar">
                            <option value="">--Pilih Jenis Bayar--</option>

                            <?php
                                foreach($paymentType as $row){
                            ?>
                            <option value="<?php echo $row->id; ?>"><?php echo $row->paymentType; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr id="akunForm"> 
                    <input type='hidden' id='akun' value=''/>
                </tr>

                <tr style="height:40px;">
                    <td width="30%">Keterangan</td>
                    <td><input type="text" class="form-control" id="keterangan"/></td>
                </tr>

                <tr style="height:40px;">
                    <td colspan="2" style="text-align:right;"><button class="btn btn-primary" id="submitPembayaran">Submit</button></td>
                </tr>
            </table>              
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#submitPembayaran').on("click",function(){
        var jumlahBayar = $('#jumlahBayar').val();
        var jenisBayar = $('#jenisBayar').val();
        var keterangan = $('#keterangan').val();
        var akun = $('#akun').val();
        var url = "<?php echo base_url('pembayaranHutangPO/submitPembayaran'); ?>";

        if(jenisBayar=='' || jumlahBayar=='' || akun==''){
            $.Notification.autoHideNotify('error', 'top right', 'Gagal!','Harap lengkapi data');
        } else {
            $.ajax({
                method : "POST",
                url : url,
                data : {jumlahBayar : jumlahBayar, jenisBayar : jenisBayar, keterangan : keterangan, noTagihan : noTagihan, akun : akun},
                beforeSend : function(){
                    $('#submitPembayaran').text("Harap tunggu...");
                    $('#submitPembayaran').prop("disabled",true);
                },
                success : function(response){
                    if(response < 1){
                        $.Notification.autoHideNotify('error', 'top right', 'Gagal!','Gagal menyimpan data, silahkan ulangi kembali');
                    } else {
                        $.Notification.autoHideNotify('success', 'top right', 'Berhasil!','Data telah tersimpan');
                    }  

                    loadHeaderTagihan();
                    loadDataTagihan();
                    loadFormPembayaranHutang(); 
                    loadRiwayatPembayaran();   
                    loadButtonTrx();          
                },
                error : function(){
                    alert("Error");
                }
            });
        }
    });

    $('#jumlahBayar').change(function(){
        var jumlahBayar = $(this).val();
        batasJumlahBayar(jumlahBayar);
    });

    $('#jenisBayar').change(function(){
        var jenisBayar = $(this).val();


        $.ajax({
            method : "POST",
            url : "<?php echo base_url('pembayaranHutangPO/formAkunBayar'); ?>",
            data : {jenisBayar : jenisBayar},
            success : function(response){
                    $('#akunForm').html(response);
            }
        });
    });

    function batasJumlahBayar(jumlahBayar){
        var url = "<?php echo base_url('pembayaranHutangPO/totalHutang'); ?>";

        $.post(url,{noTagihan :  noTagihan},function(response){
            if(parseInt(jumlahBayar) > parseInt(response)){
                $.Notification.autoHideNotify('error', 'top right', 'Gagal!','Nilai yang diinput melebihi sisa bayar');
                $('#jumlahBayar').val('');
            }
        });
    }
</script>