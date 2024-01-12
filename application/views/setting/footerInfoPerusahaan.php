 <!-- Page Content Ends -->
            <!-- ================== -->

            <!-- Footer Start -->
            <footer class="footer">
               <?php echo $footer; ?>
            </footer>
            <!-- Footer Ends -->
        </section>
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

            $('#list-kabupaten').change(function(){
                url= "<?php echo base_url('addressPicker/list_kecamatan'); ?>";        
                id = $('#list-kabupaten').val();

                $('#list-kecamatan').load(url,{id : id});
            });

            $('#provinsi').change(function(){
                url = "<?php echo base_url('addressPicker/list_kabupaten'); ?>";
                id = $('#provinsi').val();

                $('#list-kabupaten').load(url,{id : id});
            });

            $('#simpanInfo').on("click",function(){
                var namaKlinik = $('#companyName').val();
                var kontak = $('#kontak').val();
                var address = $('#address').val();
                var provinsi = $('#provinsi').val();
                var kabupaten = $('#list-kabupaten').val();
                var kecamatan = $('#list-kecamatan').val();

                var url = "<?php echo base_url('setting/updateInfoPerusahaanSQL'); ?>";

                $.ajax({
                    method : "POST",
                    url : url,
                    data : {namaKlinik : namaKlinik, kontak : kontak, address : address, provinsi : provinsi, kabupaten : kabupaten, kecamatan : kecamatan},
                    success : function(){
                        $.Notification.autoHideNotify('success', 'top right', 'Berhasil!','Berhasil mengubah info klinik');
                    }
                });
            });
        </script>
    </body>
</html>
