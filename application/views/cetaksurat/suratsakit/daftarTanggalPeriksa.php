                    <label>Pilih Tanggal Pemeriksaan</label>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Dokter</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    $numRows = $dataPemeriksaan->num_rows();

                                    if($numRows > 0){
                                        foreach($dataPemeriksaan->result() as $dt){
                                ?>
                                    <tr>
                                        <td class="cetakSurat" id="<?php echo $dt->noPendaftaran; ?>"><a><?php echo date_format(date_create($dt->tanggalDaftar),'d M Y'); ?></a></td>
                                        <td><?php echo $dt->nama; ?></td>
                                    </tr>
                                <?php
                                        } 
                                    } else {
                                ?>
                                
                                    <tr>
                                        <td colspan="2">--Belum ada data pemeriksaan--</td>
                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>

<script type="text/javascript">
    $('.cetakSurat').on("click",function(){
        var noPendaftaran = this.id;
        var idPasien = "<?php echo $idPasien; ?>";
        var url = "<?php echo base_url('suratSakit/lamaHari'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {noPendaftaran : noPendaftaran,idPasien : idPasien},
            //beforeSend : function(){
               // var imageUrl = "<?php echo base_url('assets/Ellipsis-2s-80px.gif'); ?>";
                //$('#viewContent').html("<table width='100%'><tr><td align='center'><img src='"+imageUrl+"'/?</td></tr></table>");
            //},
            success : function(response){
                $('#content').html(response);
            },
        });
    });
</script>