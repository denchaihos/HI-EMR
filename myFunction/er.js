/**
 * Created by User on 8/9/2560.
 */

/******************ER*******************/
function getErData(){
    var vn = $('input#vn_currentt').val();
//alert(vn);
    $('div#er_result').empty();
    $.get('get_emergency_data.php',{vn:vn}, function(data) {
        $("#er_result").html(data);
    });

}
function getErProcedure(){
    var vn = $('input#vn_currentt').val();

    $('div#er_procedure').empty();
    $.get('get_procedure_data.php',{vn:vn}, function(data) {
        $("#er_procedure").html(data);
    });

}
