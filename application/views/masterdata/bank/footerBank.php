
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
    loadTables();

    $('#tambahBank').on("click",function(){
        $('.modal-title').text('Tambah Bank');
        $('.modal-body').load("<?php echo base_url('bank/formTambahBank'); ?>");
    });

    $(document).on("click",".editBank",function(){
        $('.modal-title').text('Edit Bank');

        var id = this.id;
        $('.modal-body').load("<?php echo base_url('bank/formEditBank'); ?>",{id : id});
    });

    $('#buttonPoli').on("click",function(){
        var jenis = $('#jenis').val();

        if(jenis=='tambah'){
            tambahBankSQL();
        } else {
            editBankSQL();
        }
    });

    $(document).on("click",".hapusBank",function(){
        var kodeBank = this.id;
        var url = "<?php echo base_url('bank/hapusBank'); ?>";

        swal({   
            title: "Anda Yakin?",   
            text: "Data akan hilang setelah dihapus",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Yes, delete it!",   
            cancelButtonText: "No, cancel plx!",   
            closeOnConfirm: false,   
            closeOnCancel: false 
        }, function(isConfirm){   
            if (isConfirm) {     
                $.ajax({
                    method : "POST",
                    url : url,
                    data : {kodeBank : kodeBank},
                    success : function(){
                        loadTables();   
                        swal("Deleted!", "Data telah terhapus.", "success"); 
                    }
                });   
            } else {     
                swal("Cancelled", "Membatalkan penghapusan data", "error");   
            } 
        });
    });

    function tambahBankSQL(){
        var kodeAkun = $('#kodeAkun').val();
        var namaBank = $('#namaBank').val();
        var cabang = $('#cabang').val();
        var noRekening = $('#noRekening').val();
        var atasNama = $('#atasNama').val();

        if($('#debit').is(':checked')) { 
            var debit = 1;
        } else {
            var debit = '';
        }

        if($('#kredit').is(':checked')) { 
            var kredit = 1;
        } else {
            var kredit = '';
        }

        if($('#transfer').is(':checked')) { 
            var transfer = 1;
        } else {
            var transfer = '';
        }

        var url = "<?php echo base_url('bank/tambahBankSQL'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {kodeAkun : kodeAkun, namaBank : namaBank, cabang : cabang, noRekening : noRekening, atasNama : atasNama, debit : debit, kredit : kredit, transfer : transfer},
            beforeSend : function(){
                $("#buttonPoli").prop("disabled",true);
            },
            success : function(){
                $('#myModal').modal('hide');
                $("#buttonPoli").prop("disabled",false);
                loadTables();
                $.Notification.autoHideNotify('success', 'top right', 'Berhasil!','Bank telah ditambahkan');
            }
        });
    }

    function editBankSQL(){
        var kodeAkun = $('#kodeAkun').val();
        var namaBank = $('#namaBank').val();
        var cabang = $('#cabang').val();
        var noRekening = $('#noRekening').val();
        var atasNama = $('#atasNama').val();
        var status = $('#status').val();

        if($('#debit').is(':checked')) { 
            var debit = 1;
        } else {
            var debit = '';
        }

        if($('#kredit').is(':checked')) { 
            var kredit = 1;
        } else {
            var kredit = '';
        }

        if($('#transfer').is(':checked')) { 
            var transfer = 1;
        } else {
            var transfer = '';
        }

        var url = "<?php echo base_url('bank/editBankSQL'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {kodeAkun : kodeAkun, namaBank : namaBank, cabang : cabang, noRekening : noRekening, atasNama : atasNama, status : status, debit : debit, kredit : kredit, transfer : transfer},
            beforeSend : function(){
                $("#buttonPoli").prop("disabled",true);
            },
            success : function(){
                $('#myModal').modal('hide');
                $("#buttonPoli").prop("disabled",false);
                loadTables();
                $.Notification.autoHideNotify('success', 'top right', 'Berhasil!','Bank telah diubah');
            }
        });
    }

    function loadTables(){
        var urlData = "<?php echo base_url('bank/viewDataBank'); ?>";

        $.ajax({
            method : "POST",
            url : urlData,
            beforeSend : function(){
                $('#contentBank').text("Memuat data...");
            },
            success : function(response){
                $('#contentBank').html(response);
            },
        });
    }
</script>

</body>
</html>
