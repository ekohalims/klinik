
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
<script src="<?php echo base_url('assets'); ?>/js/waypoints.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets'); ?>/js/jquery.counterup.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets'); ?>/assets/sweet-alert/sweet-alert.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/sweet-alert/sweet-alert.init.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/jquery.app.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/notifications/notify.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/notifications/notify-metro.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/notifications/notifications.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/select2/select2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets'); ?>/assets/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/timepicker/bootstrap-datepicker.js"></script>
                
<script type="text/javascript">
    loadData('satuan');

    $('.loadTarif').on("click",function(){
        var id = this.id;
        loadData(id);
        $(".isActive").val(id);
    });

    $('#tambah').on("click",function(){
        var jenis = $('.isActive').val();
        var url = "<?php echo base_url('tindakan/formTambahLab'); ?>";
        $('.modal-body').load(url,{jenis : jenis});
        $('#myModal').modal({backdrop: 'static', keyboard: false});
        $('#myModal').modal('show');
        $('#myModalLabel').text("Tambah Tarif Laboratorium");
    });

    $('#simpan').on("click",function(){
        var jenis = $('#jenis').val();

        if(jenis=='tambah'){
            tambahSQL();
        } else {
            editSQL();
        }
    });

    function tambahSQL(){
        var namaTarif = $('#namaTarif').val();
        var golongan = $('#golongan').val();
        var nilaiMin = $('#nilaiMin').val();
        var nilaiMax = $('#nilaiMax').val();
        var nilai = $('#nilai').val();
        var satuan = $('#satuanNilai').val();
        var nilaiLain = $('#nilaiLain').val();
        var tarif = $('#tarif').val();
        var keterangan = $('#keterangan').val();
        var hargaNormal = $('#hargaNormal').val();

        var url = "<?php echo base_url('tindakan/simpanLabSQL'); ?>";

        if(namaTarif=='' || golongan=='' || nilaiMin=='' || nilaiMax=='' || nilai=='' || satuan=='' || tarif==''){
            if(namaTarif==''){
                $('#namaTarifLabel').text("**Required");
                $('#namaTarif').css({"border" : "solid 1px red"});
                setTimeout(function(){
                    $('#namaTarifLabel').empty();
                    $('#namaTarif').css({"border" : ""});
                },4000);
            }

            if(golongan==''){
                $('#golonganLabel').text("**Pilih salah satu");
                $('#golongan').css({"border" : "solid 1px red"});
                setTimeout(function(){
                    $('#golonganLabel').empty();
                    $('#golongan').css({"border" : ""});
                },4000);
            }

            if(nilaiMin==''){
                $('#nilaiMinLabel').text("**Required");
                $('#nilaiMin').css({"border" : "solid 1px red"});
                setTimeout(function(){
                    $('#nilaiMinLabel').empty();
                    $('#nilaiMin').css({"border" : ""});
                },4000);
            }

            if(nilaiMax==''){
                $('#nilaiMaxLabel').text("**Required");
                $('#nilaiMax').css({"border" : "solid 1px red"});
                setTimeout(function(){
                    $('#nilaiMaxLabel').empty();
                    $('#nilaiMax').css({"border" : ""});
                },4000);
            }

            if(nilai==''){
                $('#nilaiLabel').text("**Required");
                $('#nilai').css({"border" : "solid 1px red"});
                setTimeout(function(){
                    $('#nilaiLabel').empty();
                    $('#nilai').css({"border" : ""});
                },4000);
            }

            if(satuan==''){
                $('#satuanLabel').text("**Required");
                $('#satuanNilai').css({"border" : "solid 1px red"});
                setTimeout(function(){
                    $('#satuanLabel').empty();
                    $('#satuanNilai').css({"border" : ""});
                },4000);
            }

            if(tarif==''){
                $('#tarifLabel').text("**Required");
                $('#tarif').css({"border" : "solid 1px red"});
                setTimeout(function(){
                    $('#tarifLabel').empty();
                    $('#tarif').css({"border" : ""});
                },4000);
            }
        } else {
            $.ajax({
                method : "POST",
                url : url,
                data : {
                    namaTarif : namaTarif,
                    golongan : golongan, 
                    nilaiMin : nilaiMin,
                    nilaiMax : nilaiMax,
                    nilai : nilai,
                    satuan : satuan,
                    nilaiLain : nilaiLain, 
                    tarif : tarif, 
                    keterangan : keterangan, 
                    hargaNormal : hargaNormal
                },
                beforeSend : function(){
                    $('#simpan').prop("disabled",true);
                },
                success : function(){   
                    $('#simpan').prop("disabled",false);
                    $('#myModal').modal('hide');
                    $.Notification.autoHideNotify('success','top right', 'Berhasil!', 'Berhasil menambah tarif lab'); 
                    loadData('satuan');
                },
                error : function(){
                    alert("Error, coba lagi");
                }
            });
        }
    }

    function editSQL(){
        var namaTarif = $('#namaTarif').val();
        var golongan = $('#golongan').val();
        var nilaiMin = $('#nilaiMin').val();
        var nilaiMax = $('#nilaiMax').val();
        var nilai = $('#nilai').val();
        var satuan = $('#satuanNilai').val();
        var nilaiLain = $('#nilaiLain').val();
        var tarif = $('#tarif').val();
        var keterangan = $('#keterangan').val();
        var hargaNormal = $('#hargaNormal').val();
        var kode = $('#kode').val();

        var url = "<?php echo base_url('tindakan/editLabSQL'); ?>";

        if(namaTarif=='' || golongan=='' || nilaiMin=='' || nilaiMax=='' || nilai=='' || satuan=='' || tarif==''){
            if(namaTarif==''){
                $('#namaTarifLabel').text("**Required");
                $('#namaTarif').css({"border" : "solid 1px red"});
                setTimeout(function(){
                    $('#namaTarifLabel').empty();
                    $('#namaTarif').css({"border" : ""});
                },4000);
            }

            if(golongan==''){
                $('#golonganLabel').text("**Pilih salah satu");
                $('#golongan').css({"border" : "solid 1px red"});
                setTimeout(function(){
                    $('#golonganLabel').empty();
                    $('#golongan').css({"border" : ""});
                },4000);
            }

            if(nilaiMin==''){
                $('#nilaiMinLabel').text("**Required");
                $('#nilaiMin').css({"border" : "solid 1px red"});
                setTimeout(function(){
                    $('#nilaiMinLabel').empty();
                    $('#nilaiMin').css({"border" : ""});
                },4000);
            }

            if(nilaiMax==''){
                $('#nilaiMaxLabel').text("**Required");
                $('#nilaiMax').css({"border" : "solid 1px red"});
                setTimeout(function(){
                    $('#nilaiMaxLabel').empty();
                    $('#nilaiMax').css({"border" : ""});
                },4000);
            }

            if(nilai==''){
                $('#nilaiLabel').text("**Required");
                $('#nilai').css({"border" : "solid 1px red"});
                setTimeout(function(){
                    $('#nilaiLabel').empty();
                    $('#nilai').css({"border" : ""});
                },4000);
            }

            if(satuan==''){
                $('#satuanLabel').text("**Required");
                $('#satuanNilai').css({"border" : "solid 1px red"});
                setTimeout(function(){
                    $('#satuanLabel').empty();
                    $('#satuanNilai').css({"border" : ""});
                },4000);
            }

            if(tarif==''){
                $('#tarifLabel').text("**Required");
                $('#tarif').css({"border" : "solid 1px red"});
                setTimeout(function(){
                    $('#tarifLabel').empty();
                    $('#tarif').css({"border" : ""});
                },4000);
            }
        } else {
            $.ajax({
                method : "POST",
                url : url,
                data : {
                    namaTarif : namaTarif,
                    golongan : golongan, 
                    nilaiMin : nilaiMin,
                    nilaiMax : nilaiMax,
                    nilai : nilai,
                    satuan : satuan,
                    nilaiLain : nilaiLain, 
                    tarif : tarif, 
                    keterangan : keterangan, 
                    hargaNormal : hargaNormal,
                    kode : kode
                },
                beforeSend : function(){
                    $('#simpan').prop("disabled",true);
                },
                success : function(){   
                    $('#simpan').prop("disabled",false);
                    $('#myModal').modal('hide');
                    $.Notification.autoHideNotify('success','top right', 'Berhasil!', 'Berhasil mengubah tarif lab'); 
                    loadData('satuan');
                },
                error : function(){
                    alert("Error, coba lagi");
                }
            });
        }
    }

    $(document).on("click",".editLabSatuan",function(){
        var kode = this.id;
        var url = "<?php echo base_url('tindakan/formEditLab'); ?>";
        var jenis = $('.isActive').val();
        $('#myModalLabel').text("Edit Tarif Laboratorium");
        $('.modal-body').load(url,{jenis : jenis,kode : kode});

        $('#myModal').modal('show');
    });

    $(document).on("click",".hapus",function(){
        var kode = this.id;
        var url = "<?php echo base_url('tindakan/hapusTarifLab'); ?>";

        swal({
            title: "Anda Yakin?",
            text: "Data akan hilang setelah dihapus",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No!",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    method : "POST",
                    url : url,
                    data : {kode : kode},
                    success : function(){
                        loadData('satuan');
                        swal("Deleted!", "Data telah terhapus.", "success");
                    }
                });
            } else {
                swal("Cancelled", "Membatalkan penghapusan data", "error");
            }
        });
    })

    function loadData(type){
        var url = "<?php echo base_url('tindakan/loadTarifLab'); ?>";
        $('#loadDatatables').load(url,{type : type});
    }
</script>
</body>
</html>
