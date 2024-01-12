<div class="btn-group m-b-10">
    <?php
        if(!empty($param)){
    ?>
        <a href="<?php echo base_url('dataStokExpired/exportExcel?param='.$param); ?>" type="button" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a> 
        <a href="<?php echo base_url('dataStokExpired/exportPDF?param='.$param); ?>" type="button" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Export PDF</a> 
    <?php } else { ?>
        <a href="<?php echo base_url('dataStokExpired/exportExcel?param='); ?>" type="button" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a> 
        <a href="<?php echo base_url('dataStokExpired/exportPDF?param='); ?>" type="button" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Export PDF</a> 
    <?php } ?>
</div>