
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
    loadSaldoAwal();

    $(document).on("click",".saldoAwal",function(){
        var kodeAkun = this.id;
        var url = "<?php echo base_url('kasDanBank/formSaldoAwal'); ?>";

        $.post(url,{kodeAkun : kodeAkun},function(response){
            $('.modal-body').html(response);
        });

        $('#myModal').modal('show');
    });

    $(document).on("click","#simpanSaldo",function(){
        var saldo = $('#saldoAwal').val();
        var kodeAkun = $('#kodeAkun').val(); 

        if(saldo==''){
            $.Notification.autoHideNotify('error', 'top right', 'Gagal!','Harap isi saldo');
        } else {
            $.ajax({
                method : "POST",
                url : "<?php echo base_url('kasDanBank/simpanSaldoAwal'); ?>",
                data : {saldo : saldo, kodeAkun : kodeAkun},
                success : function(){
                    $('#saldoAwal').prop("disabled",true);
                    $('#saldoAwal').text("Harap tunggu...");
                    $('#myModal').modal('hide');
                    loadSaldoAwal();    
                    $.Notification.autoHideNotify('success', 'top right', 'Berhasil!','Saldo awal terinput');
                }
            });
        }
    });

    function loadSaldoAwal(){
        var urlSaldoAwal = "<?php echo base_url('kasDanBank/daftarSaldoAwal'); ?>";

        $.ajax({
            method : "GET",
            url : urlSaldoAwal,
            success : function(response){
                $('#loadSaldoAwal').html(response)
            }
        });
    }
</script>
</body>
</html>
