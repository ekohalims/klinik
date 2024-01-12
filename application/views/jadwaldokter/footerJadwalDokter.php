
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
	loadDatatables();

	$(document).on("click",".editJadwal",function(){
		var id = this.id;
		var urlEditJadwal = "<?php echo base_url('jadwalDokter/formEditJadwal'); ?>";

		$('.modal-body').load(urlEditJadwal,{id : id});
	});

	$('#simpanJadwal').on("click",function(){
		var idDokter = $('#idDokter').val();

		beginSchedule = [];
        $('input[id=begin]').each(function(){
            var jadwalBegin = $(this).val();
            var idJadwalBegin = $(this).data('id_jadwal');

            item = {};

            item['jadwalBegin'] = jadwalBegin;
            item['idJadwalBegin']   = idJadwalBegin;

            beginSchedule.push(item);
        });

        endSchedule = [];
        $('input[id=end]').each(function(){
            var jadwalEnd = $(this).val();
            var idJadwalEnd = $(this).data('id_jadwal');

            item = {};

            item['jadwalEnd'] = jadwalEnd;
            item['idJadwalEnd']   = idJadwalEnd;

            endSchedule.push(item);
        });

        var urlSimpanJadwal = "<?php echo base_url('jadwalDokter/simpanJadwal'); ?>";
        $.ajax(	{
        	method : "POST",
        	url : urlSimpanJadwal,
        	data : {beginSchedule : JSON.stringify(beginSchedule), endSchedule : JSON.stringify(endSchedule),idDokter : idDokter},
        	beforeSend : function(){
        		$('#simpanJadwal').text("Harap tunggu...");
        		$('#simpanJadwal').prop("disabled",true);
        	},
        	success : function(){
        		$('#myModal').modal('hide');
        		loadDatatables();
        	}
        });
	});

    function loadDatatables(){
    	var url = "<?php echo base_url('jadwalDokter/tampilkanJadwal'); ?>";

    	$.ajax({
    		method : "POST",
    		url : url,
    		beforeSend : function(){
    			$('#loadDatatables').text("Memuat data...");
    		},
    		success : function(response){
    			$('#loadDatatables').html(response);
    		}
    	});
    }
</script>

</body>
</html>
