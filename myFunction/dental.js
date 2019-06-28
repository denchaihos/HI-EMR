/**
 * Created by User on 8/9/2560.
 */
/******************dental*******************/
function getdentalData(){
    var clinic = 'dental';
    vn =  vn_global_var;
    $('button#saveEditProc').attr('onClick',"updateProc('dental')");
    $('button#saveEditDx').attr('onClick',"updateDx('dental')");
    $('div#dental_result').empty();
    $.get('get_dental_data.php',{vn:vn}, function(data) {
        $("#dental_result").html(data);
    });

}
