<td style="font-weight: bold;">Dokter</td>
<td>
    <select class="select2" id="dokter">
        <option value="">--Pilih Dokter--</option>
        
        <?php
            foreach($dokter as $dk){
        ?>
        <option value="<?php echo $dk->id_dokter; ?>"><?php echo $dk->nama; ?></option>
        <?php } ?>
    </select>
</td>

<script type="text/javascript">
    $('.select2').select2({
        width: '100%'
    });
</script>