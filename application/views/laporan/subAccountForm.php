<label>Tipe Bayar</label>
<div class="input-group">
   	<span class="input-group-addon"><i class="fa fa-money"></i></span>
    <select id="subAccountValue">
     	<option value="">--Tampilkan Semua--</option>
       	
       	<?php foreach($subAccount as $py){ ?>
            <option value="<?php echo $py->kodeBank; ?>"><?php echo $py->bank; ?></option>
        <?php } ?>
    </select>
</div>
