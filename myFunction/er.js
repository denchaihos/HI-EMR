/**
 * Created by User on 8/9/2560.
 */

/******************ER*******************/
function getErData() {
    var vn = vn_global_var;
//alert(vn);
    $('div#er_result').empty();
    if (vn) {
        $.get('get_emergency_data.php', {vn: vn}, function (data) {
            $("#er_result").html(data);
        });
    }

}
function getErProcedure() {
    var vn = vn_global_var;

    $('div#er_procedure').empty();
    if (vn) {
        $.get('get_proc_er_data.php', {vn: vn}, function (data) {
            $("#er_procedure").html(data);
        });
    }

}
