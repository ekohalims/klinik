<div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
    <div class="portlet-heading">
        <h3 class="portlet-title text-dark">
            Informasi Supplier
        </h3>
    </div>

    <div id="portlet2" class="panel-collapse collapse in">
        <div class="portlet-body">
            <table class="table table-bordered">
                <tr>
                    <td width="40%">Nama Supplier</td>
                    <td><?php echo $infoSupplier->supplier; ?></td>
                </tr>

                <tr>
                    <td>Telepon</td>
                    <td><?php echo $infoSupplier->kontak; ?></td>
                </tr>

                <tr>
                    <td>Alamat</td>
                    <td><?php echo $infoSupplier->alamat; ?></td>
                </tr>

                <tr>
                    <td>No Rekening</td>
                    <td><?php echo $infoSupplier->no_rekening; ?></td>
                </tr>

                <tr>
                    <td>Bank</td>
                    <td><?php echo $infoSupplier->bank; ?></td>
                </tr>

                <tr>
                    <td>Atas Nama</td>
                    <td><?php echo $infoSupplier->atas_nama; ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>