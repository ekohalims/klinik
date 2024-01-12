<canvas id="chartSalesByAge" class="chart-holder" width="400" height="200"></canvas>

<script type="text/javascript">
	var trxStatus = document.getElementById("chartSalesByAge");

	var myChart = new Chart(trxStatus, {
		type 	: 'bar',
		data 	: { 
		    labels 	: <?php echo $ageGroup; ?>,
		    datasets: [{
			    label: 'Pasien Berdasarkan Usia',
			    data: <?php echo $ageCount; ?>,
			    backgroundColor: '#e2b32c',
			    borderColor : '#e2b32c',
			    fill : false,
			}]
	}, options: {
		scales: {
			yAxes: [{
			    ticks: {
					beginAtZero:true,
						userCallback: function(value, index, values) {
						    return addCommas(value);
						}
				}
			}]
		}, tooltips: {
			enabled: true,  
				callbacks: {
					label: function(tooltipItems, data) { 
						return addCommas(tooltipItems.yLabel);
				    }
				}
			}
		}

	});
</script>