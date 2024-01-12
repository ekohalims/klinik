<div id="CssLoader" style="display: none;">
    <div class='spinftw'></div>
</div>

<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-4" style="text-align:right;">
            <a class="btn btn-success" id="cetakForm"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>

    <div class="row" style="margin-top:10px;">
        <div class="col-md-8 col-md-offset-2">
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12" id="print-area">
                                <table width="100%">
                                    <tr>
                                        <td> <!--header sjp-->
                                            <table width="100%">
                                                <tr style="font-size:15px;">
                                                    <td  style="vertical-align:top;" width="10%"><img src="<?php echo base_url('assets/'.$header->image); ?>" height="80px"/></td>
                                                    <td style="vertical-align:middle;">
                                                        <b><?php echo $header->namaKlinik; ?></b> <br>
                                                        <?php echo $header->alamat; ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td> <!-- end header sjp-->
                                    </tr>
                                </table>

                                <table width="100%">
                                    <tr>
                                        <td style="text-align:center;font-weight:bold;font-size:14px;">LEMBARAN MASUK DAN KELUAR</td>
                                    </tr>
                                </table>

                                <table width="100%" border="1" style="border-collapse: collapse;font-size:14px;"> 
                                    <tr>
                                        <td width="50%">
                                            No Register
                                        </td>
                                        <td width="25%">
                                            Dirawat Di RS yang ke : <br>
                                            <B>1 2 3 4 5 6 7 8 9 10</B>
                                        </td>
                                        <td width="25%" rowspan="15">
                                            KODING DIAGNOSIS UTAMA
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <table width="100%">
                                                <tr>
                                                    <td width="30%">No Rekam Medis</td>
                                                    <td width="1%">:</td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td width="30%">Nama</td>
                                                    <td width="1%">:</td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                        </td>

                                        <td>
                                            DIRAWAT TERAKHIR <br>
                                            Tgl. &nbsp &nbsp &nbsp Bln. &nbsp &nbsp &nbsp Thn.
                                        </td>
                                    </tr>

                                    <tr>
                                        <td rowspan="2">
                                            Alamat : <BR>
                                            ALAMAT 
                                            <table width="100%">
                                                <tr>
                                                    <td width="30%">Kota</td>
                                                    <td width="1%">:</td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td>Kecamatan</td>
                                                    <td>:</td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td>Desa</td>
                                                    <td>:</td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td>Telepon / HP</td>
                                                    <td>:</td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table width="100%">
                                                <tr>
                                                    <td width="50%">Status</td>
                                                    <td width="1%">:</td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td>Jenis Kelamin</td>
                                                    <td>:</td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td>Pekerjaan</td>
                                                    <td>:</td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                            Umur Waktu Masuk : 
                                            <table width="100%">
                                                <tr>
                                                    <td width="40%">Tgl Lahir</td>
                                                    <td width="1%">:</td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td>Umur</td>
                                                    <td>:</td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td rowspan="2">
                                            <table width="100%">
                                                <tr>
                                                    <td width="30%">Suku Bangsa</td>
                                                    <td width="1">:</td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td>Agama</td>
                                                    <td>:</td>
                                                    <td></td>
                                                </tr>
                                            </table>

                                            <b>Nama Ayah/Ibu/Suami/Istri </b>
                                            <table width="100%">
                                                <tr>
                                                    <td width="30%">Pekerjaan</td>
                                                    <td width="1">:</td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td>Umur</td>
                                                    <td>:</td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            Dikirim Oleh : 
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <table width="100%">
                                                <tr>
                                                    <td width="40%">Tgl Masuk</td>
                                                    <td width="1%">:</td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td>Tgl Keluar</td>
                                                    <td>:</td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td>Jam Keluar</td>
                                                    <td>:</td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>1. Umum &nbsp 2.Melahirkan &nbsp 3. By Lahir Hidup &nbsp 4.By Lahir Mati</td>
                                        <td>
                                            Lama Dirawat
                                        </td>
                                    </tr>

                                    <tr>
                                        <td rowspan="2">
                                            <center><b>JENIS PELAYANAN SPESIALIS</b></center>
                                        </td>
                                        <td>
                                            Kasus Polisi &nbsp &nbsp 1. Ya &nbsp &nbsp 2. Tidak
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            BPJS &nbsp &nbsp 1. Ya &nbsp &nbsp 2. Tidak
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <table border="1" style="border-collapase:collapase;" width="100%">
                                                <tr>
                                                    <td width="33%">
                                                        <b>RUANG RAWAT</b>
                                                    </td>
                                                    <td width="33%">
                                                        <b>KELAS</b>
                                                    </td>
                                                    <td width="33%">
                                                        <b>SEBAB DIRAWAT</b>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            Dokter Jaga Bagian Bangsal
                                        </td>
                                    </tr>

                                    <tr>
                                        <td width="10%" colspan="2">
                                            <b>DIAGNOSIS UTAMA (Hanya ada diagnosis utama dan tulislah huruf cetak)</b> <br> <br> <br> <br> <br> <br> <br> 

                                            <b>KOMPLIKASI (Tulislah dengan huruf cetak)</b>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /Portlet -->
        </div>
    </div>	
</div>

