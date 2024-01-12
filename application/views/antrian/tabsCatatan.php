<div id="catatanContent">

</div>

<script type="text/javascript">
	loadCatatanContent();

	function loadCatatanContent(){
		var urlContent = "<?php echo base_url('antrian/loadFormCatatan'); ?>";

		$.ajax({
			method : "POST",
			url : urlContent,
			data : {noPendaftaran : noPendaftaran},
			beforeSend : function(){
				$('#catatanContent').text("Memuat data...");
			},
			success : function(response){
				$('#catatanContent').html(response);
			}
		});
	}
</script>