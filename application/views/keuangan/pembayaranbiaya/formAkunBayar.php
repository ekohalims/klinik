<td>**Akun</td>
<td>:</td>
<td>
    <select class="form-control" id="akun">
        <option value="">--Pilih Sumber Dana--</option>
        
        <?php
            foreach($akun as $row){
        ?>
        <option value="<?php echo $row->kodeSubAkun; ?>"><?php echo $row->kodeSubAkun." - ".$row->namaSubAkun; ?></option>
        <?php } ?>
    </select>
</td>
