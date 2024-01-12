
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
    jQuery(".select2").select2({
         width: '100%'
    });

    $('#nilaiKas').change(function(){
        var nilaiKas = $(this).val();
        var akun = $('#kas').val();

        //jumlah maksimal saldo
        var urlCekSaldo = "<?php echo base_url('kasDanBank/cekSaldoAkun'); ?>";
        $.ajax({
            method : "POST",
            url : urlCekSaldo,
            data : {akun : akun, nilaiKas : nilaiKas},
            success : function(data){
                if(data=='enough'){
                    convertHuruf(nilaiKas);
                } else {
                    $.Notification.autoHideNotify('error', 'top right', 'Gagal!','Saldo tidak mencukupi');
                    $('#nilaiKas').val('');
                    $('#terbilang').empty();
                }
            }
        });
    }); 

    function convertHuruf(nilaiKas){
        var url = "<?php echo base_url('kasDanBank/convertHuruf'); ?>";
        $.post(url,{nilaiKas : nilaiKas},function(response){
            $('#terbilang').text(response);
        });
    }

    $('#simpanKasKeluar').on("click",function(){
        var idKas = $('#kas').val();
        var sebesar = $('#nilaiKas').val();
        var memo = $('#memo').val();
        var alokasi = $('#alokasi').val();

        if(idKas=='' || sebesar=='' || memo=='' || alokasi==''){
            $.Notification.autoHideNotify('error', 'top right', 'Gagal!','Harap lengkapi form');
        } else {
            $.ajax({
                method : "POST",
                url : "<?php echo base_url('kasDanBank/simpanKasKeluar'); ?>",
                data : {idKas : idKas, sebesar : sebesar, memo : memo, alokasi : alokasi},
                beforeSend : function(){
                    $('#simpanKasKeluar').prop("disabled",true);
                },
                success : function(){
                    $.Notification.autoHideNotify('success', 'top right', 'Berhasil!','Kas keluar berhasil di input');
                    $('#simpanKasKeluar').prop("disabled",false);

                    $('#terbilang').empty();
                    $('#nilaiKas').val('');
                    $('#memo').val('');
                }
            });
        }
    });
</script>

</body>
</html>
