<div class="col-md-6 col-xs-6">
    <table width="100%">
        <tr>
            <td style="width:25%">No Penagihan</td>
            <td width="2%">:</td>
            <td>
                <?php echo $headerTagihan->no_tagihan; ?>
            </td>
        </tr>

        <tr>
            <td>Dibuat Oleh</td>
            <td>:</td>
            <td>
                <?php echo $headerTagihan->first_name; ?>
            </td>
        </tr>

        <tr>
            <td>Status Hutang</td>
            <td>:</td>
            <td>
                <?php
                    $status = $headerTagihan->status_hutang;

                    if($status==0){
                        echo "<span class='label label-danger'>Belum Terbayar</span>";
                    } elseif($status==1){
                        echo "<span class='label label-info'>Terbayar</span>";
                    } elseif($status==2){
                        echo "<span class='label label-success'>Selesai</span>";
                    }
                ?>
            </td>
        </tr>
    </table>
</div>

<div class="col-md-6 col-xs-6">
    <table width="100%">
        <tr>
            <td style="width:25%">Supplier</td>
            <td width="2%">:</td>
            <td>
                <?php echo $headerTagihan->supplier; ?>
            </td>
        </tr>

        <tr>
            <td>Jatuh Tempo</td>
            <td>:</td>
            <td>
                <?php echo date_format(date_create($headerTagihan->jatuh_tempo),'d M Y'); ?> 
                <?php
                    if($status!=2){
                ?>
                <a href="#myModal" data-toggle="modal" id="jatuhTempoModal"><i class="fa fa-pencil"></i></a>
                <?php } ?>
            </td>
        </tr>

        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td>
                <?php echo $headerTagihan->keterangan; ?>
            </td>
        </tr>
    </table>
</div>

<div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="mySmallModalLabel">Jatuh Tempo</h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" id="jatuhTempo" class="form-control datepicker" readonly>
                    </div>
                </div>

                <div class="form-group" style="text-align:right;">
                   <a class="btn btn-success btn-rounded" id="simpanJatuhTempo"><i class="fa fa-save"></i> Simpan</a>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    $(".datepicker").datepicker({
        format: "yyyy-mm-dd",
        autoclose : true
    });

    $('#jatuhTempoModal').on("click",function(){
        var url = "<?php echo base_url('pembayaranHutangPO/getJatuhTempo'); ?>";

        $.post(url,{noTagihan : noTagihan},function(response){
            $('#jatuhTempo').val(response);
        });
    });

    $('#simpanJatuhTempo').on("click",function(){
        var jatuhTempo = $('#jatuhTempo').val();
        var url = "<?php echo base_url('pembayaranHutangPO/updateJatuhTempo'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {noTagihan : noTagihan, jatuhTempo : jatuhTempo},
            success : function(){
                loadHeaderTagihan();
                $('#myModal').modal('hide');
                $('.modal-backdrop').remove();
            }
        });
    });
</script>