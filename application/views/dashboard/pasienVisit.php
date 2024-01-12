<canvas id="pasienVisitChart" class="chart-holder" width="400" height="150"></canvas>

<script type="text/javascript">
	var trxStatus = document.getElementById("pasienVisitChart");

	var myChart = new Chart(trxStatus, {
		type 	: 'line',
		data 	: { 
		    labels 	: <?php echo $label; ?>,
		    datasets: [{
			    label: 'Grafik Kunjungan Pasien',
			    data: <?php echo $value; ?>,
			    backgroundColor: '#045f5a',
			    borderColor : '#045f5a',
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