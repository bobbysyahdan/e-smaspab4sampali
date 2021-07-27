// $(document).on("change",".load_ajax_change",function(e){

//     // alert("AAaa");
//     var target= $(this).data('ajaxtarget');
//     var data= $(this).data('ajaxdata');
//     // var data_unit = $(this).data('ajaxunit');
//     var load= $(this).data('ajaxload');
    var format= $(this).data('format');
//     var data_arr = data.split('|');
  
//     var keys = '';
//     for (i = 0; i < data_arr.length; i++) {
//       var key = $(data_arr[i]).val();
//       keys += key+'|';
//     }
  
//     // alert("as");
  
//     $(target).html("mengambil data ...");
    // $.ajax({
    //   type: "POST",
    //   url:load,
    //   data:{keys:keys},
    //   success: function(isi){
    //     // alert(isi);
    //     if (format == 'val') {
    //       $(target).val(isi);
    //     }
    //     else{
    //       $(target).html(isi);
    //     }
    //   },
    //   error: function(){
    //     console.log("Ambil data gagal");
    //     $(target).html("");
    //   }
    // });
  
//   });

var provinsi = $("#id_provinsi").val();
var kota = $("#id_kota").val();
  

$(document).on("change", "#id_provinsi", function(e){
    $("#cek_kurir").addClass("hidden");
    $("#trigger_shipping_price").addClass("hidden");
    $.ajax({
        type: "POST",
        url:"/purchase/getCities",
        data : {
            "id_provinsi": $("#id_provinsi").val(),
        },
        success: function(result){
          if (format == 'val') {
            $('#id_kota').val(result);
          }
          else{
            $('#id_kota').html(result);
          }
        },
        error: function(){
          console.log("Ambil data gagal");
          $('#id_kota').html("");
        }
      });
});

$(document).on("click", "#cek_ongkir", function(e){
    
    $.ajax({
        type: "POST",
        url:"/purchase/getCheckOngkir",
        data : {
            "id_provinsi": $("#id_provinsi").val(),
            "id_kota": $("#id_kota").val(),
            "total_weight": $("#total_weight").val(),
        },
        success: function(result){
            console.log(result);
            $("#cek_kurir").removeClass("hidden");
            $("#trigger_shipping_price").removeClass("hidden");
            $('#cek_kurir').html(result);
        //   if (format == 'val') {
        //     $('#cek_kurir').val(result);
        //   }
        //   else{
        //     $('#cek_kurir').html(result);
        //   }
        },
        error: function(){
          console.log("Ambil data gagal");
          $('#cek_kurir').html("");
        }
      });
});

function rubah(angka){
    var reverse = angka.toString().split("").reverse().join("");
    ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join(".").split("").reverse().join("");
    return ribuan;
}

$(document).on("change", 'input:radio[name="result_courier"]', function(e){
    var total_price = parseInt($('input[name="result_courier"]:checked').val().split('/')[3]) + parseInt($('#total_price').val());
    $("#total_shipping_price").text("Rp" + rubah($('input[name="result_courier"]:checked').val().split('/')[3]));
    $("#shipping_price").val(parseInt($('input[name="result_courier"]:checked').val().split('/')[3]));
    $("#courier").val($('input[name="result_courier"]:checked').val().split('/')[0]);
    $("#etd").val($('input[name="result_courier"]:checked').val().split('/')[2]);
    $("#courier_service").val($('input[name="result_courier"]:checked').val().split('/')[1]);

    $("#td_total_price").text("Rp" + rubah(total_price));
    $("#total_price_all").val(total_price);

});



