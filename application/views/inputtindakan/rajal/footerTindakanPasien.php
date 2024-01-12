
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
<script src="<?php echo base_url('assets'); ?>/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var noPendaftaran = $('#noPendaftaran').val();

    loadDaftarBiaya(noPendaftaran);
    loadCatatan();

    // Select2
    jQuery(".select2").select2({
        width: '100%'
    });

    $('.tabsMedic').on("click",function(){
        var tabs = this.id;
        var urlContentTabs = "<?php echo base_url('inputTindakanRajal/tabsContent'); ?>";

        $.ajax({
            method : "POST",
            url : urlContentTabs,
            data : {tabs : tabs, noPendaftaran : noPendaftaran},
            beforeSend : function(){
                $('.tab-content').text("Harap tunggu...");
            },
            success : function(response){
                $('.tab-content').html(response);
            },
        });
    });

    $('#tindakanSelesai').on("click",function(){
        swal({
            title: "Anda yakin?",
            text: "Data pasien akan disimpan dan diteruskan",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#12a89d",
            confirmButtonText: "Yes!",
            closeOnConfirm: false
        }, function(){

            var urlTindakanSelesai = "<?php echo base_url('inputTindakanRajal/tindakanApprove'); ?>";

            $.ajax({
                method : "POST",
                url : urlTindakanSelesai,
                data : {noPendaftaran : noPendaftaran},
                beforeSend : function(){
                    $('#CssLoader').show();
                },
                success : function(){
                    swal("Berhasil!", "Data pasien tersimpan", "success");
                    window.location.replace("<?php echo base_url('inputTindakanRajal'); ?>");
                }
            });


        });
    });

    function loadCatatan(){
        var urlCatatan = "<?php echo base_url('inputTindakanRajal/tabsContent'); ?>";
        var tabs="catatan";

        $('.tab-content').load(urlCatatan,{tabs : tabs});
    }

    function loadDaftarBiaya(noPendaftaran){
        var url = "<?php echo base_url('inputTindakanRajal/daftarBiaya'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {noPendaftaran : noPendaftaran},
            dataType : 'JSON',
            success : function(response){
                $.each(response,function(x,obj){
                    $('#pelayananBiaya').text(addCommas(obj.pelayanan));
                    $('#resepBiaya').text(addCommas(obj.resep));
                    $('#labBiaya').text(addCommas(obj.lab));
                    $('#radiologiBiaya').text(addCommas(obj.rad));
                    $('#subtotal').text(addCommas(obj.subtotal));
                    $('#diskon').text(addCommas(obj.diskon));
                    $('#grandTotal').text(addCommas(obj.grandTotal));
                });
            }
        });
    }

    
    function addCommas(nStr){
	    nStr += '';
	    x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + '.' + '$2');
		}
	    return x1 + x2;
	}
</script>

</body>
</html>
