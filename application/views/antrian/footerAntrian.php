
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
    loadTable(0);

    $('#datatable').dataTable();

    // Select2
    jQuery(".select2").select2({
        width: '100%'
    });

    $('#poliklinik').change(function(){
        var idPoliklinik = $(this).val();
        var dropdownPoli = "<?php echo base_url('antrian/dropdownDokter'); ?>";

        $.ajax({
            method : "POST",
            url : dropdownPoli,
            data : {idPoliklinik : idPoliklinik},
            success : function(response){
                $('#dokterSelect2').html(response);
            }
        });
    });

    $('.daftarOrder').on("click",function(){
        var status = this.id;

        //ubah warna hover widget
        if(status==0){
            $('.mini-stat').css("border-top","");
            $('#hover0').css("border-top","solid 4px rgba(235, 193, 66, 0.8)");
            $('.portlet').css("border-top","solid 4px rgba(235, 193, 66, 0.8)");
        } else if(status==1){
            $('.mini-stat').css("border-top","");
            $('#hover1').css("border-top","solid 4px rgba(3, 169, 244, 0.8)");
            $('.portlet').css("border-top","solid 4px rgba(3, 169, 244, 0.8)");
        } else if(status==2){
            $('.mini-stat').css("border-top","");
            $('#hover2').css("border-top","solid 4px rgba(0, 150, 136, 0.8)");
            $('.portlet').css("border-top","solid 4px rgba(0, 150, 136, 0.8)");
        } else if(status==3){
            $('.mini-stat').css("border-top","");
            $('#hover3').css("border-top","solid 4px rgba(203, 42, 42, 0.8)");
            $('.portlet').css("border-top","solid 4px rgba(203, 42, 42, 0.8)");
        }

        loadTable(status);
    });

    $('#lihatAntrian').on("click",function(){
        var idPoliklinik = $('#poliklinik').val();
        var idDokter = $('#dokter').val();

        var urlViewAntrian = "<?php echo base_url('antrian/tampilkanAntrian'); ?>";

        $.ajax({
            method : "POST",
            url : urlViewAntrian,
            data :{idPoliklinik : idPoliklinik, idDokter : idDokter},
            beforeSend : function(){
                $('#lihatAntrian').prop("disabled",true);
            },
            success : function(response){
                $('#CssLoader').hide();
                $('#viewContent').html(response);
                $('#myModal').modal('hide');
                $('#lihatAntrian').prop("disabled",false);
            },
            error : function(){
                alert("Gagal memuat data");
                $('#CssLoader').hide();
            }
        });
    });

    function loadTable(status){
  		var urlLoadTable = "<?php echo base_url('antrian/loadTableOrder'); ?>";
  		var imageUrl = "<?php echo base_url('assets/Ellipsis-2s-80px.gif'); ?>";

  		$.ajax({
  			method : "POST",
  			url : urlLoadTable,
  			data : {status : status},
  			beforeSend : function(){
                  $('#viewContent').html("<table width='100%'><tr><td align='center'><img src='"+imageUrl+"'/?</td></tr></table>");
              },
  			success : function(response){
  				$('#viewContent').html(response);
  			}
  		});
  	}
</script>

</body>
</html>
