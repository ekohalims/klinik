<span class="input-group-addon"><i class="fa fa fa-user-md"></i></span>
<select class="select2" id="dokter">
    <option value="">--Pilih Dokter--</option>

    <?php
    	foreach($dokter as $row){
    ?>
    <option value="<?php echo $row->id_dokter; ?>"><?php echo $row->nama; ?></option>
	<?php } ?>
</select>

<script type="text/javascript">
	jQuery("#dokter").select2({
        width: '100%'
    });
</script>