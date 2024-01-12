
            <!-- Footer Start -->
<footer class="footer">
    <?php echo $footer; ?>
</footer>
            <!-- Footer Ends -->
</section>
        <!-- Main Content Ends -->

        <!-- js placed at the end of the document so the pages load faster -->
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
                
<script type="text/javascript">
    // Select2
    jQuery(".select2").select2({
        width: '100%'
    });

    $('#provinsi').change(function(){
        url = "<?php echo base_url('addressPicker/list_kabupaten'); ?>";
        id = $('#provinsi').val();

        $('#list-kabupaten').load(url,{id : id});
    });

    $('#list-kabupaten').change(function(){
        url= "<?php echo base_url('addressPicker/list_kecamatan'); ?>";        
        id = $('#list-kabupaten').val();

        $('#list-kecamatan').load(url,{id : id});
    });

    $('#simpanDokter').on("click",function(){
        var namaLengkap = $('#namaLengkap').val();
        var jenisKelamin = $("input[name='jenisKelamin']:checked").val();
        var noHP = $('#noHP').val();
        var noIzinPraktek = $('#noIzinPraktek').val();
        var poliklinik = $('#poliklinik').val();
        var alamat = $('#alamat').val();
        var provinsi = $('#provinsi').val();
        var kabupaten = $('#list-kabupaten').val();
        var kecamatan = $('#list-kecamatan').val();
        var idDokter = $('#idDokter').val();
        var status = $("input[name=status]:checked").val();

        if(namaLengkap=='' || jenisKelamin=='' || noHP=='' || poliklinik==''){
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
        } else {
            var urlEditDokter = "<?php echo base_url('dokter/editDokterSQL'); ?>";

            $.ajax({
                method : "POST",
                url : urlEditDokter,
                data : {namaLengkap : namaLengkap,jenisKelamin : jenisKelamin, noHP : noHP, noIzinPraktek : noIzinPraktek, poliklinik : poliklinik, alamat : alamat,provinsi : provinsi, kabupaten : kabupaten, kecamatan : kecamatan, idDokter : idDokter, status : status},
                beforeSend : function(){
                    $('#simpanDokter').prop('disabled',true);
                },
                success : function(){
                	$.Notification.notify('success','top right', 'Berhasil!', 'Berhasil menambah dokter'); 
                    $('#simpanDokter').prop('disabled',false);
                }
            });
        }

    });
</script>

</body>
</html>
