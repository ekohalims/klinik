<td style="padding-left:20px;font-weight:bold;height:40px;">Account</td>
<td>
    <select class="form-control" id="subAccount">
        <?php
            foreach($subAccount as $row){
        ?>
        <option value="<?php echo $row->kodeBank; ?>"><?php echo $row->bank; ?></option>
        <?php } ?>
    </select>
</td>