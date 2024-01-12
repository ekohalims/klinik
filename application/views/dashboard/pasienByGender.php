<canvas id="chartGender" class="chart-holder" width="400" height="200"></canvas>

<script type="text/javascript">
	var trxStatus = document.getElementById("chartGender");

	var myChart = new Chart(trxStatus, {
		type 	: 'pie',
		data 	: { 
		    labels 	: <?php echo $label; ?>,
		    datasets: [{
			    label: 'Pasien Berdasarkan Jenis Kelamin',
			    data: <?php echo $dataJk; ?>,
			    backgroundColor: ['#008aff','#e2b32c'],
			    borderColor : ['#008aff','#e2b32c'],
			    fill : false,
			}]
	}

	});
</script>