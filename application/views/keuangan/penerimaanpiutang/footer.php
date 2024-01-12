
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
<script src="<?php echo base_url('assets'); ?>/assets/printjs/print.min.js"></script>

<script type="text/javascript">
    loadDataPiutang(tempo='',penanggung='',asuransi='',noRM='',status='');

    jQuery(".select2").select2({
        width: '100%'
    });

    jQuery('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        autoclose : true
    });

    $('#pasienSelect2').select2({
        placeholder: "--Tampilkan Semua--",
        ajax: {
            url : '<?php echo base_url('penerimaanPiutang/select2Pasien'); ?>',
            dataType : 'json',
            quietMillis : 500,
            method : "GET",
            data: function(params) {
                return {
                    term : params
                };
            },
            results: function (data) {
                var myResults = [];
                $.each(data, function (index, item) {
                    myResults.push({
                        'id': item.id,
                        'text': item.text,
                    });
                });
                return {
                    results: myResults
                };
            }
        },
        minimumInputLength: 3,
    });

    $('#penanggung').change(function(){
        var idPenanggung = $(this).val();

        if(idPenanggung==2){
            var url = "<?php echo base_url('penerimaanPiutang/dropdownAsuransi'); ?>";
            $('#asuransiForm').load(url);
        } else {
            $('#asuransiForm').html("<input type='hidden' id='asuransi' value=''/>");
        }
    });

    $('#filterPiutang').on("click",function(){
        var penanggung = $('#penanggung').val();
        var asuransi = $('#asuransi').val();
        var pasien = $('#pasienSelect2').val();
        var tempo = $('#tempo').val();
        var status = $('#status').val();

        loadDataPiutang(tempo,penanggung,asuransi,pasien,status);

        $('#myModal').hide();
        $('.modal-backdrop').remove();
    });

    function loadDataPiutang(tempo,penanggung,asuransi,noRM,status){
        var url = "<?php echo base_url('penerimaanPiutang/loadDataPiutang'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {
                tempo : tempo,
                penanggung : penanggung,
                asuransi : asuransi,
                noRM : noRM,
                status : status
            },
            beforeSend : function(){
                $('#viewReportData').text("Memuat Data...");
            },
            success : function(response){
                $('#viewReportData').html(response);
            }
        });
    }
</script>

</body>
</html>
