<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Nama Tarif</label>
            <input type="text" class="form-control" name="namaTarif"/>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Kelas</label>
            <select class="form-control" name="kelas">
                <option value="NON">NON</option>
                <option value="VIP">VIP</option>
                <option value="I">I</option>
                <option value="II">II</option>
                <option value="III">III</option>
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

                    <tr id="row0">
                        <td><input type="text" class="form-control" name="namaTarifRinci[]"/></td>
                        <td><input type="text" class="form-control" name="keterangan[]"/></td>
                        <td>
                            <input type="text" class="form-control" name="tarif[]"/>
                        </td>
                        <td style="text-align:right;vertical-align:middle;"><a class="btn btn-danger btn-sm hapusForm" id="0"><i class="fa fa-trash"></i></a></td>
                    </tr>
                </thead>

                <tbody id="dataForm">
                </tbody>
            </table>            
        </div> 
    </div>
</div>

<input type="hidden" name="jenis" value="tambah"/>
<input type="hidden" id="sdf" value="0"/>

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

