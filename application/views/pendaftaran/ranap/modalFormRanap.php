<div class="row">
    <div class="col-md-3" style="border-right:solid 1px #ddd;">
    <label>Pos</label>
        <?php
            foreach($pos as $row){
        ?>  

        <div class="col-md-12 posStyle" style="border:solid 1px #ddd;margin-bottom:3px;padding:8px;" id="pos<?php echo $row->idPos; ?>">
            <a class="pilihPos" id="<?php echo $row->idPos; ?>">
                <p style="font-weight:bold;font-size:13px;"><i class="fa fa-building"></i> <?php echo $row->pos; ?></p>
            </a>
        </div>

        <?php } ?>
    </div>

    <div class="col-md-9" id="formPilihRuangan">
        <div class="alert alert-danger" style="text-align:center;">
            Anda Belum Memilih Pos Ruangan
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.pilihPos').on("click",function(){
        var id = this.id;

        loadFormPilihKelas(id);
    }); 

    function loadFormPilihKelas(id){
        var url = "<?php echo base_url('pendaftaranRanap/formPilihGroupRuang'); ?>";
        $('#formPilihRuangan').load(url,{id : id});
        $('.posStyle').css({"border":"solid 1px #ddd"});
        $('#pos'+id).css({"border":"solid 2px #12a89d"});
    }
</script>