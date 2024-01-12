<a class="btn btn-success btn-rounded" id="day"><i class="fa fa-calendar"></i> Hari</a>
<a class="btn btn-success btn-rounded" id="month"><i class="fa fa-calendar"></i> Bulan</a>
<a class="btn btn-success btn-rounded" id="year"><i class="fa fa-calendar"></i> Tahun</a>

<script type="text/javascript">
    $('.btn-success').on("click",function(){
        var type = this.id;
        var url = "<?php echo base_url('dashboard/dateFilterForm'); ?>";

        $('#buttonFilter').load(url,{type : type});
    });
</script>