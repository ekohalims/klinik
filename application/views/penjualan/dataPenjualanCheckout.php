<div class="row">
    <div class="col-md-6">
        <legend>Total Bayar</legend>
       	<table width="100%" style="font-size: 13px;">
            <tr>
                <td width="60%">Subtotal</td>
                <td id="subtotalCheckout" style="text-align: right;"></td>
            </tr>

            <tr>
                <td>Diskon Peritem</td>
                <td id="diskonPeritemCheckout" style="text-align: right;"></td>
            </tr>

            <tr>
                <td>Diskon Member</td>
                <td id="diskonMemberCheckout" style="text-align: right;"></td>
            </tr>

            <tr>
                <td>Diskon</td>
                <td id="diskonManualCheckout" style="text-align: right;"></td>
            </tr>

            <tr>
                <td>Poin Reimburs</td>
                <td id="poinreimbursCheckout" style="text-align: right;"></td>
            </tr>

            <tr>
                <td>Ongkir</td>
                <td id="ongkirCC" style="text-align: right;"></td>
            </tr>

            <tr style="font-weight: bold;font-size: 15px;border-top: solid 1px #ccc;">
                <td>Grand Total</td>
                <td id="grandTotalCheckout" style="text-align: right;"></td>
            </tr>

            <tr style="font-weight: bold;font-size: 15px;border-top: solid 1px #ccc;">
                <td>Jumlah Bayar</td>
                <td id="jumlahBayarCheckout" style="text-align: right;"></td>
            </tr>

            <tr style="font-weight: bold;font-size: 15px;border-top: solid 1px #ccc;color: red;">
                <td>Kembali</td>
                <td id="kembalianCheckout" style="text-align: right;"></td>
            </tr>
        </table>
	</div>

    <div class="col-md-6"> 
        <legend>Jenis Pembayaran</legend>  
        <div id="jenisPembayaranCheckout">
        </div>   

        <div id="formInputJumlahBayar">
        </div>               
    </div>
</div>

<div class="row" style="margin-top: 10px;">
    <div class="col-md-6" id="customerCheckout">
        
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var idCustomer = $('#idCustomer').val();

        tampilkanDaftarHargaCheckout();
        tampilkanDataCustomerTerpilih(idCustomer);
        tampilkanJenisPembayaran();
    });

    function tampilkanDataCustomerTerpilih(idCustomer){
        var urlCustomerCheckout = "<?php echo base_url('penjualan/customerTerpilihCheckout'); ?>";
        $('#customerCheckout').load(urlCustomerCheckout,{idCustomer : idCustomer});
    }

    function tampilkanDaftarHargaCheckout(){
        $.ajax({
                    method : "POST",
                    url : "<?php echo base_url('penjualan/tampilkanDaftarHarga'); ?>",
                    data : {id : 1},
                    dataType : "json",
                    success : function(response){
                                $.each(response,function(x,obj){
                                    $('#ongkirCC').text(formatAngka(obj.ongkir));
                                    $('#grandTotalCheckout').text(formatAngka(obj.grandTotal));
                                    $('#subtotalCheckout').text(formatAngka(obj.subtotal));
                                    $('#diskonPeritemCheckout').text(formatAngka(obj.diskonPeritem));
                                    $('#diskonMemberCheckout').text(formatAngka(obj.diskonMember));
                                    $('#diskonManualCheckout').text(formatAngka(obj.diskonManual));
                                    $('#poinreimbursCheckout').text(formatAngka(obj.poinReimburs));
                                });
                             }
        });
    }

    function tampilkanJenisPembayaran(){
        var urlJenisPembayaran = "<?php echo base_url('penjualan/jenisPembayaranCheckout'); ?>";

        $('#jenisPembayaranCheckout').load(urlJenisPembayaran);
    }
</script>   