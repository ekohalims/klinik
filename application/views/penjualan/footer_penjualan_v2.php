
            <!-- Footer Ends -->
        </section>
        <!-- Main Content Ends -->
        
        <!-- js placed at the end of the document so the pages load faster -->
        <script src="<?php echo base_url('assets'); ?>/js/jquery.js"></script>
        <script src="<?php echo base_url('assets'); ?>/js/scanner/jquery.scannerdetection.js"></script>
        <script src="<?php echo base_url('assets'); ?>/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url('assets'); ?>/js/jquery.scrollTo.min.js"></script>
        <script src="<?php echo base_url('assets'); ?>/js/jquery.nicescroll.js" type="text/javascript"></script>

        <!-- sweet alerts -->
        <script src="<?php echo base_url('assets'); ?>/assets/sweet-alert/sweet-alert.min.js"></script>
        <script src="<?php echo base_url('assets'); ?>/assets/sweet-alert/sweet-alert.init.js"></script>


        <!-- Dashboard -->

        <!-- Todo -->
        <script src="<?php echo base_url('assets'); ?>/js/jquery.todo.js"></script>
        <script src="<?php echo base_url('assets'); ?>/js/jquery.app.js"></script>
        <script src="<?php echo base_url('assets'); ?>/assets/select2/select2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets'); ?>/assets/timepicker/bootstrap-datepicker.js"></script>
        <script src="<?php echo base_url('assets'); ?>/assets/notifications/notify.min.js"></script>
        <script src="<?php echo base_url('assets'); ?>/assets/notifications/notify-metro.js"></script>
        <script src="<?php echo base_url('assets'); ?>/assets/notifications/notifications.js"></script>
        <script src="<?php echo base_url('assets'); ?>/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets'); ?>/assets/spinner/spinner.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets'); ?>/assets/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url('assets'); ?>/assets/datatables/dataTables.bootstrap.js"></script>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                tampilkanDaftarHarga();
                autoloadComponent();
                customerTerpilihOrNot();
                alamatPengirimanIsFill();
            });

            jQuery('.datepicker').datepicker({
                format: "yyyy-mm-dd"
            });

            $("#tableNiceScroll").niceScroll();

            $('.cartMenu').niceScroll();

            $('#searchMenu').on("keyup",function(){
                var search = $(this).val();

                $.ajax({
                            method : "POST",
                            data : {search : search},
                            url : "<?php echo base_url('penjualan/viewMenu'); ?>",
                            success : function(data){
                                        $('#viewMenu').html(data);
                                      }
                });
            });

            $('.kategoriProduk').on("click",function(){
                var idKategori = this.id;

                $.ajax({
                            method : "POST",
                            data : {idKategori : idKategori},
                            url : "<?php echo base_url('penjualan/viewMenu'); ?>",
                            beforeSend : function(){
                                $('#daftarMenu').toggle('slide',{direction : 'left'},500);
                            },
                            success : function(data){
                                        $('#viewMenu').html(data);
                                        $('#idKategori').val(idKategori);
                                      }
                });
            });

            $(document).scannerDetection(function(val){
                var sku = val;
                //get data produk
                urlProduk = "<?php echo base_url('penjualan/getDataProduk'); ?>"; 

                $.ajax({
                            type     : "POST",
                            url      : urlProduk,
                            dataType : 'json',
                            data     : {sku : sku},
                            success  : function(response){
                                        $.each(response, function(x,obj){
                                            var harga = obj.harga;
                                            var stok = obj.stok;
                                            var type = obj.type;
                                            var qty = 1;

                                            if(type != 3){
                                                if(parseInt(stok) > 0){
                                                    var urlCart = "<?php echo base_url('penjualan/insertCart'); ?>";
                                                    
                                                    $.post(urlCart,{sku : sku, harga : harga, stok : stok, qty : qty},function(hasil){

                                                        if(hasil=='0'){
                                                            alert("Stok Tidak Mencukupi");
                                                        } else {
                                                            var dataUrl = "<?php echo base_url('penjualan/viewCart'); ?>";
                                                            $('#data-input').load(dataUrl);
                                                            viewPricePanel();
                                                        }
                                                    });

                                                } else {
                                                    alert("Stok Tidak Mencukupi");
                                                    $('#data-input').load(dataUrl);
                                                    viewPricePanel();
                                                }
                                                
                                            } else {
                                                var dataUrl = "<?php echo base_url('penjualan/viewCart'); ?>";
                                                $('#data-input').load(dataUrl);
                                                viewPricePanel();
                                            }
                                            
                                        });

                                        $('#produk-ajax').select2("val","");
                                      }   
                });
            });

            // Select2
            jQuery(".select2").select2({
                width: '100%'
            });

            $('#provinsi').change(function(){
                url = "<?php echo base_url('penjualan/list_kabupaten'); ?>";

                id = $('#provinsi').val();

                $('#list-kabupaten').load(url,{id : id});
            });

            $('#list-kabupaten').change(function(){
                url= "<?php echo base_url('penjualan/list_kecamatan'); ?>";
                
                id = $('#list-kabupaten').val();

                $('#list-kecamatan').load(url,{id : id});
            });

            $('#provinsiPenerima').change(function(){
                url = "<?php echo base_url('penjualan/list_kabupaten'); ?>";

                id = $('#provinsiPenerima').val();

                $('#kabupatenPenerima').load(url,{id : id});
            });

            $('#kabupatenPenerima').change(function(){
                url= "<?php echo base_url('penjualan/list_kecamatan'); ?>";
                
                id = $('#kabupatenPenerima').val();

                $('#kecamatanPenerima').load(url,{id : id});
            });

            function viewPricePanel(){
                var totalPurchaseUrl = "<?php echo base_url('penjualan/totalPurchase'); ?>";
                var diskonPeritemUrl = "<?php echo base_url('penjualan/diskonPeritemPanel'); ?>";
                var urlDiskonDisplay = "<?php echo base_url('penjualan/diskonMemberDisplay'); ?>";
                var urlMemberPoin    = "<?php echo base_url('penjualan/data_customer_poin'); ?>";
                var urlNilaiReimburs = "<?php echo base_url('penjualan/viewNilaiReimburs'); ?>";
                var urlViewOngkir = "<?php echo base_url('penjualan/viewOngkir'); ?>";
                var urlViewDiskon = "<?php echo base_url('penjualan/viewDiskon'); ?>";
                var urlGrandTotal = "<?php echo base_url('penjualan/viewGrandTotal'); ?>";

                //price right panel
                $('#total_purchase').load(totalPurchaseUrl);

                //diskon peritem
                $('#diskonPeritem').load(diskonPeritemUrl);

                //diskon member
                $('#diskonMember').load(urlDiskonDisplay);

                //diskon member
                $('#data-customer').load(urlMemberPoin);

                //poin reimburs
                $('#poin-value-reimburs').load(urlNilaiReimburs);

                //view ongkir
                $('#ongkirText').load(urlViewOngkir);

                //view diskon
                $('#diskon_promosi').load(urlViewDiskon);

                //grand total
                $('#grand_total').load(urlGrandTotal);
            }

            function tampilkanDaftarHarga(){
                $.ajax({
                            method : "POST",
                            url : "<?php echo base_url('penjualan/tampilkanDaftarHarga'); ?>",
                            data : {id : 1},
                            dataType : "json",
                            success : function(response){
                                        $.each(response,function(x,obj){
                                            $('#grandTotal').text(formatAngka(obj.grandTotal));
                                            $('#subtotal').text(formatAngka(obj.subtotal));
                                            $('#diskon').text(formatAngka(obj.diskon));
                                            $('#ongkirLabel').text(formatAngka(obj.ongkir));
                                            $('#poinReimbursLabel').text(formatAngka(obj.poinReimburs));
                                        });
                                      }
                });
            }

            $('#customer-form').select2({
                placeholder: "Pilih Data Customer",
                ajax: {
                    url         : '<?php echo base_url('penjualan/ajax_customer'); ?>',
                    dataType    : 'json',
                    quietMillis : 100,
                    method      : "GET",
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
                                'text': item.text
                            });
                        });
                        return {
                            results: myResults
                        };
                    }
                },
                minimumInputLength: 3,
            });

            $('#produk-ajax').select2({
                placeholder: "Pilih Data Produk",
                ajax: {
                    url         : '<?php echo base_url('penjualan/ajax_produk'); ?>',
                    dataType    : 'json',
                    quietMillis : 500,
                    method      : "GET",
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

            $('.deleteCustomerButton').on("click",function(){
                var urlDeleteCustomerCart = "<?php echo base_url('penjualan/deleteCustomerCart'); ?>";
            
                $.ajax({
                            method : "POST",
                            url : urlDeleteCustomerCart,
                            success : function(){
                                        tampilkanDaftarHarga();
                                        $('#customerTerpilih').html("<i class='fa fa-user'></i> Customer");
                                        $('.deleteCustomerButton').empty();
                                        $('#idCustomer').val('');
                                      }
                });
            });

            function formatAngka(angka) {
                 if (typeof(angka) != 'string') angka = angka.toString();
                 var reg = new RegExp('([0-9]+)([0-9]{3})');
                 while(reg.test(angka)) angka = angka.replace(reg, '$1.$2');
                 return angka;
            }

            $(document).on("click",".produkAjax",function(){
                var sku = this.id;
                //get data produk
                urlProduk = "<?php echo base_url('penjualan/getDataProduk'); ?>"; 

                $.ajax({
                            type     : "POST",
                            url      : urlProduk,
                            dataType : 'json',
                            data     : {sku : sku},
                            success  : function(response){
                                        $.each(response, function(x,obj){
                                            var harga = obj.harga;
                                            var stok = obj.stok;
                                            var type = obj.type;
                                            var qty = 1;

                                            if(type != 3){
                                                if(parseInt(stok) > 0){
                                                    var urlCart = "<?php echo base_url('penjualan/insertCart'); ?>";
                                                    
                                                    $.post(urlCart,{sku : sku, harga : harga, stok : stok, qty : qty},function(hasil){

                                                        if(hasil=='0'){
                                                            $.Notification.notify('error','top right', 'Gagal', 'Stok tidak mencukupi');
                                                        } else {
                                                            var dataUrl = "<?php echo base_url('penjualan/viewCart'); ?>";
                                                            $('#data-input').load(dataUrl);
                                                            tampilkanDaftarHarga();
                                                        }
                                                    });

                                                } else {
                                                    $.Notification.notify('error','top right', 'Gagal', 'Stok tidak mencukupi');
                                                    $('#data-input').load(dataUrl);
                                                    tampilkanDaftarHarga();
                                                }
                                                
                                            } else {
                                                var urlCart = "<?php echo base_url('penjualan/insertCart'); ?>";
                                                    
                                                $.post(urlCart,{sku : sku, harga : harga, stok : stok, qty : qty},function(hasil){
                                                    var dataUrl = "<?php echo base_url('penjualan/viewCart'); ?>";
                                                    $('#data-input').load(dataUrl);
                                                    tampilkanDaftarHarga();
                                                });
                                            }
                                            
                                        });

                                        $('#produk-ajax').select2("val","");
                                      }   
                });
            });
           
            $('#diskon').on("keyup",function(){
                var diskon      = $('#diskon').val();
                var urlDiskon   = "<?php echo base_url('penjualan/insertDiskon'); ?>";

                $.post(urlDiskon,{diskon : diskon},function(){
                    var urlViewDiskon = "<?php echo base_url('penjualan/viewDiskon'); ?>";
                    $('#diskon_promosi').load(urlViewDiskon);
                    viewPricePanel();
                });
            });

            $(document).on("change","#customer-form",function(){
                id_customer = $('#customer-form').val();

                $.ajax({
                            type    : 'POST',
                            url     : "<?php echo base_url('penjualan/get_diskon_customer'); ?>",
                            data    : {id : id_customer},
                            success : function(diskon){
                                        displayDiskonMember(diskon,id_customer);
                                        
                                      }
                      });
            });

            function displayDiskonMember(diskon,id_customer){
                $.ajax({
                            type    : "POST",
                            url     : totalPurchaseUrl,
                            success : function(totalPurchase){  
                                        total = totalPurchase.split('.').join("");

                                        totalDiskon = (diskon/100)*total;

                                        //simpan di database
                                        var urlDiskon = "<?php echo base_url('penjualan/saveDiskonMember'); ?>";
                                        $.post(urlDiskon,{totalDiskon : totalDiskon, idCustomer : id_customer},function(){
                                            //
                                            var urlDiskonDisplay = "<?php echo base_url('penjualan/diskonMemberDisplay'); ?>";
                                            $('#diskonMember').load(urlDiskonDisplay);
                                            viewPricePanel();
                                        });

                                        //$('#diskon_text').text(formatAngka(totalDiskon));
                            }
                });
            }


            $('#payment_total_notif').on("click",function(){
                $('#payment_total_notif').css("display","none");
            });


            $('#customer-form').change(function(){
                id_customer = $('#customer-form').val();

                url = "<?php echo base_url('penjualan/data_customer_poin'); ?>";
                
                $('#data-customer').load(url,{id : id_customer});
            });


            $('#type_bayar').change(function(){
                type = $('#type_bayar').val();

                sub_account = "<?php echo base_url('penjualan/sub_account'); ?>";
                tempo_form  = "<?php echo base_url('penjualan/tempo_form'); ?>";
                
                if(type != 5){
                    $('#tempo-place').load(sub_account,{id : type});
                } else {
                    $('#tempo-place').load(tempo_form);
                }
                
            });  



            $('#prosesPenjualan').on("click",function(){
                submitPenjualan();
            });

            $('#jumlah_bayar').keypress(function (e) {
             var key = e.which;
             if(key == 13){
                submitPenjualan();
              }
            }); 

            $('#pendingTrx').on("click",function(){
                $.ajax({
                            method : "POST",
                            url : "<?php echo base_url('penjualan/pendingTrx'); ?>",
                            beforeSend : function(){
                                            $('#CssLoader').show();
                                         },
                            success : function(){
                                        location.reload(true);
                                      }
                });
            });

            $('#cancelTrx').on("click",function(){
                $.ajax({
                            method : "POST",
                            url : "<?php echo base_url('penjualan/cancelTrx'); ?>",
                            beforeSend : function(){
                                            $('#CssLoader').show();
                                         },
                            success : function(){
                                        location.reload(true);
                                      }
                });
            });

            function submitPenjualan(){
                var urlTotalKeseluruhan = "<?php echo base_url('penjualan/totalKeseluruhan'); ?>";
                var jumlah_bayar = $('#jumlah_bayar').val();
                var typeBayar = $('#typeBayar').val();

                $.ajax({
                            type        : "POST",
                            url         : urlTotalKeseluruhan,
                            success     : function(totalPurchase){
                                            if(typeBayar != 5){
                                                if(parseInt(jumlah_bayar) < parseInt(totalPurchase) || jumlah_bayar==''){
                                                    $.Notification.notify('error','top right', 'Gagal', 'Jumlah bayar lebih kecil dari total belanja');
                                                } else {
                                                    prosesPenjualan();
                                                }
                                            } else {
                                                prosesPenjualan();
                                            }
                                          }
                });
            }

            function prosesPenjualan(){
                var type_bayar = $('#typeBayar').val();
                var keterangan = $('#keterangan').val();
                var jumlah_bayar = $('#jumlah_bayar').val();
                var subAccount = $('#subAccountHidden').val();
                var jatuh_tempo = $('#jatuhTempo').val();

                //opsi pengiriman
                var namaPenerima = $('#namaPenerima').val();
                var noHPPenerima = $('#kontakPenerima').val();
                var ekspedisi = $('#ekspedisi').val();
                var alamatPenerima = $('#alamatPenerima').val();
                var provinsi = $('#provinsiPenerima').val();
                var kabupaten = $('#kabupatenPenerima').val();
                var kecamatan = $('#kecamatanPenerima').val();                

                var urlPenjualan = "<?php echo base_url('penjualan/penjualan_sql'); ?>";
                
                $.ajax({
                            method: "POST",
                            url: urlPenjualan,
                            data: {type_bayar : type_bayar, keterangan : keterangan, jumlah_bayar : jumlah_bayar, sub_account : subAccount, jatuh_tempo : jatuh_tempo, namaPenerima : namaPenerima, noHPPenerima : noHPPenerima, ekspedisi : ekspedisi, alamatPenerima : alamatPenerima, provinsi : provinsi, kabupaten : kabupaten, kecamatan : kecamatan},
                            beforeSend : function(){
                                               $('#CssLoader').show(); 
                                          },
                            success : function(noInv){
                                            var urlRedirect = "<?php echo base_url('penjualan/invoice_penjualan?no_invoice='); ?>"+noInv;
                                            window.location.replace(urlRedirect);
                                          }
                });
            }


            function isEmail(email) {
              var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
              return regex.test(email);
            }

            $('#buttonPengiriman').on("click",function(){
                var urlHapusPengiriman = "<?php echo base_url('penjualan/hapusPengiriman'); ?>";

                $.ajax({
                            method : "POST",
                            url : urlHapusPengiriman,
                            success : function(){
                                        $('#buttonPengiriman').empty();

                                        $('#pengirimanUrl').css({
                                            'color' : '#000'
                                        });

                                        var urlAlamatContent = "<?php echo base_url('penjualan/emptyAlamatCust'); ?>";

                                        $('#alamatContent').load(urlAlamatContent,function(){
                                            $('select.select2').select2({
                                                width: '100%'
                                            });
                                        });

                                        tampilkanDaftarHarga();
                                      }
                });
            });

            $('#noMember').change(function(){
                var noMember = $('#noMember').val();

                var url = "<?php echo base_url('penjualan/cekNoMemberIfDuplicate'); ?>";

                $.post(url,{noMember : noMember},function(data){
                    if(data==1){
                        $('#labelNoMember').text('**No Member Duplicate');
                        $('#noMember').val('');
                    } else {
                        $('#labelNoMember').empty();
                    }
                });
            });

            $('#email').change(function(){
                var email = $(this).val();

                var check = isEmail(email);

                if(check==false){
                    $('#labelEmail').text('**Email Not Valid');
                    $('#email').val('');
                } else {
                    $('#labelEmail').empty();
                }
            });

            $('#simpanMember').on("click",function(){
                var noMember         = $('#noMember').val();
                var namaCustomer     = $('#namaCustomer').val();
                var kontak           = $('#kontak').val();
                var email            = $('#email').val();
                var tanggalLahir     = $('#tanggalLahir').val();
                var kategoriCustomer = $('#kategoriCustomer').val();
                var diskonMember     = $('#diskon').val();
                var alamat           = $('#alamat').val();
                var provinsi         = $('#provinsi').val();
                var kabupaten        = $('#list-kabupaten').val();
                var kecamatan        = $('#list-kecamatan').val();

                var url = "<?php echo base_url('penjualan/simpanMember'); ?>";

                if(noMember=='' || namaCustomer=='' || kontak=='' || email==''){
                    if(noMember==''){
                        $('#labelNoMember').text('**No Member Required');
                    }

                    if(namaCustomer==''){
                        $('#labelNamaCust').text('**Nama Cust Required');
                    }

                    if(kontak==''){
                        $('#labelKontak').text('**Kontak Required');
                    }

                    if(email==''){
                        $('#labelEmail').text('**Email Required');
                    }
                } else {
                    $.ajax({
                                type        : "POST",
                                url         : url,
                                data        : {noMember : noMemmitber, namaCustomer : namaCustomer, kontak : kontak, email : email, tanggalLahir : tanggalLahir,kategoriCustomer : kategoriCustomer, diskonMember : diskonMember, alamat : alamat, provinsi : provinsi, kabupaten : kabupaten, kecamatan : kecamatan},
                                beforeSend  : function(){
                                                $('#simpanMember').text('Harap Tunggu');
                                              }
                    }).done(function(data){
                        if(data==1){
                            $.Notification.notify('success','top right', 'Tambah Customer', 'Customer Berhasil Ditambahkan');
                            $('#myModal1').modal('hide');

                        } else {
                            $.Notification.notify('error','top right', 'Tambah Customer', 'Customer Gagal Ditambahkan');
                            $('#myModal1').modal('hide');
                        }
                    });
                }
            });

            $('#hidePengiriman').on("click",function(){
                var namaPenerima = $('#namaPenerima').val();
                var noHP = $('#kontakPenerima').val();
                var ekspedisi = $('#ekspedisi').val();
                var alamat = $('#alamatPenerima').val();
                var provinsi = $('#provinsiPenerima').val();
                var kabupaten = $('#kabupatenPenerima').val();
                var kecamatan = $('#kecamatanPenerima').val();
                var ongkir = $('#ongkir').val();

                if(namaPenerima=='' || noHP=='' || ekspedisi=='' || alamat=='' || provinsi=='' || kabupaten=='' || kecamatan==''){
                    $.Notification.notify('error','top right', 'Gagal Menyimpan Data', 'Harap Lengkapi Semua Form'); 
                } else {
                    var urlSimpanPengiriman = "<?php echo base_url('penjualan/simpanDataPengiriman'); ?>";

                    $.ajax({
                                method : "POST",
                                url : urlSimpanPengiriman,
                                data : {namaPenerima : namaPenerima, noHP : noHP, ekspedisi : ekspedisi,alamat : alamat,provinsi : provinsi, kabupaten : kabupaten, kecamatan : kecamatan, ongkir : ongkir},
                                success : function(){
                                                $('#opsiPengirimanModal').modal('hide');
                                                tampilkanDaftarHarga();
                                                $('#pengirimanUrl').css({
                                                    'color' : '#12a89d',
                                                    'font-weight' : 'bold'
                                                });

                                                $('#buttonPengiriman').html("<span class='badge bg-danger'><i class='fa fa-trash'></i></span>");
                                           }
                    });

                }   
            });

            $('#alamatCustomer').on("click",function(){
                var checkBox = $('#alamatCustomer').prop('checked');

                if($('#alamatCustomer').is(":checked")){
                    var idCustomer = $('#idCustomer').val();

                    //check sudah pilih customer belum
                    if(idCustomer==''){
                        $.Notification.notify('error','top right', 'Oooops', 'Anda belum memilih customer'); 
                        $('#alamatCustomer').prop('checked',false);
                    } else {
                        var urlCustomer = "<?php echo base_url('penjualan/viewAlamatCustomer'); ?>";

                        $('#alamatContent').load(urlCustomer,{idCustomer : idCustomer},function(){
                            $('select.select2').select2({
                                width: '100%'
                            });    
                        });
                    }
                } else {
                    var emptyAlamatCust = "<?php echo base_url('penjualan/emptyAlamatCust'); ?>";

                    $('#alamatContent').load(emptyAlamatCust,function(){
                        $('select.select2').select2({
                                width: '100%'
                        });
                    });
                }
            });

            $(document).on("click",".pilihCustomer",function(){
                var idCustomer = this.id;
                var urlPilihCustomer = "<?php echo base_url('penjualan/pilihCustomerPenjualan'); ?>";

                $.ajax({
                            method : "POST",
                            url : urlPilihCustomer,
                            data : {idCustomer : idCustomer},
                            success : function(response){
                                        $('#customerTerpilih').html(response);
                                        $('#modalPilihCustomer').modal('hide');
                                        $('#idCustomer').val(idCustomer);
                                        $('.deleteCustomerButton').html("<span class='badge bg-danger'><i class='fa fa-trash'></i></span>");
                                        ambilDiskonCustomer(idCustomer);
                                      },
                            error : function(){
                                        alert("Error");
                                    }
                });
            });

            $(document).on("change","#customer-form",function(){
                id_customer = $('#customer-form').val();
            });

            function ambilDiskonCustomer(idCustomer){
                $.ajax({
                            type    : 'POST',
                            url     : "<?php echo base_url('penjualan/get_diskon_customer'); ?>",
                            data    : {id : idCustomer},
                            success : function(diskon){
                                        displayDiskonMember(diskon,idCustomer);               
                                      }
                });
            }

            function displayDiskonMember(diskon,id_customer){
                var totalPurchaseUrl = "<?php echo base_url('penjualan/totalPurchase'); ?>";
                
                $.ajax({
                            type    : "POST",
                            url     : totalPurchaseUrl,
                            success : function(totalPurchase){  
                                        total = totalPurchase.split('.').join("");

                                        totalDiskon = (diskon/100)*total;

                                        //simpan di database
                                        var urlDiskon = "<?php echo base_url('penjualan/saveDiskonMember'); ?>";
                                        $.post(urlDiskon,{totalDiskon : totalDiskon, idCustomer : id_customer},function(){
                                            //
                                            tampilkanDaftarHarga();
                                        });

                                        //$('#diskon_text').text(formatAngka(totalDiskon));
                            }
                });
            }

            $('#submitPenjualan').on("click",function(){
                var urlDataPenjualan = "<?php echo base_url('penjualan/dataPenjualanCheckout'); ?>";

                $.ajax({
                            method : "POST",
                            url : urlDataPenjualan,
                            success : function(response){
                                        $('#checkoutContent').html(response);
                                      },
                            beforeSend : function(){
                                            $('#checkoutContent').text("Harap Tunggu...");
                                         }
                });
            });

            function fillJumlahBayar(){
                var urlGrandTotal = "<?php echo base_url('penjualan/viewGrandTotal'); ?>";
                
                $.ajax({
                    type        : "POST",
                    url         : urlGrandTotal,
                    success     : function(totalPurchase){
                                    var grandTotal = totalPurchase.split('.').join("");
                                    $('#kembalianCheckout').text('0');
                                    $('#jumlahBayarCheckout').text(formatAngka(grandTotal));
                                    $('#jumlah_bayar').val(grandTotal);
                    }
                });
            }

            function autoloadComponent(){
                $("#datatableCustomer").DataTable({
                    ordering: false,
                    processing: false,
                    serverSide: true,
                    ajax: {
                      url: "<?php echo base_url('penjualan/datatableCustomer'); ?>",
                      type:'POST'
                    }
                });

                var dataUrl = "<?php echo base_url('penjualan/viewCart'); ?>";
                $('#data-input').load(dataUrl);


                $(function() {  
                    $("#tableNiceScroll").niceScroll({cursorcolor:"#00F"});
                });

                $.ajax({
                            method : "GET",
                            url : "<?php echo base_url('penjualan/viewMenu'); ?>",
                            beforeSend : function(){
                                            $('#viewMenu').text("Harap Tunggu...");
                                         },
                            success : function(data){
                                        $('#viewMenu').html(data);
                                      }
                });
            }

            function customerTerpilihOrNot(){
                var urlCekCustomerOnCart = "<?php echo base_url('penjualan/cekCustomerOnCart'); ?>";

                $.ajax({
                            method : "POST",
                            url : urlCekCustomerOnCart,
                            success : function(response){
                                        if(response==1){
                                            viewCurrentCustomer();
                                        }
                                      }
                });
            }

            function viewCurrentCustomer(){
                var urlTampilkanCustomer = "<?php echo base_url('penjualan/customerTerpilih'); ?>";

                $.ajax({
                            method : "POST",
                            url : urlTampilkanCustomer,
                            dataType : "json",
                            success : function(response){
                                        $.each(response,function(x,obj){
                                            idCustomer = obj.idCustomer;
                                            nama = obj.nama;

                                            $('#customerTerpilih').html("<i class='fa fa-user'></i> "+obj.nama);
                                            $('#idCustomer').val(idCustomer);
                                            $('.deleteCustomerButton').html("<span class='badge bg-danger'><i class='fa fa-trash'></i></span>");
                                        });
                                      }
                });
            }

            function alamatPengirimanIsFill(){
                var urlAlamatPengirimanIsFill = "<?php echo base_url('penjualan/cekAlamatPengirimanIsFill'); ?>";

                $.ajax({
                            method : "POST",
                            url : urlAlamatPengirimanIsFill,
                            success : function(response){
                                        if(response > 0){
                                            tampilkanDataCustomer();
                                        } 
                                      }
                });
            }

            function tampilkanDataCustomer(){
                var urlCustomer = "<?php echo base_url('penjualan/currentCustomerOnCart'); ?>";

                $('#alamatContent').load(urlCustomer,function(){
                    $('select.select2').select2({
                        width: '100%'
                    });
                });

                $('#buttonPengiriman').html("<span class='badge bg-danger'><i class='fa fa-trash'></i></span>");

                $('#pengirimanUrl').css({
                    'color' : '#12a89d',
                    'font-weight' : 'bold'
                });
            }   
        </script>
    </body>
</html>
