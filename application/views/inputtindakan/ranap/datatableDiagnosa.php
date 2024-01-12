<table class="table table-bordered" id="datatable">
	<thead>
		<tr>
			<td style="font-weight: bold;" width="5%">No</td>
			<td style="font-weight: bold;">Kode ICD</td>
			<td style="font-weight: bold;">ICD</td>
			<td style="font-weight: bold;">Diagnosa</td>
		</tr>
	</thead>
</table>

<script type="text/javascript">
	$("#datatable").DataTable({
        ordering: false,
        processing: false,
        serverSide: true,
        ajax: {
           	url: "<?php echo base_url('inputTindakanRanap/datatableDiagnosaJSON'); ?>",
           	type:'POST'
        }
    });
</script>