<div class="row" style="margin-top: 10px;">
	<div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th>Kamar</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Keluar</th>
                    <th>Lama Hari</th>
                    <th>Tarif</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>

            <tbody id="dataKamar">
            </tbody>
        </table>
	</div>
</div>

<div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Pindah Kamar</h4>
            </div>
            <div class="modal-body" id="ruangInapModalContent">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    loadDataKamar();
    
    $(document).on("click",".launchModal",function(){
        var kodeRuang = $(this).data('kode_ruang');

        $('#myModal').modal('show');

        var url = "<?php echo base_url('inputTindakanRanap/formRanap'); ?>";
        $('#ruangInapModalContent').load(url,{ruangAsal : kodeRuang});
    });

    function loadDataKamar(){
        var url = "<?php echo base_url('inputTindakanRanap/kamarRanapPasien'); ?>";

        $('#dataKamar').load(url,{noPendaftaran : noPendaftaran});
    }
    
</script>

