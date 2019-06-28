/**
 * Created by User on 8/9/2560.
 */

/******************ER*******************/
function getInform_Data() {
    
    var data =  $('div#general_inform').html();
    alert(data);


}
function getErProcedure_Data() {
    var vn = vn_global_var;

    $('div#er_procedure').empty();
    if (vn) {
        $.get('get_proc_er_data.php', {vn: vn}, function (data) {
            $("#er_procedure").html(data);
        });
    }

}
