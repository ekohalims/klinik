
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
	//tampilkanDataAsuransi();

    function formatAngka(angka) {
        if (typeof(angka) != 'string') angka = angka.toString();
        var reg = new RegExp('([0-9]+)([0-9]{3})');
        while(reg.test(angka)) angka = angka.replace(reg, '$1.$2');
        return angka;
    }

	function tampilkanDataAsuransi(){
		var urlContent = "<?php echo base_url('asuransi/viewTableAsuransi'); ?>";
		$.ajax({
			method : "GET",
			url : urlContent,
			beforeSend : function(){
				$('#content').text("Harap Tunggu...");
			},
			success : function(response){
				$('#content').html(response);
			}
		});
	}

    $('#tambahAsuransi').on("click",function(){
        $('.modal-title').text('Tambah Asuransi');
        $('.modal-body').load("<?php echo base_url('asuransi/formTambahAsuransi'); ?>");
    });

    $(document).on("click",".editAsuransi",function(){
        var idAsuransi = this.id;
        var urlFormEditAsuransi = "<?php echo base_url('asuransi/formEditAsuransi'); ?>";

        $('.modal-title').text("Edit Asuransi");
        $('.modal-body').load(urlFormEditAsuransi,{idAsuransi : idAsuransi});
    });

    $('#buttonPoli').on("click",function(){
        var jenis = $('#jenis').val();

        if(jenis=='tambah'){
            tambahTindakanSQL();
        } else {
            editTindakanSQL();
        }
    });

    $(document).on("click",".hapusAsuransi",function(){
        var idAsuransi = this.id;
        var urlHapusAsuransi = "<?php echo base_url('asuransi/hapusAsuransi'); ?>";

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
                    url : urlHapusAsuransi,
                    data : {idAsuransi : idAsuransi},
                    success : function(){
                        tampilkanDataAsuransi();
                        swal("Deleted!", "Data telah terhapus.", "success");
                    }
                });
            } else {
                swal("Cancelled", "Membatalkan penghapusan data", "error");
            }
        });
    });

    function tambahTindakanSQL(){
        var namaAsuransi = $("#namaAsuransi").val();
        var tempo = $('#tempo').val();
        var keterangan = $('#keterangan').val();

        if(namaAsuransi==''){
            if(namaAsuransi==''){
                $('#namaAsuransi').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                setTimeout( function(){
                    $('#namaAsuransi').css({"box-shadow" : "","border" : ""});
                }, 4000);
            }

        } else {
            var urlSimpanAsuransi = "<?php echo base_url('asuransi/simpanAsuransiSQL'); ?>";

            $.ajax({
                method : "POST",
                url : urlSimpanAsuransi,
                data : {namaAsuransi : namaAsuransi, keterangan : keterangan, tempo : tempo},
                beforeSend : function(){
                    $('#buttonPoli').prop("disabled",true);
                },
                success : function(){
                    $('#buttonPoli').prop("disabled",false);
                    $('#myModal').modal('hide');
                    $.Notification.autoHideNotify('success','top right', 'Berhasil!', 'Berhasil menambah asuransi');
                    tampilkanDataAsuransi();
                }
            });
        }
    }

    function editTindakanSQL(){
        var namaAsuransi = $("#namaAsuransi").val();
        var tempo = $('#tempo').val();
        var keterangan = $('#keterangan').val();
        var idAsuransi = $('#idAsuransi').val();
        var status = $('#status').val();

        if(namaAsuransi==''){
            if(namaAsuransi==''){
                $('#namaAsuransi').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                setTimeout( function(){
                    $('#namaAsuransi').css({"box-shadow" : "","border" : ""});
                }, 4000);
            }
        } else {
            var urlEditTindakan = "<?php echo base_url('asuransi/editAsuransiSQL'); ?>";

            $.ajax({
                method : "POST",
                url : urlEditTindakan,
                data : {namaAsuransi : namaAsuransi,tempo : tempo,keterangan : keterangan, status : status,idAsuransi : idAsuransi},
                beforeSend : function(){
                    $('#buttonPoli').prop("disabled",true);
                },
                success : function(){
                    $('#buttonPoli').prop("disabled",false);
                    $('#myModal').modal('hide');
                    $.Notification.autoHideNotify('success','top right', 'Berhasil!', 'Berhasil mengubah asuransi');
                    tampilkanDataAsuransi();
                }
            });
        }
    }
</script>

</body>
</html>
