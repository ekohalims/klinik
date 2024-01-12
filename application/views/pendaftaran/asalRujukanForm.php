<select class="select2" id="asalRujukan">
    <?php 
        foreach($rujukan as $row){
    ?>
        <option value="<?php echo $row->id; ?>"><?php echo $row->asalRujukan; ?></option>
    <?php } ?>
</select>

<script type="text/javascript">
    jQuery(".select2").select2({
        width: '100%'
    });
</script>