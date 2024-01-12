<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>NO RM</label>
            <input type="text" class="form-control"  placeholder="Jika Kosong, akan secara otomatis di isi oleh sistem" id="noRM">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Alamat**</label>
            <input type="text" class="form-control" placeholder="Alamat" id="alamat">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>NO ID / KTP **</label>
            <input type="text" class="form-control"  placeholder="NO ID / KTP" id="noID">
        </div>
    </div>

    <div class="col-md-6"> 
        <div class="form-group">
            <label>RT/TW</label>
            <input type="text" class="form-control"  placeholder="RT/TW" id="rt">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Nama Lengkap **</label>
            <input type="text" class="form-control"  placeholder="Nama Lengkap" id="namaLengkap">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Desa / Kelurahan</label>
            <input type="text" class="form-control"  placeholder="Desa / Kelurahan" id="kelurahan">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Tempat Lahir</label>
            <input type="text" class="form-control"  placeholder="Tempat Lahir" id="tempatLahir">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Provinsi</label>
            <select class="select2" id="provinsi">
                <option value="">--Pilih Provinsi--</option>
                <?php
                    foreach($provinsi as $row){
                ?>
                    <option value="<?php echo $row->id_provinsi; ?>"><?php echo $row->nama_provinsi; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="text" class="form-control datepicker" placeholder="" data-mask="99/99/9999" id="tanggalLahir"/>
            <span class="help-inline">dd/mm/yyyy</span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Kabupaten</label>
            <select class="select2" id="list-kabupaten">
                <option value="">--Pilih Kabupaten--</option>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Jenis Kelamin **</label> <br>
            <input type="radio" class="jenisKelamin" name="jenisKelamin" id="jenisKelamin" value="L">Laki-laki &nbsp &nbsp<input type="radio" class="jenisKelamin" id="jenisKelamin" name="jenisKelamin" value="P" />Perempuan
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Kecamatan</label>
            <select class="select2" id="list-kecamatan">
                <option value="">--Pilih Kecamatan--</option>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>No HP **</label>
            <input type="text" class="form-control"  placeholder="No HP" id="noHP">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Agama</label>
            <select class="form-control" id="agama">
                <option value="">--Pilih Agama--</option>
                <?php
                    foreach($agama as $ag){
                ?>
                <option value="<?php echo $ag->idAgama; ?>"><?php echo $ag->agama; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control"  placeholder="Email" id="email">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Pendidikan</label>
            <select class="form-control" id="pendidikan">
                <option value="">--Pilih Pendidikan--</option>
                <?php
                    foreach($pendidikan as $pd){
                ?>
                <option value="<?php echo $pd->idPend; ?>"><?php echo $pd->pendidikan; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Kontak Keluarga/S/I **</label>
            <input type="text" class="form-control"  placeholder="Kontak Lain Yang Dapat Dihubungi" id="anotherPhone">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Nama Ortu/S/I</label>
            <input type="text" class="form-control"  placeholder="Nama Ortu/S/I" id="namaKeluarga">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Pekerjaan</label>
            <select class="form-control" id="pekerjaan">
                <option value="">--Pilih Pekerjaan--</option>
                <option value="Wiraswasta">Wiraswasta</option>
                <option value="Karyawan Swasta">Karyawan Swasta</option>
                <option value="PNS">PNS</option>
                <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
                <option value="Belum/Tidak Bekerja">Belum/Tidak Bekerja</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Status Kawin</label>
            <select class="form-control" id="statusKawin">
                <option value="">--Pilih Status--</option>
                <?php
                    foreach($kawin as $kn){
                ?>
                <option vallue="<?php echo $kn->idKawin; ?>"><?php echo $kn->kawin; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        
    </div>
</div>

<div class="row">
    <div class="col-md-12" style="color:red;">
        Tanda ** Harus di isi
    </div>
</div>

<script type="text/javascript">
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    $('#noID').change(function(){
        var noID = $(this).val();

        var urlCekID = "<?php echo base_url('addressPicker/cekIDexist'); ?>";

        $.post(urlCekID,{noID : noID},function(response){
            if(response > 0){
                $('#noID').val('');
                $('#noID').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                setTimeout( function(){$('#noID').css({"box-shadow" : "","border" : ""});} , 4000);
                $.Notification.autoHideNotify('error','top right', 'Gagal!', 'NO ID telah terpakai');
            }
        });
    });

    jQuery('.datepicker').datepicker({
        changeYear : true,
        defaultDate : '1980',
        calendarWeeks : true,
        todayHighlight : false,
        startView : 2,
        format: "dd/mm/yyyy",
        autoclose :true
    });

    $('#provinsi').change(function(){
        url = "<?php echo base_url('addressPicker/list_kabupaten'); ?>";
        id = $('#provinsi').val();

        $('#list-kabupaten').load(url,{id : id});
    });

    $('#email').on("change",function(){
        var email = $(this).val();
        var checkEmail = isEmail(email);

        if(checkEmail==false){
            $('#email').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
            setTimeout( function(){$('#email').css({"box-shadow" : "","border" : ""});} , 4000);
            $.Notification.autoHideNotify('error','top right', 'Gagal!', 'Format Email Salah');
            $('#email').val('');  
        } else {
            $('#email').css({"box-shadow" : "","border" : ""}); 
        }
    });


    $('#list-kabupaten').change(function(){
        url= "<?php echo base_url('addressPicker/list_kecamatan'); ?>";        
        id = $('#list-kabupaten').val();

        $('#list-kecamatan').load(url,{id : id});
    });

    $('#noRM').on("change",function(){
        var noRM = $(this).val();
        var url = "<?php echo base_url('addressPicker/cekNoRM'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {noRM : noRM},
            success : function(response){
                if(response==0){
                    $('#noRM').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                    setTimeout( function(){$('#noID').css({"box-shadow" : "","border" : ""});} , 4000);
                    $.Notification.autoHideNotify('error','top right', 'Gagal', 'No RM telah terpakai'); 
                    $('#noRM').val('');
                } 
            }
        });
    });
</script>

