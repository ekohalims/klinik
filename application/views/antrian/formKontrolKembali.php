<tr style="height: 50px;">	
    <td width="30%">Tanggal Kontrol</td>
    <td><input type="text" class="form-control datepicker"  value="<?php echo $tanggalKontrol; ?>" readonly id="tanggalKontrol"/></td>
</tr>   

<script src="<?php echo base_url('assets'); ?>/assets/timepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    jQuery('.datepicker').datepicker({
		format: "yyyy-mm-dd",
		autoclose : true
	});
</script>