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
                alert('No ID Telah Terdaftar');
            }
        });
    });

    // Select2
    jQuery(".select2").select2({
        width: '100%'
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

    $('#poliklinik').on("change",function(){
        var idPoli = $(this).val();
        var urlGetDokter = "<?php echo base_url('pasienBaru/dropdownDokterPoli'); ?>";

        $("#dokterLabel").load(urlGetDokter,{idPoli : idPoli},function(){
            $("#dokter").select2({
                width : '100%'
            });
        });
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
            alert('Format Email Salah');
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
        var poliklinik = $('#poliklinik').val();
        var dokter = $('#dokter').val();
        var layanan = $("input[name='layanan']:checked").val();
        var asuransi = $('#asuransi').val();
        var noKartu = $('#noKartu').val();

        if(noID=='' || namaLengkap=='' || jenisKelamin=='' || noHP=='' || poliklinik=='' || dokter=='' || layanan==undefined){
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

            if(poliklinik==''){
                $('#poliklinikLabel').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                setTimeout( function(){$('#poliklinikLabel').css({"box-shadow" : "","border" : ""});} , 4000);
            } 

            if(dokter==''){
                $('#dokterLabel').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                setTimeout( function(){$('#dokterLabel').css({"box-shadow" : "","border" : ""});} , 4000);
            }

            if(layanan==undefined){
                $('#layananLabel').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                setTimeout( function(){$('#layananLabel').css({"box-shadow" : "","border" : ""});} , 4000);
            }
        } else {
            var urlSimpanPasien = "<?php echo base_url('pasienBaru/simpanPasienSQL'); ?>";

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
                    poliklinik : poliklinik, 
                    dokter : dokter, 
                    layanan : layanan,
                    asuransi : asuransi,
                    noKartu : noKartu
                },
                beforeSend : function(){
                    $('#simpanPasien').text('Harap Tunggu...');
                    $('#simpanPasien').prop('disabled',true);
                },
                success : function(response){
                    if(response=='Failed'){
                        alert("Pendaftaran Gagal");
                    } else {
                        var urlCetakAntrian = "<?php echo base_url('pasienBaru/cetakAntrian/'); ?>"+response;
                        window.location.replace(urlCetakAntrian);
                    }
                }
            });
        }
    });

    $('.layanan').change(function(){
        var idLayanan = $("input[name=layanan]:checked").val();
        

        if(idLayanan==2){
            var url = "<?php echo base_url('pasienBaru/dropdownAsuransi'); ?>";
            $('#tanggunganAsuransi').load(url);

            var urlKartu = "<?php echo base_url('pasienBaru/noKartuForm'); ?>";
            $('#noKartuForm').load(urlKartu);
        } else if(idLayanan==3){
            $('#tanggunganAsuransi').html("<input type='hidden' id='asuransi' value=''/>");

            var urlKartu = "<?php echo base_url('pasienBaru/noKartuForm'); ?>";
            $('#noKartuForm').load(urlKartu);
        } else {
            $('#tanggunganAsuransi').html("<input type='hidden' id='asuransi' value=''/>");
            $('#noKartuForm').html("<input type='hidden' id='noKartu' value=''/>");
        }
    });
</script>

</body>
</html>
