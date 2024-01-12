<div class="row">
	<div class="col-md-12" id="tindakLanjutContent">

	</div>
</div>



<script type="text/javascript">
    loadTindakLanjut();

    function loadTindakLanjut(){
        var urlTindakLanjut = "<?php echo base_url('antrian/dataTindakLanjut'); ?>";

        $.ajax({
            method : "POST",
            url : urlTindakLanjut,
            data : {noPendaftaran : noPendaftaran},
            beforeSend : function(){
                $('#tindakLanjutContent').text("Harap tunggu...");
            },
            success : function(response){
                $('#tindakLanjutContent').html(response);
            }
        });
    }
</script>
