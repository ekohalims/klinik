<footer class="footer">
    <?php echo $footer; ?>
</footer>

</section>

<script src="<?php echo base_url('assets'); ?>/js/jquery.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/modernizr.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/pace.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/wow.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets'); ?>/assets/chat/moment-2.2.1.js"></script>

        <!-- Counter-up -->
<script src="<?php echo base_url('assets'); ?>/js/waypoints.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets'); ?>/js/jquery.counterup.min.js" type="text/javascript"></script>

        <!-- sweet alerts -->
<script src="<?php echo base_url('assets'); ?>/assets/sweet-alert/sweet-alert.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/sweet-alert/sweet-alert.init.js"></script>

<script src="<?php echo base_url('assets'); ?>/js/jquery.app.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/notifications/notify.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/notifications/notify-metro.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/notifications/notifications.js"></script>

        <!-- Todo -->
<script src="<?php echo base_url('assets'); ?>/assets/select2/select2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets'); ?>/assets/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/timepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/printjs/print.min.js"></script>
                
<script type="text/javascript">
    $('#poliklinik').change(function(){
        var idPoli = $(this).val();

        var urlGetDokter = "<?php echo base_url('pendaftaranRajal/dropdownDokterPoli'); ?>";

        $('#dokter  ').load(urlGetDokter,{idPoli : idPoli},function(){
            $('#dokter').select2({
                width : '100%'
            });
        });
    });

    $('#cariPasien').on("click",function(){
        var noPasien = $('#noPasien').val();
        var urlCariPasien = "<?php echo base_url('pendaftaranRajal/cariPasien'); ?>";
        var searchBy = $('#searchBy').val();

        $.ajax({
            method : "POST",
            url : urlCariPasien,
            data : {noPasien : noPasien,searchBy : searchBy},
            beforeSend : function(){
                $('#CssLoader').show();
            },
            success : function(response){
                if(response=='NotFound'){
                    $.Notification.notify('error','top right', 'Not Found!', 'Data pasien tidak ditemukan'); 
                    $('#CssLoader').hide();
                    emptyLabel();
                } else {
                    $('#CssLoader').hide();
                    $.Notification.notify('success','top right', 'Success!', 'Data pasien ditemukan');
                    tampilkanDataPasien(noPasien,searchBy);
                }
            }
        });
    });

    $('#daftarPasien').on("click",function(){
        var url = "<?php echo base_url('pendaftaranRajal/tablePasienModal'); ?>";
        $('.modal-body').load(url);
    });
    
    $('#daftarMhs').on("click",function(){
        var url = "<?php echo base_url('pendaftaranRajal/tableMhsModal'); ?>";
        $('#mhsForm').load(url);
    });
    
    $('#daftarTendik').on("click",function(){
        var url = "<?php echo base_url('pendaftaranRajal/tableTendikModal'); ?>";
        $('#tekdikForm').load(url);
    });

    $('#pasienBaru').on("click",function(){
        var url = "<?php echo base_url('pendaftaranRajal/formPasienBaru'); ?>";
        $("#pasienBaruForm").load(url,function(){
            $('#provinsi').select2({
                width: '100%'
            });

            $('#list-kabupaten').select2({
                width: '100%'
            });

            $('#list-kecamatan').select2({
                width: '100%'
            });
        });
    });

    jQuery(".select2").select2({
        width: '100%'
    });

    $(document).on("click",".pilihPasien",function(){
        var noRM = this.id;
        
        tampilkanDataPasienLangsung(noRM);
        $('#myModal').hide();
        $('.modal-backdrop').remove();
    });
    
    $(document).on("click",".tambahMHS",function(){
        var nim = this.id;

        $.ajax({
            method : "POST",
            url :  "<?php echo base_url('pendaftaranRajal/simpanPasienMHS'); ?>",
            data : {nim : nim},
            success : function(response){
                if(response=='Failed'){
                    $.Notification.autoHideNotify('error','top right', 'Gagal!', 'Harap ulangi kembali'); 
                } else {
                    $.Notification.autoHideNotify('success','top right', 'Berhasil!', 'Menambahkan Pasien Baru'); 
                    tampilkanDataPasienLangsung(response);
                    $('#myModalMhs').hide();
                    $('.modal-backdrop').remove();
                }
            }
        });
    });

    $('#jenisRujukan').change(function(){
        var jenisRujukan = $(this).val();


            var url = "<?php echo base_url('pendaftaranRajal/asalRujukanForm'); ?>";
            $('#asalRujukanForm').load(url,{jenisRujukan : jenisRujukan});
    
    });

    $('#launchRujukan').on("click",function(){
        var url = "<?php echo base_url('pendaftaranRajal/formTambahAsalRujukan'); ?>";
        $('#formRujukan').load(url);
    });

    $('#simpanRujukan').on("click",function(){
        var namaRujukan = $("#namaRujukan").val();
        var jenisRujukan = $("#jenisRujukanAsal").val();
        var keterangan = $('#keterangan').val();

        if(namaRujukan==''){
            if(namaRujukan==''){
                $('#namaRujukan').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                setTimeout( function(){
                    $('#namaRujukan').css({"box-shadow" : "","border" : ""});
                }, 4000);
            }

        } else {
            var urlSimpan = "<?php echo base_url('pendaftaranRajal/simpanAsalRujukanSQL'); ?>";

            $.ajax({
                method : "POST",
                url : urlSimpan,
                data : {namaRujukan : namaRujukan, jenisRujukan : jenisRujukan, keterangan : keterangan},
                beforeSend : function(){
                    $('#simpanRujukan').prop("disabled",true);
                },
                success : function(){
                    $('#simpanRujukan').prop("disabled",false);
                    $('#modalRujukan').modal('hide');
                    $.Notification.autoHideNotify('success','top right', 'Berhasil!', 'Berhasil menambah asal rujukan'); 
                }
            });
        }
    });

    $(document).on("click",'#submitPendaftaran',function(){
        var idPoliklinik = $('#poliklinik').val();
        var idDokter = $('#dokter').val();
        var jenisLayanan = $("input[name='layanan']:checked").val();
        var idPasien = $('#idPasien').val();
        var asalRujukan = $('#asalRujukan').val();
        var keluhan = $('#keluhan').val();
        var asuransi = $('#asuransi').val();
        var noKartu = $('#noKartu').val();

        var urlSubmitPendaftaran = "<?php echo base_url('pendaftaranRajal/submitPendaftaran'); ?>";

        if(idPoliklinik=='' || idDokter=='' || jenisLayanan==''){
            $.Notification.autoHideNotify('error', 'top right', 'Gagal!','Harap isi semua form');
        } else {
            $.ajax({
                method : "POST",
                url : urlSubmitPendaftaran,
                data : {
                    idPoliklinik : idPoliklinik, 
                    idDokter : idDokter, 
                    jenisLayanan : jenisLayanan,
                    idPasien : idPasien, 
                    asalRujukan : asalRujukan,
                    keluhan : keluhan,
                    asuransi : asuransi,
                    noKartu : noKartu
                },
                beforeSend : function(){
                    $('#submitPendaftaran').prop("disabled",true);
                    $('#submitPendaftaran').text("Harap Tunggu...");    
                },
                success : function(response){
                    var urlReplace = "<?php echo base_url('pendaftaranRajal'); ?>";

                    window.location.replace(urlReplace);
                },
                error : function(){
                    alert("Pendaftaran Gagal");
                }
            });
        }
    });

    $('.layanan').change(function(){
        var idLayanan = $("input[name=layanan]:checked").val();
        

        if(idLayanan==2){
            var url = "<?php echo base_url('pendaftaranRajal/dropdownAsuransi'); ?>";
            $('#tanggunganAsuransi').load(url);

            var urlKartu = "<?php echo base_url('pendaftaranRajal/noKartuForm'); ?>";
            $('#noKartuForm').load(urlKartu);
        } else if(idLayanan==3){
            $('#tanggunganAsuransi').html("<input type='hidden' id='asuransi' value=''/>");

            var urlKartu = "<?php echo base_url('pendaftaranRajal/noKartuForm'); ?>";
            $('#noKartuForm').load(urlKartu);
        } else {
            $('#tanggunganAsuransi').html("<input type='hidden' id='asuransi' value=''/>");
            $('#noKartuForm').html("<input type='hidden' id='noKartu' value=''/>");
        }
    });

    function tampilkanDataPasien(noPasien,searchBy){
        var urlPasienJSON = "<?php echo base_url('pendaftaranRajal/tampilkanPasienJSON'); ?>";

        $.ajax({
            method : "POST",
            url : urlPasienJSON,
            data : {noPasien : noPasien,searchBy : searchBy},
            dataType : 'JSON',
            success : function(response){
                $.each(response,function(x,obj){
                    $('#noPasienLabel').text(obj.noPasien);
                    $('#noIDLabel').text(obj.noID);
                    $('#namaLabel').text(obj.nama);
                    $('#tanggalLahirLabel').text(obj.tanggalLahir);
                    $('#sexLabel').text(obj.umur);
                    $('#alamatLabel').text(obj.alamat);
                    $('#idPasien').val(obj.idEncoded);
                });
            }
        });
    }

    function tampilkanDataPasienLangsung(noRM){
        var urlPasienJSON = "<?php echo base_url('pendaftaranRajal/tampilkanPasienJSONLangsung'); ?>";

        $.ajax({
            method : "POST",
            url : urlPasienJSON,
            data : {noPasien : noRM},
            dataType : 'JSON',
            success : function(response){
                $.each(response,function(x,obj){
                    $('#noPasienLabel').text(obj.noPasien);
                    $('#noIDLabel').text(obj.noID);
                    $('#namaLabel').text(obj.nama);
                    $('#tanggalLahirLabel').text(obj.tanggalLahir);
                    $('#sexLabel').text(obj.umur);
                    $('#alamatLabel').text(obj.alamat);
                    $('#idPasien').val(obj.idEncoded);
                });
            }
        });
    }

    $('#simpanPasien').on("click",function(){
        var noID = $('#noID').val();
        var namaLengkap = $('#namaLengkap').val();
        var tempatLahir = $('#tempatLahir').val();
        var tanggalLahir = $('#tanggalLahir').val();
        var jenisKelamin = $("input[name='jenisKelamin']:checked").val();
        var noHP = $('#noHP').val();
        var email = $('#email').val();
        var anotherPhone = $('#anotherPhone').val();
        var pekerjaan = $('#pekerjaan').val();
        var alamat = $('#alamat').val();
        var rtrw = $('#rt').val();
        var kelurahan = $('#kelurahan').val();
        var provinsi = $('#provinsi').val();
        var kabupaten = $('#list-kabupaten').val();
        var kecamatan = $('#list-kecamatan').val();
        var agama = $('#agama').val();
        var pendidikan = $('#pendidikan').val();   
        var namaKeluarga = $('#namaKeluarga').val();     
        var statusKawin = $('#statusKawin').val();

        if(noID=='' || namaLengkap=='' || jenisKelamin=='' || noHP==''){
            if(noID==''){
                $('#noID').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                setTimeout( function(){$('#noID').css({"box-shadow" : "","border" : ""});} , 4000);
            }

            if(namaLengkap==''){
                $('#namaLengkap').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                setTimeout( function(){$('#namaLengkap').css({"box-shadow" : "","border" : ""});} , 4000);
            }

            if(! $(".jenisKelamin").is(':checked')){
                $('#jenisKelaminBorder').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                setTimeout( function(){$('#jenisKelaminBorder').css({"box-shadow" : "","border" : ""});} , 4000);
            }

            if(noHP==''){
                $('#noHP').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                setTimeout( function(){$('#noHP').css({"box-shadow" : "","border" : ""});} , 4000);
            }
        } else {
            var urlSimpanPasien = "<?php echo base_url('pendaftaranRajal/simpanPasienSQL'); ?>";

            $.ajax({
                method : "POST",
                url : urlSimpanPasien,
                data : {
                    noID : noID, 
                    namaLengkap : namaLengkap, 
                    pekerjaan : pekerjaan, 
                    tempatLahir : tempatLahir, 
                    tanggalLahir : tanggalLahir,
                    jenisKelamin : jenisKelamin, 
                    noHP : noHP, 
                    email : email, 
                    anotherPhone : anotherPhone, 
                    alamat : alamat, 
                    rtrw : rtrw, 
                    kelurahan : kelurahan, 
                    provinsi : provinsi, 
                    kabupaten : kabupaten, 
                    kecamatan : kecamatan,
                    agama : agama, 
                    pendidikan : pendidikan, 
                    namaKeluarga : namaKeluarga, 
                    statusKawin : statusKawin
                },
                beforeSend : function(){
                    $('#simpanPasien').prop('disabled',true);
                },
                success : function(response){
                    if(response=='Failed'){
                        $.Notification.autoHideNotify('error','top right', 'Gagal!', 'Harap ulangi kembali'); 
                        $('#simpanPasien').prop('disabled',false);
                    } else {
                        $.Notification.autoHideNotify('success','top right', 'Berhasil!', 'Menambahkan Pasien Baru'); 
                        $('#newPasien').modal('hide');
                        tampilkanDataPasienLangsung(response);
                        $('#simpanPasien').prop('disabled',false);
                    }
                }
            });
        }
    });
</script>

</body>
</html>
