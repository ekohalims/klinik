<div class="form-group">
    <label>Kode Akun</label>
    <input type="text" class="form-control" id="kodeAkun" value="<?php echo $currentCoa->kodeSubAkun; ?>" readonly/>
</div>

<div class="form-group">
    <label>Nama Akun</label>
    <input type="text" class="form-control" id="namaAkun" value="<?php echo $currentCoa->namaSubAkun; ?>"/>
</div>

<div class="form-group">
    <label>Keterangan</label>
    <textarea class="form-control" id="keterangan"><?php echo $currentCoa->keterangan; ?></textarea>
</div>

<div class="form-group" style="text-align:right;">
    <a class="btn btn-success btn-rounded" id="simpanAkun"><i class='fa fa-save'></i> Simpan</a>
</div>

<script type="text/javascript">
    $('#simpanAkun').on("click",function(){
        var kodeAkun = $('#kodeAkun').val();
        var namaAkun = $('#namaAkun').val();
        var keterangan = $('#keterangan').val();

        if(kodeAkun=='' || namaAkun==''){
            $.Notification.autoHideNotify('error', 'top right', 'Gagal!','Harap lengkapi form');
        } else {
            var url = "<?php echo base_url('chartOfAccount/editAkun'); ?>";
            $.ajax({
                method : "POST",
                url : url,
                data : {kodeAkun : kodeAkun, namaAkun : namaAkun, keterangan : keterangan},
                beforeSend : function(){
                    $('#simpanAkun').text("Harap tunggu...");
                    $('#simpanAkun').prop("disabled",true);
                },
                success : function(){
                    $('#myModal').modal('hide');
                    loadCoa();
                    $.Notification.autoHideNotify('success', 'top right', 'Berhasil!','Berhasil mengubah akun');
                }
            });
        }
    });
</script>