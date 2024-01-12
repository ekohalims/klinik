
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
<script src="<?php echo base_url('assets/chartjs/dist/Chart.min.js'); ?>"></script>         
<script src="<?php echo base_url('assets/chartjs/dist/Chart.bundle.min.js'); ?>"></script>         
<script type="text/javascript">
    var tanggal = '';
    var bulan = '';
    var tahun = '';
    var type = '';

    ambilDataDashboard(tanggal,bulan,tahun,type);
    loadPasienByAge(tanggal,bulan,tahun,type);
    loadPasienByGender(tanggal,bulan,tahun,type);
    loadKunjunganPasien(tanggal,bulan,tahun,type);
    loadDiagnosa(tanggal,bulan,tahun,type);
    tampilkanPeriode(tanggal,bulan,tahun,type);
    loadButtonFilter();

    function loadButtonFilter(){
        var url = "<?php echo base_url('dashboard/buttonFilter'); ?>";
        $('#buttonFilter').load(url);
    }

    function tampilkanPeriode(tanggal,bulan,tahun,type){
        var url = "<?php echo base_url('dashboard/titlePeriode'); ?>";
        $('#periode').load(url,{tanggal : tanggal, bulan : bulan, tahun : tahun, type : type});
    }

    function loadDiagnosa(tanggal,bulan,tahun,type){
        var url = "<?php echo base_url('dashboard/diagnosaPasien'); ?>";
        var imageUrl = "<?php echo base_url('assets/Ellipsis-2s-80px.gif'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {tanggal : tanggal, bulan :bulan, tahun : tahun, type : type},
            beforeSend : function(){
                $('#diagnosaICD').html("<table width='100%'><tr><td align='center'><img src='"+imageUrl+"'/?</td></tr></table>");
            },
            success : function(response){
                $('#diagnosaICD').html(response);
            }
        });
    }

    function ambilDataDashboard(tanggal,bulan,tahun,type){
        var urlAmbilDataDashboard = "<?php echo base_url('dashboard/dataWidget'); ?>";
    
        $.ajax({
            method : "POST",
            dataType : 'JSON',
            data : {tanggal : tanggal, bulan :bulan, tahun : tahun, type : type},
            url : urlAmbilDataDashboard,
            success : function(response){
                $.each(response,function(x,obj){
                    var jumlahPasien = obj.jumlahPasien;
                    var menungguPembayaran = obj.menungguPembayaran;
                    var permintaanLab = obj.permintaanLab;
                    var permintaanRad = obj.permintaanRad;

                    $('#jumlahPasien').text(jumlahPasien);
                    $('#menungguPembayaran').text(menungguPembayaran);
                    $('#permintaanLaboratorium').text(permintaanLab);
                    $('#permintaanRadiologi').text(permintaanRad);

                    $('.counter').counterUp({
                        delay: 100,
                        time: 1200
                    });
                });
            }
        });
    }

    function loadPasienByGender(tanggal,bulan,tahun,type){
        var urlPasienByGender = "<?php echo base_url('dashboard/pasienByGender'); ?>";
        var imageUrl = "<?php echo base_url('assets/Ellipsis-2s-80px.gif'); ?>";

        $.ajax({
            method : "POST",
            url : urlPasienByGender,
            data : {tanggal : tanggal, bulan :bulan, tahun : tahun, type : type},
            beforeSend : function(){
                $('#pasienByGender').html("<table width='100%'><tr><td align='center'><img src='"+imageUrl+"'/?</td></tr></table>");
            },
            success : function(response){
                $('#pasienByGender').html(response);
            }
        });
    }

    function loadPasienByAge(tanggal,bulan,tahun,type){
        var urlPasienByUsia = "<?php echo base_url('dashboard/pasienByAge'); ?>";
        var imageUrl = "<?php echo base_url('assets/Ellipsis-2s-80px.gif'); ?>";

        $.ajax({
            method : "POST",
            url : urlPasienByUsia,
            data : {tanggal : tanggal, bulan :bulan, tahun : tahun, type : type},
            beforeSend : function(){
                $('#pasienByAge').html("<table width='100%'><tr><td align='center'><img src='"+imageUrl+"'/?</td></tr></table>");
            },
            success : function(response){
                $('#pasienByAge').html(response);
            }
        });
    }

    function loadKunjunganPasien(tanggal,bulan,tahun,type){
        var url = "<?php echo base_url('dashboard/pasienVisit'); ?>";
        var imageUrl = "<?php echo base_url('assets/Ellipsis-2s-80px.gif'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {tanggal : tanggal, bulan :bulan, tahun : tahun, type : type},
            beforeSend : function(){
                $('#pasienVisit').html("<table width='100%'><tr><td align='center'><img src='"+imageUrl+"'/?</td></tr></table>");
            },
            success : function(response){
                $('#pasienVisit').html(response);
            }
        });
    }

    function getRandomColor() {
        var letters = '0123456789ABCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++ ) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    function addCommas(nStr){
	    nStr += '';
	    x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + '.' + '$2');
		}
	    return x1 + x2;
	}
</script>

</body>
</html>
