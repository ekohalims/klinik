<table class="table">
    <thead>
        <tr>
            <th style="width:1%;">No</th>
            <th>Lab</th>
        </tr>
    </thead>

    <tbody>
        <?php
            $i = 1;
            foreach($itemOrderLab as $row){
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row->namaLab; ?></td>
        </tr>
        <?php $i++; } ?>
    </tbody>
</table>