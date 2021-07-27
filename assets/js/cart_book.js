function rubah(angka){
    var reverse = angka.toString().split("").reverse().join("");
    ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join(".").split("").reverse().join("");
    return ribuan;
}

$(document).on("keyup", "#amount_book", function(){
var total = $("#trigger_price").val() * $(this).val();
$("#price").val(total);
// var t_total = "Rp" + rubah(total);
// $("#trigger_total_harga").val(t_total);
});