
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
    tampilkanDaftarPoli();

    $('#tambahPoli').on("click",function(){
        var urlTambahPoli = "<?php echo base_url('poliklinik/formTambahPoli'); ?>";

        $('.modal-body').load(urlTambahPoli,function(){ 
            $('.modal-title').text("Tambah Poliklinik");
        });
    });

    $('#buttonPoli').on("click",function(){
        var jenis = $('#jenis').val();

        if(jenis=='tambah'){
            tambahPoliklinik();
        } else {
            editPoliklinik();
        }
    });

    function tambahPoliklinik(){
        var namaPoli = $('#namaPoliklinik').val();
        var keterangan = $('#keterangan').val();

        if(namaPoli==''){
            $('#namaPoliklinik').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
            $('#namaPoliLabel').text("Harap Isi Nama Poli");
            setTimeout( function(){
                $('#namaPoliklinik').css({"box-shadow" : "","border" : ""});
            }, 4000);
        } else {
            var urlSimpanPoli = "<?php echo base_url('poliklinik/simpanPoli'); ?>";

            $.ajax({
                method : "POST",
                url : urlSimpanPoli,
                data : {namaPoli : namaPoli, keterangan : keterangan},
                beforeSend : function(){
                    $('#buttonPoli').prop("disabled",true);
                },
                success : function(){
                    $('#buttonPoli').prop("disabled",false);
                    $('#myModal').modal('hide');
                    $.Notification.notify('success','top right', 'Berhasil!', 'Berhasil menambahkan poliklinik'); 
                    tampilkanDaftarPoli();
                }
            });
        }
    }

    function editPoliklinik(){
        var namaPoli = $('#namaPoliklinik').val();
        var keterangan = $('#keterangan').val();
        var status = $('#status').val();
        var idPoli = $('#idPoli').val();

        if(namaPoli==''){
            $('#namaPoliklinik').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
            $('#namaPoliLabel').text("Harap Isi Nama Poli");
            setTimeout( function(){
                $('#namaPoliklinik').css({"box-shadow" : "","border" : ""});
            }, 4000);
        } else {
            var urlEditPoli = "<?php echo base_url('poliklinik/editPoli'); ?>";

            $.ajax({
                method : "POST",
                url : urlEditPoli,
                data : {namaPoli : namaPoli, keterangan : keterangan, status : status, idPoli : idPoli},
                beforeSend : function(){
                    $('#buttonPoli').prop("disabled",true);
                },
                success : function(){
                    $('#buttonPoli').prop("disabled",false);
                    $('#myModal').modal('hide');
                    $.Notification.notify('success','top right', 'Berhasil!', 'Berhasil mengubah poliklinik'); 
                    tampilkanDaftarPoli();
                }
            });
        }
    }

    function tampilkanDaftarPoli(){
        var urlDaftarPoli = "<?php echo base_url('poliklinik/viewDaftarPoli'); ?>";
        $('#daftarPoli').load(urlDaftarPoli);
    }

    $(document).on("click",".editPoli",function(){
        var idPoli = this.id;
        $('#myModal').modal('show');

        var urlEditPoli = "<?php echo base_url('poliklinik/formEditPoli'); ?>";
        $('.modal-body').load(urlEditPoli,{idPoli : idPoli},function(){
            $('.modal-title').text("Edit Poliklinik");
        });
    });

    $(document).on("click",".hapusPoli",function(){
        var idPoli = this.id;
        var urlHapusPoli = "<?php echo base_url('poliklinik/hapusPoli'); ?>";

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
                    url : urlHapusPoli,
                    data : {idPoli : idPoli},
                    success : function(){
                        tampilkanDaftarPoli();   
                        swal("Deleted!", "Data telah terhapus.", "success"); 
                    }
                });   
            } else {     
                swal("Cancelled", "Membatalkan penghapusan data", "error");   
            } 
        });
    });
</script>

</body>
</html>
