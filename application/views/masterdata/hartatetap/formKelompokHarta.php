<select class="select2" id="kelompokHarta">      
    <option value=''>--Pilih Kelompok Harta--</option>
    <?php
        foreach($kelompokHarta as $row){
    ?>
    <option value="<?php echo $row->id; ?>"><?php echo $row->nama; ?></option>                   
    <?php } ?>               
</select>

<script type="text/javascript">
    jQuery(".select2").select2({
        width: '100%'
    });
</script>