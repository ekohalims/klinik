
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

    jQuery('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        autoclose : true
    });

    $('#simpanKelompokHarta').on("click",function(){
        var kelompokHarta = $('#kelompokHartaAkun').val();

        var url = "<?php echo base_url('hartaTetap/saveKelompokHarta'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {kelompokHarta : kelompokHarta},
            success : function(){
                $('#myModal').modal('hide');
                $.Notification.autoHideNotify('success', 'top right', 'Berhasil!','Kelompok harta berhasil ditambahkan');
                $('#kelompokHartaAkun').val('');
                loadKelompokHarta();
            }
        });
    });

    $('#editAset').on("click",function(){
        var kodeAset = $('#kodeAset').val();
        var nama = $('#nama').val();
        var kelompokHarta = $('#kelompokHarta').val();
        var tanggalBeli = $('#tanggalBeli').val();
        var hargaBeli = $('#hargaBeli').val();
        var nilaiResidu = $('#nilaiResidu').val();
        var umurEkonomis = $('#umurEkonomis').val();
        var metode = $('#metode').val();
        var akunHarta = $('#akunHarta').val();
        var akumulasiDepresiasi = $('#akumulasiDepresiasi').val();
        var depresiasi = $('#depresiasi').val();

        $.ajax({
            method : "POST",
            url : "<?php echo base_url('hartaTetap/editAsetSQL'); ?>",
            data : {kodeAset : kodeAset, nama : nama, kelompokHarta : kelompokHarta, tanggalBeli : tanggalBeli, hargaBeli : hargaBeli,nilaiResidu : nilaiResidu,umurEkonomis : umurEkonomis,metode : metode,akunHarta : akunHarta,akumulasiDepresiasi : akumulasiDepresiasi,depresiasi : depresiasi},
            beforeSend : function(){
                $('#edit').prop("disabled",true);
            },
            success : function(){
                $('#edit').prop("disabled",false);
                $.Notification.autoHideNotify('success', 'top right', 'Berhasil!','Berhasil mengubah Aset');
            },
            error : function(){
                $.Notification.autoHideNotify('error', 'top right', 'Gagal!','Gagal menambah Aset');
            }
        });
    });
    

    function loadKelompokHarta(){
        var url ='<?php echo base_url('hartaTetap/formKelompokHarta'); ?>';

        $('#formKelompokHarta').load(url);
    }
</script>

</body>
</html>
