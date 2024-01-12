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
                
<script type="text/javascript">
    var noPendaftaran = "<?php echo $this->uri->segment(3); ?>";

    $(document).on("click",'.refund',function(){
        var opt = $(this).val();

        if(opt=='yes'){
            var urlRefund = "<?php echo base_url('pembatalanTransaksi/refundForm'); ?>";
            $('#refundForm').load(urlRefund);   
        } else {
            $('#refundForm').empty();
        }
    });

    $('#pembatalanTrx').on("click",function(){
        var url =  "<?php echo base_url('pembatalanTransaksi/statusPembayaran'); ?>";
        var urlForm = "<?php echo base_url('pembatalanTransaksi/formPembatalanType'); ?>";

        $.ajax({
            method : "POST",
            url :url,
            data : {noPendaftaran : noPendaftaran},
            success : function(response){   
                if(response==2){
                    //terbayar
                    var status = "terbayar";
                    $(".modal-body").load(urlForm,{noPendaftaran : noPendaftaran, status : status});
                } else {
                    var status = "belumTerbayar";
                    $(".modal-body").load(urlForm,{noPendaftaran : noPendaftaran, status : status});
                }
            }
        });
    });


</script>

</body>
</html>
