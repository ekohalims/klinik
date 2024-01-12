<div class="form-group">
    <label>Nama Akun</label>
    <input type="text" class="form-control" id="namaAkun"/>
</div>

<div class="form-group">
    <label>Kategori</label>
    <select class="form-control" id="kategori">
        <option value="">--Pilih Kategori--</option>
        <?php
            foreach($coa as $row){
        ?>
        <option value="<?php echo $row->kodeAkun; ?>"><?php echo $row->namaAkun; ?></option>
        <?php } ?>
    </select>
</div>

<div id="formBank">

</div>

<div class="form-group">
    <label>Keterangan</label>
    <textarea class="form-control" id="keterangan"></textarea>
</div>

<div class="form-group" style="text-align:right;">
    <a class="btn btn-success btn-rounded" id="simpanAkun"><i class='fa fa-save'></i> Simpan</a>
</div>

<script type="text/javascript">
    $('#kategori').change(function(){
        var id = $(this).val();

        if(id=='12'){
            var url = "<?php echo base_url('chartOfAccount/formBank'); ?>";
            $('#formBank').load(url);
        } else {
            $('#formBank').empty();
        }
    });

    $('#kodeAkun').change(function(){
        var kodeAkun = $(this).val();
        var url = "<?php echo base_url('chartOfAccount/cekKodeIfExist'); ?>";
        
        $.post(url,{kodeAkun : kodeAkun},function(response){
            if(response > 0){
                $.Notification.autoHideNotify('error', 'top right', 'Gagal!','Kode akun telah ditambahkan sebelumya');
                $('#kodeAkun').val('');
            }
        });
    });

    $('#simpanAkun').on("click",function(){
        var namaAkun = $('#namaAkun').val();
        var kategori = $('#kategori').val();
        var keterangan = $('#keterangan').val();

        if(kategori=='12'){
            var cabang = $('#cabang').val();
            var noRekening = $("#noRekening").val();
            var atasNama = $('#atasNama').val();

            if(namaAkun=='' || kategori=='' || cabang=='' || noRekening=='' || atasNama==''){
                $.Notification.autoHideNotify('error', 'top right', 'Gagal!','Harap lengkapi form');
            } else {
                var url = "<?php echo base_url('chartOfAccount/simpanAkunBank'); ?>";
                $.ajax({
                    method : "POST",
                    url : url,
                    data : {namaAkun : namaAkun, kategori : kategori, keterangan : keterangan, cabang : cabang,noRekening : noRekening, atasNama : atasNama},
                    beforeSend : function(){
                        $('#simpanAkun').text("Harap tunggu...");
                        $('#simpanAkun').prop("disabled",true);
                    },
                    success : function(){
                        $('#myModal').modal('hide');
                        loadCoa();
                        $.Notification.autoHideNotify('success', 'top right', 'Berhasil!','Berhasil menambah akun');
                    }
                });
            }
        } else {
            if(namaAkun=='' || kategori==''){
                $.Notification.autoHideNotify('error', 'top right', 'Gagal!','Harap lengkapi form');
            } else {
                var url = "<?php echo base_url('chartOfAccount/simpanAkun'); ?>";
                $.ajax({
                    method : "POST",
                    url : url,
                    data : {namaAkun : namaAkun, kategori : kategori, keterangan : keterangan},
                    beforeSend : function(){
                        $('#simpanAkun').text("Harap tunggu...");
                        $('#simpanAkun').prop("disabled",true);
                    },
                    success : function(){
                        $('#myModal').modal('hide');
                        loadCoa();
                        $.Notification.autoHideNotify('success', 'top right', 'Berhasil!','Berhasil menambah akun');
                    }
                });
            }
        }
    });
</script>