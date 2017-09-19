/**
 * Created by User on 8/9/2560.
 */
/******************dental*******************/
function getdentalData(){
    var vn = $('input#vn_currentt').val();

    $('div#dental_result').empty();
    $.get('get_dental_data.php',{vn:vn}, function(data) {
        $("#dental_result").html(data);
    });

}

