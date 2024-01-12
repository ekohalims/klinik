<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Nama Tarif</label>
            <input type="text" class="form-control" name="namaTarif" value="<?php echo $tarif->namaTarif; ?>"/>
            <input type="hidden" class="form-control" name="kodeOK" value="<?php echo $tarif->kode; ?>"/>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Kelas</label>
            <select class="form-control" name="kelas">
                <option value="NON" <?php if($tarif->kelas=='NON') {echo "selected";} ?>>NON</option>
                <option value="VIP" <?php if($tarif->kelas=='VIP') {echo "selected";} ?>>VIP</option>
                <option value="I"  <?php if($tarif->kelas=='I') {echo "selected";} ?>>I</option>
                <option value="II" <?php if($tarif->kelas=='II') {echo "selected";} ?>>II</option>
                <option value="III" <?php if($tarif->kelas=='III') {echo "selected";} ?>>III</option>
            </select>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Jenis</label>
            <select class="form-control" name="jenisTarif">
                <option value="Kecil" <?php if($tarif->jenis=='Kecil') {echo "selected";} ?>>Kecil</option>
                <option value="Sedang" <?php if($tarif->jenis=='Sedang') {echo "selected";} ?>>Sedang</option>
                <option value="Besar" <?php if($tarif->jenis=='Besar') {echo "selected";} ?>>Besar</option>
                <option value="Canggih" <?php if($tarif->jenis=='Canggih') {echo "selected";} ?>>Canggih</option>
                <option value="Khusus" <?php if($tarif->jenis=='Khusus') {echo "selected";} ?>>Khusus</option>
                <option value="Cito" <?php if($tarif->jenis=='Cito') {echo "selected";} ?>>Cito</option>
                <option value="NON" <?php if($tarif->jenis=='NON') {echo "selected";} ?>>NON</option>
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="panel panel-color panel-info">
        <div class="panel-heading"> 
            <h3 class="panel-title">Rincian Tarif</h3> 
        </div> 
        <div class="panel-body"> 
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:35%;vertical-align:middle;">Nama Tarif</th>
                        <th style="vertical-align:middle;">Keterangan</th>
                        <th style="width:30%;vertical-align:middle;">Tarif</th>
                        <th style="width:5%;vertical-align:middle;"><a class="btn btn-default btn-sm" id="tambahForm"><i class="fa fa-plus"></i></a></th>
                    </tr>
                    
                    <?php
                        $i = 1;
                        foreach($tarifRinci as $rc){
                    ?>
                        <tr id="row<?php echo $i; ?>">
                            <td><input type="text" class="form-control" name="namaTarifRinci[]" value="<?php echo $rc->namaTarif; ?>"/></td>
                            <td><input type="text" class="form-control" name="keterangan[]" value="<?php echo $rc->keterangan; ?>"/></td>
                            <td>
                                <input type="text" class="form-control" name="tarif[]" value="<?php echo $rc->tarif; ?>"/>
                                <input type="hidden" name="kode[]" value="<?php echo $rc->kodeTarif; ?>"/>
                            </td>
                            <td style="text-align:right;vertical-align:middle;"><a class="btn btn-danger btn-sm hapusOKRinci" id="<?php echo $i; ?>" data-kode_tarif="<?php echo $rc->kodeTarif; ?>"><i class="fa fa-trash"></i></a></td>
                        </tr>
                    <?php $i++; } ?>
                </thead>

                <tbody id="dataForm">
                </tbody>
            </table>            
        </div> 
    </div>
</div>

<input type="hidden" name="jenis" value="edit"/>
<input type="hidden" id="sdf" value="<?php echo $i; ?>"/>

<script type="text/javascript">
    $('#tambahForm').on("click",function(){
        var url = "<?php echo base_url('tindakan/formTarif'); ?>";

        no = parseInt($('#sdf').val());;
        urutan = no+1;

        $.get(url,{no : urutan},function(data){
            $('#dataForm').append(data);
            $('#sdf').val(urutan);
        });
    });

    $(document).on("click",".hapusForm",function(){
        var row = this.id;
        $('#row'+row).remove();
    });
</script>

