<?php
    if($type=='day'){
?>
    <div class="input-group pull-right" style="width:250px;text-align:right;">
        <span class="input-group-addon" style="background:#fff;"><i class="fa fa-calendar"></i></span>
        <input type="text" class="form-control datepicker tanggalValue" placeholder="Tanggal" id="day" style="background:#fff;" readonly>
        <span class="input-group-btn">
            <button type="button" class="btn btn-effect-ripple btn-danger" id="closeDate"><i class="fa fa-times"></i></button>
        </span>
    </div>
<?php } elseif($type=='month'){ ?>
    <div class="input-group pull-right" style="width:250px;text-align:right;">
        <span class="input-group-addon" style="background:#fff;"><i class="fa fa-calendar"></i></span>
        <input type="text" class="form-control datepickermonth tanggalValue" placeholder="Bulan" id="month" style="background:#fff;" readonly>
        <span class="input-group-btn">
            <button type="button" class="btn btn-effect-ripple btn-danger" id="closeDate"><i class="fa fa-times"></i></button>
        </span>
    </div>
<?php } elseif($type=='year'){ ?>
    <div class="input-group pull-right" style="width:250px;text-align:right;">
        <span class="input-group-addon" style="background:#fff;"><i class="fa fa-calendar"></i></span>
        <input type="text" class="form-control datepickeryear tanggalValue" placeholder="Tahun" id="year" style="background:#fff;" readonly>
        <span class="input-group-btn">
            <button type="button" class="btn btn-effect-ripple btn-danger" id="closeDate"><i class="fa fa-times"></i></button>
        </span>
    </div>
<?php } ?>

<script type="text/javascript">
    $(".tanggalValue").on("change",function(){
        var type = this.id;

        if(type=='day'){
            var tanggal = $(this).val();
            var bulan = '';
            var tahun = '';
        } else if(type=='month'){
            var value = $(this).val();

            var tanggal = '';
            var bulan = value.substring(0,2);
            var tahun = value.substring(3,7);
        } else if(type=='year'){
            var tanggal = '';
            var bulan = '';
            var tahun = $(this).val();
        }

        ambilDataDashboard(tanggal,bulan,tahun,type);
        loadPasienByAge(tanggal,bulan,tahun,type);
        loadPasienByGender(tanggal,bulan,tahun,type);
        loadKunjunganPasien(tanggal,bulan,tahun,type);
        loadDiagnosa(tanggal,bulan,tahun,type);
        tampilkanPeriode(tanggal,bulan,tahun,type);
    });

    $('#closeDate').on("click",function(){
        loadButtonFilter();
    });

    jQuery('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        autoclose : true
    });

    jQuery('.datepickermonth').datepicker({
        format: "mm-yyyy",
        startMode: "months", 
        minViewMode: "months",
        changeMonth: true,
        changeYear: true,
        minDate: '0d',
        maxDate: '1y',
        autoclose : true
    });

    jQuery('.datepickeryear').datepicker({
        format: "yyyy",
        startMode: "years", 
        minViewMode: "years",
        changeMonth: true,
        changeYear: true,
        minDate: '0d',
        maxDate: '1y',
        autoclose : true
    });
</script>