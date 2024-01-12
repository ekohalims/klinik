<table class="table" id="myTable" id="print-area">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Activity</th>
            <th>Nama</th>
        </tr>
    </thead>

    <tbody>
        <?php 
            foreach($log as $row){
        ?>  
        <tr>
            <td><?php echo date_format(date_create($row->tanggal),'d F Y H:i'); ?></td>
            <td><?php echo $row->activity; ?></td>
            <td><?php echo $row->first_name." ".$row->last_name; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>