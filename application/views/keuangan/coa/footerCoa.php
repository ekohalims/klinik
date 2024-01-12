
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
    loadCoa();

    $(document).on("click",".showModal",function(){        
        $.ajax({
            method : "POST",
            url : "<?php echo base_url('chartOfAccount/formTambahAccount'); ?>",
            beforeSend : function(){
                var imageUrl = "<?php echo base_url('assets/Ellipsis-2s-80px.gif'); ?>";
                $('.modal-body').html("<table width='100%'><tr><td align='center' colspan='2'><img src='"+imageUrl+"'/?</td></tr></table>");
            },
            success : function(response){
                $('#myModalLabel').text("Tambah Akun");
                $('.modal-body').html(response);
            }
        });

        $('#myModal').modal('show');
    });

    $(document).on("click",".editCoa",function(){ 
        var kodeAkun = this.id;

        $.ajax({
            method : "POST",
            data : {kodeAkun : kodeAkun},
            url : "<?php echo base_url('chartOfAccount/formEditAccount'); ?>",
            beforeSend : function(){
                var imageUrl = "<?php echo base_url('assets/Ellipsis-2s-80px.gif'); ?>";
                $('.modal-body').html("<table width='100%'><tr><td align='center' colspan='2'><img src='"+imageUrl+"'/?</td></tr></table>");
            },
            success : function(response){
                $('#myModalLabel').text("Edit Akun");
                $('.modal-body').html(response);
            }
        });

        $('#myModal').modal('show');
    });

    $(document).on("click",".hapusCoa",function(){ 
        var kodeAkun = this.id;

        swal({   
            title: "Are you sure?",   
            text: "You will not be able to recover this imaginary file!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Yes, delete it!",   
            closeOnConfirm: false 
        }, function(){   
            $.ajax({
                method : "POST",
                data : {kodeAkun : kodeAkun},
                url : "<?php echo base_url('chartOfAccount/hapusCoa'); ?>",
                success : function(response){
                    loadCoa();
                    swal("Deleted!", "Your imaginary file has been deleted.", "success"); 
                }
            });
        });
    });

    function loadCoa(){
        var urlContent = "<?php echo base_url('chartOfAccount/viewCoa'); ?>";

        $.ajax({
            method : "GET",
            url : urlContent,
            beforeSend : function(){
                var imageUrl = "<?php echo base_url('assets/Ellipsis-2s-80px.gif'); ?>";
                $('#content').html("<td align='center' colspan='2'><img src='"+imageUrl+"'/?</td>");
            },
            success : function(response){
                $('#content').html(response);
            }
        });
    }
</script>              
</body>
</html>
