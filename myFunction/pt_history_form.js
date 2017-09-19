/**
 * Created by User on 14/7/2559.
 */
var vn_global_var = '';
var an_global_var = '';

$(document).ready(function(){
    $('#editDx').addClass('stopDisplay');
    //lert('me');

});
function age(dob, today) {
    var today = today || new Date(),
        result = {
            years: 0,
            months: 0,
            days: 0,
            toString: function() {
                return (this.years ? this.years + ' ปี ' : '')
                    + (this.months ? this.months + ' เดือน ' : '')
                    + (this.days ? this.days + ' วัน' : '');
            }
        };
    result.months =
        ((today.getFullYear() * 12) + (today.getMonth() + 1))
            - ((dob.getFullYear() * 12) + (dob.getMonth() + 1));
    if (0 > (result.days = today.getDate() - dob.getDate())) {
        var y = today.getFullYear(), m = today.getMonth();
        m = (--m < 0) ? 11 : m;
        result.days +=
            [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][m]
                + (((1 == m) && ((y % 4) == 0) && (((y % 100) > 0) || ((y % 400) == 0)))
                ? 1 : 0);
        --result.months;
    }
    result.years = (result.months - (result.months % 12)) / 12;
    result.months = (result.months % 12);
    return result;
}
function getVstdate(){
    var hn = $('input#hn').val();
    //alert(hn);
    $("tbody#visit_date").empty();
    $.getJSON('get_vstdate.php',{hn:hn}, function(data) {
        $.each(data, function(key,value){

            if(value.an != 0){
               // $('td#vstdate').addClass('ipt_vstdate');
                $("tbody#visit_date").append("<tr>" +
                    "<td id='vstdate' class='ipt_vstdate'>"+value.vstdttm+
                    "<input type='hidden' name='vn' id='vn' value="+ value.vn+">"+
                    "<input type='hidden' name='hn' id='hn' value="+hn+">"+
                    "<input type='hidden' name='an' id='an' value="+value.an+">"+
                    "</td>" +
                    "<td id='an' class='ipt_vstdate'>"+value.costcenter+
                    "</td>" +
                    "</tr>"
                );
            }else{
            $("tbody#visit_date").append("<tr>" +
                "<td id='vstdate'>"+value.vstdttm+
                "<input type='hidden' name='vn' id='vn' value="+ value.vn+">"+
                "<input type='hidden' name='hn' id='hn' value="+hn+">"+
                "<input type='hidden' name='an' id='an' value="+value.an+">"+
                "</td>" +
                "<td id='an'>"+value.costcenter+
                "</td>" +
                "</tr>"
            );
            }
        });
        $('td#vstdate:first').trigger('click');
    });

}


$('body').on('click', 'td#vstdate', function(){
    $('ul.nav.nav-tabs a:first').tab('show'); // Select first tab
    var vn = $(this).find('input#vn').val();
    $('#vn_currentt').val(vn) ;
    var hn =  $(this).find('input#hn').val();
    var an =  $(this).find('input#an').val();
    an_global_var = an;
    vn_global_var = vn;

    //getPtInform(hn);
    $('td#vstdate').removeClass('td_current');
    $(this).addClass('td_current');
    //cleare old data/////
    $('#age').text('') ;
    $('#bw').text('') ;
    $('#height').text('');
    $('#waist_cm').text('');
    $('#tt').text('') ;
    $('#bmi').text('');
    $('#pr').text('');
    $('#rr').text('') ;
    $('#sbp').text('');
    $('#cc_h').text('');

    var history_vstdate = this.innerText;

    $('span#dateshow').text(history_vstdate);
    if(an == 0){
        $('li#ipd_tab').hide();
    }else{
        $('li#ipd_tab').show();
    }

    //var hn = $('#hnn').val();
    $.getJSON('pt_history_data.php',{vn:vn}, function(data) {
        $.each(data, function(key,value){
            $('#age').text(age(new Date(value.brthdate),new Date(value.vstdttm))) ;
            $('#bw').text(value.bw+" ก.ก.") ;
            $('#height').text(value.height+" ซ.ม.");
            $('#waist_cm').text(value.waist_cm+" cc.");
            $('#tt').text(value.tt+" ก.ก.") ;
            $('#bmi').text(value.bmi+" ");
            $('#pr').text(value.pr+" ครั้ง/นาที");
            $('#rr').text(value.rr+" ครั้ง/นาที") ;
            $('#sbp').text(value.sbp+" / "+value.dbp+" มม.ปรอท");
            $('#cc_h').text(value.cc);

        });
    });
    $('input#vstdate_fromclick').val(history_vstdate);
    getLabTest();
    getAppointment();
    createBadges();

});
function getPtInform(){
    var hn = $('input#hn').val();
    $.get('get_pt_information.php',{hn:hn}, function(data) {
        $("#general_inform").html(data);
    });
}

function createBadges(){
    var vn = vn_global_var;
    $('span.badge').text('');
    $.getJSON('badges.php',{vn:vn}, function(data) {
        $.each(data, function(key,value){
            $('span#inform_badge').text(value.inform);
            $('span#doctor_badge').text(value.doctor);
            $('span#drug_badge').text(value.drug);
            $('span#emergency_badge').text(value.emergency);
            $('span#dental_badge').text(value.dental);
            $('span#ipd_badge').text(value.ipd);
            $('span#lab_badge').text(value.lab);
            $('span#xray_badge').text(value.xray);
            $('span#cost_badge').text(value.cost);

        });
    });
}
function getLab(){
    var vn = vn_global_var;
    //alert(vn);
    $('#lab_result').empty();
    $.getJSON('get_lab_data.php',{vn:vn}, function(data) {
        var array_len = data.length;
        if(data != ''){
            for (var j = 0; j < array_len; j++) {

                var num_result = data[j].length;

                if(num_result>2 ){
                    var labName = data[j][0];
                    var labResult = data[j][2];
                    var normalValue = data[j][3];
                    var Unit = data[j][4];
                }else{
                    var labName = "-------[ "+data[j][0]+" ]--------";
                    var labResult = '';
                    var normalValue = '';
                    var Unit = '';

                }
                //for (var k = 5; k < num_result; k++) {
                    $('tbody#lab_result').append(
                        "<tr>" +
                        "<td>"+labName+"</td>"+
                        "<td>"+labResult+"</td>" +
                        "<td>"+normalValue+"</td>"+
                        "<td>"+Unit+"</td>"+
                        "</tr>"

                    )
               // }

            }
        }
    });
}
function getDrugOpd(){
    var vn = vn_global_var;

    $('tbody#my_drugs tr').remove();
    $.getJSON('get_drug_opd_data.php',{vn:vn}, function(data) {
        $x = 1;
        $.each(data, function(key,value){
            $("tbody#my_drugs").append("<tr>" +
                "<td>"+$x+"</td>" +
                "<td>"+value.nameprscdt+"</td>" +
                "<td>"+value.qty+"</td>" +
                "<td>"+value.doseprn1+" "+value.doseprn2+"</td>" +
                "</tr>"
            );
            $x++;
        });
    });
}

function getXray(){
    var vn = vn_global_var;
    $('div#xray_result').empty();
    $.getJSON('get_xray_data.php',{vn:vn}, function(data) {
        $.each(data, function(key,value){
            $('div#xray_result').append(
                "<p>"+value.xryname+"</p>"
            )
        });
    });
}

function getCost(){
    var vn = vn_global_var;

    $('div#cost_result').empty();
    $.get('get_cost_data.php',{vn:vn}, function(data) {
        $("#cost_result").html(data);

    });
}
function getLabTest(){
    var vn = vn_global_var;
    $('div#lab_test').empty();
    $.get('get_lab_send.php',{vn:vn}, function(data) {
        $("#lab_test").html(data);

    });

}
function getAppointment(){
    var vn = $('input#vn_currentt').val();
    $('div#lab_test').empty();
    $.get('get_appointment_data.php',{vn:vn}, function(data) {
        $("#appointment_data").html(data);

    });

}
function printDiv(divName) {

    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}


//create alert  dialog  myAlert name global
alertify.myAlert || alertify.dialog('myAlert',function factory(){
    return {
        main:function(content){
            this.setContent(content);
        },
        setup:function(){
            return {
                options:{
                    modal:false,
                    basic:true,
                    maximizable:true,
                    resizable:false,
                    padding:false,
                    transition: 'fade',
                    autoReset: false

                }
            };
        }
    };
});
function setConfig(){
    $.ajax({
        url: 'edit_config.php'
    }).success(function(data){
        alertify.myAlert(data).set('resizable',true).resizeTo('50%','85%');
        $('td#vstdate:first').trigger('click');
    }).error(function(){
        alertify.error('Errro loading external file.');
    });
}

var id_dx = '';

function updateDx(ptType){

    if(ptType == 'opd'){
        var url = 'edit_dx_opd.php';
    }else{
        var url = 'edit_dx_ipd.php';
    }

    var icd10 = $('input#icd10').val();
    var icd10name = $('input#icd10name').val();
    if( icd10name.length == 0 || icd10name == "ICD10 is not valid" ){
        alertify.alert('คำแนะนำ', 'ICD10 ไม่ถูกต้อง', function(){ alertify.success('Ok'); });

    }else{
        $.ajax({
         url: url,
         type: "POST",
         data: {'id_dx': id_dx,'icd10':icd10,'icd10name':icd10name},
         dataType: "html",
         headers: {
         'Cache-Control': 'no-cache, no-store, must-revalidate',
         'Pragma': 'no-cache',
         'Expires': '0'
         },
         cache: false

         }).success(function(data){
         if(data.match('Success')){
         closeDialog();
         alertify.success(data);

         $('button#'+id_dx).html(icd10);
             if(ptType == 'opd'){
                 $('button#'+id_dx).parent().next().next('td').text(icd10name) ;
             }else{
                $('button#'+id_dx).parent().next('td').text(icd10name) ;
             }
         closeDialog();
         }

         }).error(function(){
         alertify.error('Errro loading external file.');
         });
    }
}
function test(){
    alert('me');
}
function getDxPeOpdData(){
    $('button#saveEditDx').attr('onClick',"updateDx('opd')");
    $('div#dx_opd').empty();
    $.get('get_dx_pe_opd_data.php',{vn:vn_global_var}, function(data) {
        $("#dx_opd").html(data);
    });

}
function closeDialog(){
    $('#editDx').removeClass('display');
    $('#editDx').addClass('stopDisplay');
    alertify.closeAll();
}