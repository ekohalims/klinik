<table class="table" id="datatable">
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th>Groups</th>
            <th>Date Created</th>
            <th>Date Modified</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <?php 
            $i = 1;
            foreach($view as $row){
        ?>
        <tr>
            <td><?= $i; ?></td>
            <td><?= $row->groups; ?></td>
            <td><?= nice_date($row->dateCreated,'d/m/Y H:i'); ?></td>
            <td><?= nice_date($row->dateModified,'d/m/Y H:i'); ?></td>
            <td style='text-align:right;'>
                <a href="<?= base_url('userGroup/edit/'.$row->id); ?>" class='btn btn-primary btn-sm btn-rounded'><i class="fa fa-pencil"></i></a>
                <a  class='btn btn-danger btn-sm btn-rounded hapus' id="<?= $row->id; ?>"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        <?php $i++; } ?>
    </tbody>
</table>

<script type="text/javascript">
    $('#datatable').dataTable();
</script>