<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Nama Tarif</label>
            <input type="text" class="form-control" id="namaTarif"/>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Golongan</label>
            <select class="form-control" id="golongan">
                <option value="">--Pilih Golongan--</option>

                <?php
                    foreach($kategori as $kt){
                ?>
                <option value="<?php echo $kt->idKategori; ?>"><?php echo $kt->kategori; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>Keterangan</label>
            <textarea class="form-control" id="keterangan"></textarea>
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel panel-color panel-info">
            <div class="panel-heading"> 
                <h3 class="panel-title">Rincian Paket</h3> 
            </div> 
            <div class="panel-body"> 
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:35%;vertical-align:middle;">Nama Tarif</th>
                            <th style="width:30%;vertical-align:middle;">Tarif</th>
                            <th style="width:5%;vertical-align:middle;text-align:right;"><a class="btn btn-default btn-sm" id="tambahForm"><i class="fa fa-plus"></i></a></th>
                        </tr>

                        <tr id="row0">
                            <td>
                                <input type="hidden" class="select2Lab" style="width:100%;"/>
                            </td>
                            <td style="vertical-align:middle;">
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
</div>

<script type="text/javascript">
    $('#tambahForm').on("click",function(){
        var url = "<?php echo base_url('tindakan/formTarifLabRinci'); ?>";

        no = parseInt($('#sdf').val());;
        urutan = no+1;

        $.get(url,{no : urutan},function(data){
            $('#dataForm').append(data);
            $('#sdf').val(urutan);
        });
    });
    
    $(document).on("click",".hapusForm",function(){
        var id = this.id;
        $('#row'+id).remove();
    });

    $('.select2Lab').select2({
        placeholder: "Pilih Tarif Lab",
        ajax: {
            url : '<?php echo base_url('tindakan/select2Lab'); ?>',
            dataType : 'json',
            quietMillis : 500,
            method : "GET",
            data: function (params) {
                return {
                term : params
                };
            },
            results: function (data) {
                var myResults = [];
                $.each(data, function (index, item) {
                    myResults.push({    
                        'id': item.id,
                        'text': item.text,
                        });
                });

                return {
                    results: myResults
                };
            }
        },
        minimumInputLength: 3,
    });
</script>