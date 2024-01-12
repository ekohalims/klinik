
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
    loadContentRanap();
    loadPOSRanap();
    loadKelasRanap();

    $('#tambahPosRanap').on("click",function(){
        var url = "<?php echo base_url('ruangInap/formPOSRanap'); ?>";
        $('.modal-body').load(url,{type : 'tambah', id : ''});
        $('#myModalLabel').text("Tambah POS Ruang Inap");
    });

    $('#tambahKelasRanap').on("click",function(){
        var url = "<?php echo base_url('ruangInap/formKelasRanap'); ?>";
        $('.modal-body').load(url,{type : 'tambah', id : ''});
        $('#myModalLabel').text("Tambah Kelas Ruang Inap");
    });

    $(document).on("click",".editPOS",function(){
        var url = "<?php echo base_url('ruangInap/formPOSRanap'); ?>";
        var id = this.id;

        $('.modal-body').load(url,{type : 'edit', id : id});
        $('#myModalLabel').text("Edit POS Ruang Inap");
    });

    $(document).on("click",".editKelas",function(){
        var url = "<?php echo base_url('ruangInap/formKelasRanap'); ?>";
        var id = this.id;

        $('.modal-body').load(url,{type : 'edit', id : id});
        $('#myModalLabel').text("Edit Kelas Ruang Inap");
    });

    $(document).on("click",".hapusPOS",function(){
        var id = this.id;
        var url = "<?php echo base_url('ruangInap/POSRanapSQL'); ?>";

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
                    data : {pos : '', id : id, aksi : 'hapus'},
                    success : function(){
                        loadPOSRanap();   
                        swal("Deleted!", "Data telah terhapus.", "success"); 
                    }
                });   
            } else {     
                swal("Cancelled", "Membatalkan penghapusan data", "error");   
            } 
        });
    });

    $(document).on("click",".hapusKelas",function(){
        var id = this.id;
        var url = "<?php echo base_url('ruangInap/kelasRanapSQL'); ?>";

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
                    data : {kelas : '', id : id, aksi : 'hapus'},
                    success : function(){
                        loadKelasRanap();   
                        swal("Deleted!", "Data telah terhapus.", "success"); 
                    }
                });   
            } else {     
                swal("Cancelled", "Membatalkan penghapusan data", "error");   
            } 
        });
    });

    $('#buttonSave').on("click",function(){
        var jenisForm = $('#jenisForm').val();
        var aksi = $('#aksi').val();

        if(jenisForm=='posRanap'){
            POSRanapSQL(aksi);
        } else if(jenisForm=='kelasRanap'){
            POSKelasRanapSQL(aksi);
        } else if(jenisForm=='ruangInap'){
            POSRuangInapSQL(aksi);
        }
    });
    
    $('#tambahRanap').on("click",function(){
        var url = "<?php echo base_url('ruangInap/formRuangInap'); ?>";
        $('.modal-body').load(url,{type : 'tambah', id : ''});
        $('#myModalLabel').text("Tambah Ruang Inap");
    });

    $(document).on("click",".editRanap",function(){
        var url = "<?php echo base_url('ruangInap/formRuangInap'); ?>";
        var id = this.id;
        $('.modal-body').load(url,{type : 'edit', id : id});
        $('#myModalLabel').text("Edit Ruang Inap");
    });

    $(document).on("click",".hapusRuangInap",function(){
        var id = this.id;
        var url = "<?php echo base_url('ruangInap/ruangInapSQL'); ?>";

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
                    data : {
                        id : id, 
                        aksi : 'hapus', 
                        namaRuang : '', 
                        pos : '', 
                        kelas : '',
                        kapasitas : '',
                        banyakRuang : '',
                        tarif : ''
                    },
                    success : function(){
                        loadContentRanap();   
                        swal("Deleted!", "Data telah terhapus.", "success"); 
                    }
                });   
            } else {     
                swal("Cancelled", "Membatalkan penghapusan data", "error");   
            } 
        });
    });

    function loadPOSRanap(){
        var url = "<?php echo base_url('ruangInap/viewPOSRanap'); ?>";
        $('#contentPOSRanap').load(url);
    }

    function loadKelasRanap(){
        var url = "<?php echo base_url('ruangInap/viewKelasRanap'); ?>";
        $('#contentKelasRanap').load(url);
    }

    function POSRanapSQL(aksi){
        var pos = $('#pos').val();
        var id = $('#id').val();
        var url = "<?php echo base_url('ruangInap/POSRanapSQL'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {pos : pos, aksi : aksi, id : id},
            success : function(){
                $('#myModal').modal('hide');
                loadPOSRanap();
                $.Notification.autoHideNotify('success','top right', 'Berhasil!', 'Menambah / Mengubah POS Ruang Inap');
            }
        });
    }

    function POSKelasRanapSQL(aksi){
        var kelas = $('#kelas').val();
        var id = $('#id').val();
        var url = "<?php echo base_url('ruangInap/kelasRanapSQL'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {kelas : kelas, aksi : aksi, id : id},
            success : function(){
                $('#myModal').modal('hide');
                loadKelasRanap();
                $.Notification.autoHideNotify('success','top right', 'Berhasil!', 'Menambah / Mengubah Kelas Ruang Inap');
            }
        });
    }

    function POSRuangInapSQL(aksi){
        var id = $('#id').val();
        var namaRuang = $('#namaRuang').val();
        var pos = $('#pos').val();
        var kelas = $('#kelas').val();
        var kapasitas = $('#kapasitas').val();
        var banyakRuang = $('#banyakRuang').val();
        var tarif = $('#tarif').val();
        var url = "<?php echo base_url('ruangInap/ruangInapSQL'); ?>";
        
        if(namaRuang=='' || kapasitas=='' || banyakRuang=='' || tarif==''){
            if(namaRuang==''){
                $('#namaRuangLabel').text("**Required");

                setTimeout(function() {
                    $('#namaRuangLabel').empty();
                }, 5000); 
            }

            if(kapasitas==''){
                $('#kapasitasLabel').text("**Required");

                setTimeout(function() {
                    $('#kapasitasLabel').empty();
                }, 5000); 
            }

            if(banyakRuang==''){
                $('#banyakRuangLabel').text("**Required");

                setTimeout(function() {
                    $('#banyakRuangLabel').empty();
                }, 5000); 
            }

            if(tarif==''){
                $('#tarifLabel').text("**Required");

                setTimeout(function() {
                    $('#tarifLabel').empty();
                }, 5000); 
            }
        } else {
            $.ajax({
                method : "POST",
                url : url,
                data : {
                    id : id, 
                    aksi : aksi, 
                    namaRuang : namaRuang, 
                    pos : pos, 
                    kelas : kelas,
                    kapasitas : kapasitas,
                    banyakRuang : banyakRuang,
                    tarif : tarif
                },
                success : function(response){
                    if(response=='error') {
                        $.Notification.autoHideNotify('error','top right', 'Error!', 'Harap Ulangi Kembali');
                        $('#myModal').modal('hide');
                    } else {
                        if(aksi=='edit'){
                            $('#myModal').modal('hide');
                            $.Notification.autoHideNotify('success','top right', 'Berhasil!', 'Menambah / Mengubah Ruang Inap');
                            loadContentRanap();
                        } else {
                            $('#myModal').modal('hide');
                            $.Notification.autoHideNotify('success','top right', 'Berhasil!', 'Menambah / Mengubah Ruang Inap');
                            loadContentRanap();
                        }

                    }
                },
                error : function(){
                    $.Notification.autoHideNotify('error','top right', 'Error!', 'Harap Ulangi Kembali');
                }
            });
        }
    }

    function loadContentRanap(){
        var url = "<?php echo base_url('ruangInap/viewRuangInap'); ?>";
        $('#contenRanap').load(url);
    }

    $(document).on("click",".daftarRuangEdit",function(){
        var id = this.id;
        var url = "<?php echo base_url('ruangInap/formDaftarRuang'); ?>";

        $('#contentRuangInapDaftar').load(url,{id : id});
    });

    $('#userForm').on("submit",function(){
        event.preventDefault();

        var url = "<?php echo base_url('ruangInap/updateDaftarRuang'); ?>";
        var formData = $(this).serialize();

        $.ajax({
            method : "POST",
            url : url,
            data : formData,
            success : function(){
                $('#modalDaftarRuang').modal('hide');
                $.Notification.autoHideNotify('success','top right', 'Berhasil!', 'Mengupdate ruangan');
            }
        });
    });
</script>

</body>
</html>
