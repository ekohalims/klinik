<tr id="row<?php echo $urutan; ?>">
    <td><input type="text" class="form-control" name="namaTarifRinci[]"/></td>
    <td><input type="text" class="form-control" name="keterangan[]"/></td>
    <td>
        <input type="text" class="form-control" name="tarif[]"/>
        <input type="hidden" name="kode[]" value=""/>
    </td>
    <td style="text-align:right;vertical-align:middle;"><a class="btn btn-danger btn-sm hapusForm" id="<?php echo $urutan; ?>" data-kode_tarif=""><i class="fa fa-trash"></i></a></td>
</tr>