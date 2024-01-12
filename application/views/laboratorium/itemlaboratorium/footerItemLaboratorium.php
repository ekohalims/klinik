
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
	tampilkanTableItem();

	var successOptions = {
	    autoHideDelay: 4000,
	    showAnimation: "fadeIn",
	    hideAnimation: "fadeOut",
	    hideDuration: 400,
	    arrowShow: false,
	    className: "success",
	 }

	$('#tambahItemLab').on("click",function(){
		$('.modal-title').text("Tambah Item Laboratorium");

		var urlFormTambahItem = "<?php echo base_url('itemLaboratorium/formTambahItem'); ?>";
		$('.modal-body').load(urlFormTambahItem);
	});

	$(document).on("click",".ubahItem",function(){
		$('.modal-title').text("Ubah Item Laboratorium");

		var id = this.id;
		var urlFormEditItem = "<?php echo base_url('itemLaboratorium/formUbahItem'); ?>";
		$('.modal-body').load(urlFormEditItem,{id : id});
	});

	$(document).on("click",".hapusItem",function(){
		var id = this.id;

		var urlHapusItem = "<?php echo base_url('itemLaboratorium/hapusItem'); ?>";

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
				url : urlHapusItem,
				data :{ id :id},
				success : function(){
					tampilkanTableItem();
				}
			});

            swal("Deleted!", "Berhasil menghapus item!.", "success"); 
        });
	});

	function tampilkanTableItem(){
		var datatableItem = "<?php echo base_url('itemLaboratorium/datatableItem'); ?>";

		$.ajax({
			method : "GET",
			url : datatableItem,
			beforeSend : function(){
				$('#content').text("Harap Tunggu...");
			},
			success : function(response){
				$('#content').html(response);
			}
		});
	}

	$('#buttonItem').on("click",function(){
		var jenis = $('#jenis').val();

		if(jenis=='tambah'){
			tambahItem();
		} else {
			editItem();
		}
	})

	function tambahItem(){
		var namaLaboratorium = $('#namaLaboratorium').val();
		var harga = $('#harga').val();
		var keterangan = $('#keterangan').val();

		var urlTambahItem = "<?php echo base_url('itemLaboratorium/tambahItemSQL'); ?>";

		$.ajax({
			method : "POST",
			url : urlTambahItem,
			data : {namaLaboratorium : namaLaboratorium, harga : harga, keterangan : keterangan},
			success : function(){
				$('#myModal').modal('hide');
				tampilkanTableItem();
				$.notify("Berhasil menambah item baru!", successOptions);
			}
		});
	}

	function editItem(){
		var namaLaboratorium = $('#namaLaboratorium').val();
		var harga = $('#harga').val();
		var keterangan = $('#keterangan').val();
		var status = $('#status').val();
		var id = $('#id').val();

		var urlEditItem = "<?php echo base_url('itemLaboratorium/editItemSQL'); ?>";

		$.ajax({
			method : "POST",
			url : urlEditItem,
			data : {namaLaboratorium : namaLaboratorium, harga : harga, keterangan : keterangan, status : status, id : id},
			success : function(){
				$('#myModal').modal('hide');
				tampilkanTableItem();
				$.notify("Berhasil diubah!", successOptions);
			}
		});
	}
</script>

</body>
</html>
