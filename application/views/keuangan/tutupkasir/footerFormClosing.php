
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
    var idKasir = "<?php echo $this->uri->segment(3); ?>";
    var tanggal = "<?php echo $this->uri->segment(4); ?>";

    loadContentClosing();
    loadButtonTrx();

    $(document).on('click','#trxSelesai',function(){
        var cash = $('#cash').val();
        var transfer = $('#transfer').val();

        debit = [];
        $('input[id=debit]').each(function(){
            var nilaiClosing  = $(this).val();
            var subAccount = $(this).data('sub_account');

            item = {};
            item['nilaiClosing'] = nilaiClosing;
            item['subAccount'] = subAccount;

            debit.push(item);
        });

        kredit = [];
        $('input[id=kredit]').each(function(){
            var nilaiClosing  = $(this).val();
            var subAccount = $(this).data('sub_account');

            item = {};
            item['nilaiClosing'] = nilaiClosing;
            item['subAccount'] = subAccount;

            kredit.push(item);
        });

        swal({   
            title: "Are you sure?",   
            text: "Pastikan data closing telah terisi dengan benar!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#12a89d",   
            confirmButtonText: "Yes!",   
            closeOnConfirm: false 
        }, function(){   
            var url = "<?php echo base_url('tutupKasir/submitClosing'); ?>";

            $.ajax({
                method : "POST",
                url : url,
                data : {idKasir : idKasir, tanggalTrx : tanggal,cash : cash, transfer : transfer, debit : JSON.stringify(debit), kredit : JSON.stringify(kredit)},
                success : function(){
                    loadContentClosing();
                    loadButtonTrx();
                    swal("Berhasil!", "Data telah terinput.", "success"); 
                }
            });
        });
    });

    $(document).on('click','#batalkanTrx',function(){
        swal({   
            title: "Are you sure?",   
            text: "Data closing sebelumnya akan dihapus!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Yes!",   
            closeOnConfirm: false 
        }, function(){   
            var url = "<?php echo base_url('tutupKasir/batalkanClosing'); ?>";

            $.ajax({
                method : "POST",
                url : url,
                data : {idKasir : idKasir, tanggalTrx : tanggal},
                success : function(){
                    loadContentClosing();
                    loadButtonTrx();
                    swal("Berhasil!", "Data telah terinput.", "success"); 
                }
            });
        });
    });

    function loadContentClosing(){
        var url = "<?php echo base_url('tutupKasir/contentClosing'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {idKasir : idKasir, tanggal : tanggal},
            beforeSend : function(){
                var imageUrl = "<?php echo base_url('assets/Ellipsis-2s-80px.gif'); ?>";
                $('#formClosing').html("<table width='100%'><tr><td align='center'><img src='"+imageUrl+"'/?</td></tr></table>");
            },
            success : function(response){
                $('#formClosing').html(response);
            }
        });
    }

    function loadButtonTrx(){
        var url = "<?php echo base_url('tutupKasir/buttonTrx'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {idKasir : idKasir, tanggal : tanggal},
            success : function(response){
                $('#buttonTrx').html(response);
            }
        });
    }
</script>

</body>
</html>
