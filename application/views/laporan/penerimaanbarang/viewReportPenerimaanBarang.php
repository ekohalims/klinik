<div style="padding: 20px;">
	<table class="table table-striped" id="dataTable">
		<thead>
			<tr style="font-weight: bold;">
				<td width="5%">No</td>
				<td>No Penerimaan</td>
				<td>No PO</td>
				<td>Tanggal Terima</td>
				<td>Tempat Penerimaan</td>
				<td>Penerima</td>
				<td>Pemeriksa</td>
				<td>Supplier</td>
			</tr>
			</thead>
		</table>
	</div>

	<script type="text/javascript">
		var dateStart = "<?php echo $dateStart; ?>";
		var dateEnd = "<?php echo $dateEnd; ?>";
		var tempatPenerimaan = "<?php echo $tempatPenerimaan; ?>";
		var supplier = "<?php echo $supplier; ?>";

		$("#dataTable").DataTable({
	        ordering: false,
	        processing: false,
	        serverSide: true,
	        ajax: {
	            url: "<?php echo base_url('laporan/datatablePenerimaanBarang'); ?>",
	            type:'POST',
	           	data: {dateStart : dateStart,dateEnd : dateEnd, tempatPenerimaan : tempatPenerimaan, supplier : supplier}
	        }
	    });
	</script>