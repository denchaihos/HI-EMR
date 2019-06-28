/**
 * Created by User on 8/9/2560.
 */
/***************IPD****************/
function getIpdData() {
    $('button#saveEditDx').attr('onClick', "updateDx('ipd')");
    $('button#saveEditProc').attr('onClick', "updateProc('ipd')");
    var vn = vn_global_var;
    clinic = 'ipd';
    $('div#ipd_data').empty();
    if (vn) {
        $.get('get_ipd_data.php', {vn: vn}, function (data) {
            $("#ipd_data").html(data);
        });
    }

}
function getDrugIpd() {

    $('div#ipd_drugs').empty();
    $.get('get_drug_ipd_data.php', {an: an_global_var}, function (data) {
        $("div#ipd_drugs").html(data);
    });
}

function getLabIpd() {
    var vn = vn_global_var;
    //alert(vn);
    $('#lab_result').empty();
    if (vn) {
        $.getJSON('get_lab_ipd_data.php', {an: an_global_var}, function (data) {
            var array_len = data.length;
            if (data != '') {
                for (var j = 0; j < array_len; j++) {

                    var num_result = data[j].length;

                    if (num_result > 2) {
                        var labName = data[j][0];
                        var labResult = data[j][2];
                        var normalValue = data[j][3];
                        var Unit = data[j][4];
                    } else {
                        var labName = "-------[ " + data[j][0] + " ]--------";
                        var labResult = '';
                        var normalValue = '';
                        var Unit = '';

                    }
                    //for (var k = 5; k < num_result; k++) {
                    $('tbody#ipd_lab_result').append(
                        "<tr>" +
                            "<td>" + labName + "</td>" +
                            "<td>" + labResult + "</td>" +
                            "<td>" + normalValue + "</td>" +
                            "<td>" + Unit + "</td>" +
                            "</tr>"

                    )
                    // }

                }
            }
        });
    }
}
function getXrayIpd() {
    // alert(an_global_var);
    var an = an_global_var;
    $('div#xray_ipd_result').empty();
    if (an) {
        $.get('get_xray_ipd_data.php', {an: an}, function (data) {
            $("div#xray_ipd_result").html(data);
        });
    }
}
function getDx_ProcIpd() {
    $('div#ipd_dx').empty();
    var an = an_global_var;
    if (an) {
        $.get('get_dx_proc_ipd_data.php', {an: an}, function (data) {
            $("div#ipd_dx").html(data);
        });
    }
}


