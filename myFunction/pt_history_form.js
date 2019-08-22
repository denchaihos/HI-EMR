/**
 * Created by User on 14/7/2559.
 */
var vn_global_var = '';
var an_global_var = '';
var clinic = '';
var id_dx = '';
var dx_opd_pe_data ='';
var history_vstdate_global = '';

$(document).ready(function () {
    
    $('#editDx').addClass('stopDisplay');
    $('#editProc').addClass('stopDisplay');
    //lert('me');
    $("input#hn").keypress(function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) { //Enter keycode
            code = 9;
            return false;
        }
    });
    
    var vn_fromEditDiag = $('input#vn_fromEditDiag').val();
    var hn_fromEditDiag = $('input#hn_fromEditDiag').val();
    
    var hn = $('input#hn').val();
    //alert('hn='+hn);
  
    if( hn === undefined ){
        alert('Plaese Login');
    }else if(hn == '' || hn === null){
        console.log('login suuscces')
    }else{
        //alert(hn);
        getVstdate();
    }
   

});

$(document).keyup(function (e) {
    if ($("input#hn").is(":focus") && (e.keyCode == 13)) {
        getVstdate();
    }
});
function DateThai(strtDate) {
    var strDate =  new Date(strtDate);
    var strDay = strDate.getDate();
    var strYear = strDate.getFullYear()+543;     
    var strMonth = strDate.getMonth()+1;
    var strMonthCut = Array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    var strMonthThai = strMonthCut[strMonth];
    // var strTime = dateFormat(strDate, "h:MM:ss TT");
    var strTime = strDate.format("hh:MM:ss");
    //alert(strTime);
    return strDay +" "+strMonthThai +" "+strYear+" "+strTime;
}

function age(dob, today) {
    var today = today || new Date(),
        result = {
            years: 0,
            months: 0,
            days: 0,
            toString: function () {
                return (this.years ? this.years + ' ปี ' : '') +
                    (this.months ? this.months + ' เดือน ' : '') +
                    (this.days ? this.days + ' วัน' : '');
            }
        };
    result.months =
        ((today.getFullYear() * 12) + (today.getMonth() + 1)) -
        ((dob.getFullYear() * 12) + (dob.getMonth() + 1));
    if (0 > (result.days = today.getDate() - dob.getDate())) {
        var y = today.getFullYear(),
            m = today.getMonth();
        m = (--m < 0) ? 11 : m;
        result.days += [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][m] +
            (((1 == m) && ((y % 4) == 0) && (((y % 100) > 0) || ((y % 400) == 0))) ?
                1 : 0);
        --result.months;
    }
    result.years = (result.months - (result.months % 12)) / 12;
    result.months = (result.months % 12);
    return result;
}

function re() {
    location.reload();
}

function getVstdate() {

    vn_global_var = '';
    var hn = $('input#hn').val();
    //alert(hn);
    clearBadges();
    $("tbody#visit_date").empty();
    $("div#screening_data").empty();
    $("div#dx_opd").empty();
    $('#lab_result').empty();
    $('div#xray_result').empty();

    $('div#lab_test').empty();
    $('div#appointment_data').empty();
    $('div#dx_opd').empty();
    $('tbody#my_drugs').empty();
    $('div#er').empty();
    $('div#ipd_data').empty();
    $('div#ipd_drugs').empty();
    $('div#xray_ipd_result').empty();
    $('div#ipd_dx').empty();
    $('div#ipd_lab_result').empty();
    $('div#cost_result').empty();
    $.getJSON('get_vstdate.php', {
        hn: hn
    }, function (data) {
        if (data) {
            $.each(data, function (key, value) {
                if (value.an != 0) {
                    // $('td#vstdate').addClass('ipt_vstdate');
                    $("tbody#visit_date").append("<tr style='cursor: pointer;'>" +
                        "<td style='cursor: pointer;' id='vstdate'  class='ipt_vstdate'>" + value.vstdttm +
                        "<input type='hidden' name='vn' id='vn' value=" + value.vn + ">" +
                        "<input type='hidden' name='hn' id='hn' value=" + hn + ">" +
                        "<input type='hidden' name='an' id='an' value=" + value.an + ">" +
                        "</td>" +
                        "<td id='an'  class='ipt_vstdate'>" + value.costcenter +
                        "</td>" +
                        "</tr>"
                    );
                } else {
                    $("tbody#visit_date").append("<tr style='cursor: pointer;'>" +
                        "<td style='cursor: pointer;' id='vstdate' >" + value.vstdttm +
                        "<input type='hidden' name='vn' id='vn' value=" + value.vn + ">" +
                        "<input type='hidden' name='hn' id='hn' value=" + hn + ">" +
                        "<input type='hidden' name='an' id='an' value=" + value.an + ">" +
                        "</td>" +
                        "<td id='an' >" + value.costcenter +
                        "</td>" +
                        "</tr>"
                    );
                }
            });
            $('td#vstdate:first').trigger('click');
        } else {
            alert('No visit');
        }
    });

}


$('body').on('click', 'td#vstdate', function () {
    clearBadges();
    $('ul.nav.nav-tabs a:first').tab('show'); // Select first tab
    var vn = $(this).find('input#vn').val();
    // $('#vn_currentt').val(vn) ;
    var hn = $(this).find('input#hn').val();
    var an = $(this).find('input#an').val();
    an_global_var = an;
    vn_global_var = vn;

    //getPtInform(hn);
    $('td#vstdate').removeClass('td_current');
    $(this).addClass('td_current');

    var history_vstdate = this.innerText;
    history_vstdate_global = history_vstdate;


    //add  color with text  divide by opd  and ipd
    $('span#dateshow').text(DateThai(history_vstdate));
    if (an == 0) {
        $('li#ipd_tab').hide();
    } else {
        $('li#ipd_tab').show();
    }
    $("div#screening_data").empty();
    //var hn = $('#hnn').val();
    $.get('get_screening_data.php', {
        vn: vn
    }, function (data) {
        //alert(data);
        $("div#screening_data").html(data);
    });
    $('input#vstdate_fromclick').val(history_vstdate);
    getLabTest();
    getAppointment();
    createBadges();


});

function getPtInform() {
    var hn = $('input#hn').val();
    $.get('get_pt_information.php', {
        hn: hn
    }, function (data) {
        if (data) {
            $("#general_inform").html(data);
        } else {
            alert('No PT');
        }
    });
}

function clearBadges() {
    $('span.badge').text('');
    $('span#inform_badge').text('');
    $('span#doctor_badge').text('');
    $('span#drug_badge').text('');
    $('span#emergency_badge').text('');
    $('span#dental_badge').text('');
    $('span#ipd_badge').text('');
    $('span#lab_badge').text('');
    $('span#xray_badge').text('');
    $('span#cost_badge').text('');
}

function createBadges() {
    var vn = vn_global_var;
    if (vn) {
        $.getJSON('badges.php', {
            vn: vn
        }, function (data) {
            $.each(data, function (key, value) {
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
}

function getLab(_callback) {
    //alert('getlab');
    var vn = vn_global_var;
    //alert(vn);
    $('#lab_result').empty();
    if (vn) {
        $.getJSON('get_lab_data.php', {
            vn: vn
        }, function (data) {
            var array_len = data.length;
            //alert(array_len);
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
                    $('tbody#lab_result').append(
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
            _callback();
        });
    }
}

function getDrugOpd(_callback) {
    var vn = vn_global_var;

    $('tbody#my_drugs tr').remove();
    if (vn) {
        $.getJSON('get_drug_opd_data.php', {
            vn: vn
        }, function (data) {
            $x = 1;
            $.each(data, function (key, value) {
                $("tbody#my_drugs").append("<tr>" +
                    "<td>" + $x + "</td>" +
                    "<td>" + value.nameprscdt + "</td>" +
                    "<td>" + value.qty + "</td>" +
                    "<td>" + value.price + "</td>" +
                    "<td>" + value.charge + "</td>" +
                    "<td>" + value.doseprn1 + " " + value.doseprn2 + "</td>" +
                    "</tr>"
                );
                $x++;
            });
            _callback();           
        });
    }
}

function getXray(_callback) {
    var vn = vn_global_var;
    $('div#xray_result').empty();
    if (vn) {
        $.getJSON('get_xray_data.php', {
            vn: vn
        }, function (data) {
            $.each(data, function (key, value) {
                $('div#xray_result').append(
                    "<p>" + value.xryname + "</p>"
                )
            });
            _callback();
        });
    }
}

function getCost(_callback) {
    var vn = vn_global_var;
    if (vn) {
        $('div#cost_result').empty();
        $.get('get_cost_data.php', {
            vn: vn
        }, function (data) {
            $("#cost_result").html(data);
            _callback();

        });
    }
}

function getLabTest() {
    var vn = vn_global_var;
    $('div#lab_test').empty();
    if (vn) {
        $.get('get_lab_send.php', {
            vn: vn
        }, function (data) {
            $("#lab_test").html(data);


        });
    }

}

function getAppointment() {
    var vn = vn_global_var;
    $('div#appointment_data').empty();
    if (vn) {
        $.get('get_appointment_data.php', {
            'vn': vn
        }, function (data) {
            $("#appointment_data").html(data);
        });
    }

}


function printDiv(divName) {  
  

     var printContents = $('div#summary').html();
     //alert(printContents);
//     var win = window.open("", "Title", "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=200,top="+(screen.height-400)+",left="+(screen.width-840));

//     var s = document.createElement("script");
//     s.type = "text/javascript";
//     s.src = "js/jquery-1.11.3.js";
//    // win.$("head").append(s);
//    win.document.head.append(s);

//     var ss = document.createElement("script");
//     ss.type = "text/javascript";
//     ss.src = "js/bootstrap.min.js";
//     //win.$("head").append(ss);
//     win.document.head.append(ss);

//     win.document.head.append('<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />');

//     win.document.body.innerHTML = ""+printContents+"";

var win = window.open('','printwindow');
win.document.write('<html><head><title>โรงพยาบาลทุ่งศรีอุดม</title><link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"><link href="fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet"></head><body>');
win.document.write($("#content").innerHTML = printContents);

win.document.write('</body></html>');
//win.document.body.innerHTML = ""+printContents+"";

    win.print();
    
}

//create alert  dialog  myAlert name global
alertify.myAlert || alertify.dialog('myAlert', function factory() {
    return {
        main: function (content) {
            this.setContent(content);
        },
        setup: function () {
            return {
                options: {
                    modal: false,
                    basic: true,
                    maximizable: true,
                    resizable: false,
                    padding: false,
                    transition: 'fade',
                    autoReset: false

                }
            };
        }
    };
});

function setConfig() {
    $.ajax({
        url: 'edit_config.php'
    }).success(function (data) {
        alertify.myAlert(data).set('resizable', true).resizeTo('50%', '85%');
        $('td#vstdate:first').trigger('click');
    }).error(function () {
        alertify.error('Errro loading external file.');
    });
}



function updateDx(ptType) {
    var vn = vn_global_var;
    if (id_dx == 'addDx') {
        var url = 'add_dx_opd.php';
    } else {
        if (ptType == 'opd') {
            var url = 'edit_dx_opd.php';
        } else if (ptType == 'ipd') {
            var url = 'edit_dx_ipd.php';
        } else {
            var url = 'edit_dx_dental.php';
        }
    }
    var icd10 = $('input#icd10').val();
    var icd10name = $('input#icd10name').val();
    if (icd10name.length == 0 || icd10name == "ICD10 is not valid") {
        alertify.error('คำแนะนำ', 'ICD10 ไม่ถูกต้อง', function () {
            alertify.success('!Error');
        });
    } else {
        $.ajax({
            url: url,
            type: "POST",
            data: {
                'vn': vn,
                'id_dx': id_dx,
                'icd10': icd10,
                'icd10name': icd10name
            },
            dataType: "html",
            headers: {
                'Cache-Control': 'no-cache, no-store, must-revalidate',
                'Pragma': 'no-cache',
                'Expires': '0'
            },
            cache: false
        }).success(function (data) {
            //alert(url);
            if (data.match('Success')) {
                closeDialog();
                alertify.success(data);
                if (id_dx == 'addDx') {
                    getDxPeOpdData();
                } else {
                    $('button#' + id_dx).html(icd10);
                    if (ptType == 'opd') {
                        $('button#' + id_dx).parent().next().next('td').text(icd10name);
                    } else if (ptType == 'ipd') {
                        $('button#' + id_dx).parent().next('td').text(icd10name);
                    } else {
                        $('button#' + id_dx).parent().next('td').text(icd10name);
                    }
                }

                $('#editDx').removeClass('display');
                $('#editDx').addClass('stopDisplay');

                closeDialog();
            } else {
                alertify.error('Not Success');
            }
        }).error(function () {
            alertify.error('Errro .');
            alert(url);

        });
    }
}

function delDx(id) {
    //    alert(id);
    $.ajax({
        url: 'del_dx_opd.php',
        type: "POST",
        data: {
            'id_dx': id
        },
        dataType: "html",
        headers: {
            'Cache-Control': 'no-cache, no-store, must-revalidate',
            'Pragma': 'no-cache',
            'Expires': '0'
        },
        cache: false
    }).success(function (data) {

        if (data.match('Success')) {
            getDxPeOpdData();
            alertify.success(data);
        } else {
            alertify.error(data);
        }
    }).error(function () {
        alertify.error('Errro loading external file.');
    });
}

function delProcedure(id) {
    //alert(id);
    $.ajax({
        url: 'del_proc_opd.php',
        type: "POST",
        data: {
            'id_dx': id
        },
        dataType: "html",
        headers: {
            'Cache-Control': 'no-cache, no-store, must-revalidate',
            'Pragma': 'no-cache',
            'Expires': '0'
        },
        cache: false,
        success: function (response) {
            console.log(response);
        }
    }).success(function (data) {

        if (data.match('Success')) {
            getDxPeOpdData();
            alertify.success(data);
        } else {
            alertify.error(data);
        }
    }).error(function () {
        alertify.error('Errro.');
    });
}

function updateProc(ptType) {
    console.log(id_dx);
    //var me = $('button#saveEditProc').attr('onclick');
    //alert(id_dx);
    if (id_dx == 'addProc') {
        var url = 'add_proc_opd.php';
    } else {
        if (ptType == 'opd') {
            var url = 'edit_proc_opd.php';
        } else if (ptType == 'ipd') {
            var url = 'edit_proc_ipd.php';
        } else {
            var url = 'edit_proc_dental.php';
        }
    }
    var vn = vn_global_var;
    var icd9ttm = $('input#icd9ttm').val();
    var icd9ttmname = $('input#icd9ttmname').val();
    var icd9price = $('input#icd9price').val();
    var codeicd9id = $('input#codeicd9id').val();
    if (icd9ttmname.length == 0 || icd9ttmname == "ICD is not valid") {
        alertify.alert('คำแนะนำ', 'ICD ไม่ถูกต้อง', function () {
            alertify.success('Ok');
        });
    } else {
        //alert(icd9price);
        //alert(vn);
        $.ajax({
            url: url,
            type: "POST",
            data: {
                'vn': vn,
                'id_dx': id_dx,
                'icd9ttm': icd9ttm,
                'icd9ttmname': icd9ttmname,
                'icd9price': icd9price,
                'codeicd9id': codeicd9id
            },
            dataType: "html",
            headers: {
                'Cache-Control': 'no-cache, no-store, must-revalidate',
                'Pragma': 'no-cache',
                'Expires': '0'
            },
            cache: false,
            success: function (response) {
                console.log(response);
            }

        }).success(function (data) {
            if (data.match('Success')) {
                closeDialog();
                alertify.success(data);
                getDxPeOpdData();
                if (ptType == 'opd') {
                    $('button#' + id_dx).html(icd9ttm);
                    $('button#' + id_dx).parent().next('td').text(icd9ttmname);
                } else if (ptType == 'ipd') {
                    $('button#' + id_dx).html(icd9ttm);
                    $('button#' + id_dx).parent().next('td').text(icd9ttmname);
                } else {

                    $('button#' + id_dx).parent().next().next().children('button').html(icd9ttm);
                    $('button#' + id_dx).parent().next().next().next('td').text(icd9ttmname);
                }
                $('#editProc').removeClass('display');
                $('#editProc').addClass('stopDisplay');

            }

        }).error(function () {
            alert(id_dx);
            alertify.error('Errro loading external file.');
        });
    }
}

function test() {
    alert('me');
}

function getDxPeOpdData(_callback) {
    var vn = vn_global_var;    
    clinic = 'opd';
    $('button#saveEditDx').attr('onClick', "updateDx('opd')");
    $('button#saveEditProc').attr('onClick', "updateProc('opd')");
    $('div#dx_opd').empty();
    if (vn) {
        $.get('get_dx_pe_opd_data.php', {
            'vn': vn_global_var
        }, function (data) {
            dx_opd_pe_data = data; 
            $("#dx_opd").html(data);      
            _callback();            
           
        });
    }
   

}

function closeDialog() {
    //$('#editDx').removeClass('display');
    //$('#editDx').addClass('stopDisplay');
    alertify.closeAll();
}

function dialogshow(id) {

    alertify.genericDialog1327195 || alertify.dialog('genericDialog1327195', function () {
        return {
            main: function (content) {
                this.setContent(content);
            },
            setup: function () {
                return {
                    focus: {
                        element: function () {
                            return this.elements.body.querySelector(this.get('selector'));
                        },
                        select: true
                    },
                    options: {
                        basic: true,
                        maximizable: true,
                        closableByDimmer: true,
                        resizable: false,
                        transition: 'fade',
                        autoReset: false,
                        padding: false

                    },
                    glossary: {
                        title: 'คำเตือน',
                        ok: 'OK',
                        cancel: 'Cancel'
                    },
                    theme: {
                        input: 'ajs-input',
                        ok: 'ajs-ok',
                        cancel: 'ajs-cancel'
                    }
                };
            },
            prepare: function () {
                this.setContent(this.message);
                this.elements.footer.style.visibility = "hidden";
            },
            hooks: {
                onshow: function () {
                    this.elements.dialog.style.maxWidth = 'none';
                    this.elements.dialog.style.width = '40%';
                },
                onclose: function () {
                    alertify.dialog.closeAll;

                }
            },


            settings: {
                selector: undefined
            }
        };
    });
}

function popupEditDx(id) {
    alertify.closeAll();
    id_dx = id;

    $('input#icd10').val('');
    $('input#icd10name').val('');
    $('#editDx').addClass('display');
    $('#editDx').removeClass('stopDisplay');
    $('#editProc').removeClass('display');
    $('#editProc').addClass('stopDisplay');
    if (id == 'addDx') {
        $('span#editDx').text('เพิ่มวินิจฉัย');
    } else {
        $('span#editDx').text('แก้ไขวินิจฉัย');
    }
    alertify.genericDialog1327195 || alertify.dialog('genericDialog1327195', function () {
        return {
            main: function (content) {
                this.setContent(content);
            },
            setup: function () {
                return {
                    focus: {
                        element: function () {
                            return this.elements.body.querySelector(this.get('selector'));
                        },
                        select: true
                    },
                    options: {
                        basic: true,
                        maximizable: true,
                        closableByDimmer: true,
                        resizable: false,
                        transition: 'fade',
                        autoReset: false,
                        padding: false

                    },
                    glossary: {
                        title: 'คำเตือน',
                        ok: 'OK',
                        cancel: 'Cancel'
                    },
                    theme: {
                        input: 'ajs-input',
                        ok: 'ajs-ok',
                        cancel: 'ajs-cancel'
                    }
                };
            },
            prepare: function () {
                this.setContent(this.message);
                this.elements.footer.style.visibility = "hidden";
            },
            hooks: {
                onshow: function () {
                    this.elements.dialog.style.maxWidth = 'none';
                    this.elements.dialog.style.width = '40%';
                },
                onclose: function () {
                    alertify.dialog.closeAll;

                }
            },


            settings: {
                selector: undefined
            }
        };
    });

    //dialogshow(id);
    //force focusing password box
    alertify.genericDialog1327195($('div#editDx')[0]).set('selector', 'input[type="text"]');
}

function popupEditProc(id) {
    alertify.closeAll();
    id_dx = id;
    $('input#icd9ttm').val('');
    $('input#icd9ttmname').val('');
    //$('#editDx').removeClass('display');
    // $('#editDx').addClass('stopDisplay');
    $('#editProc').removeClass('stopDisplay');
    $('#editProc').addClass('display');
    //dialogshow();
    alertify.genericDialog0 || alertify.dialog('genericDialog0', function () {
        return {
            main: function (content) {
                this.setContent(content);
            },
            setup: function () {
                return {
                    focus: {
                        element: function () {
                            return this.elements.body.querySelector(this.get('selector'));
                        },
                        select: true
                    },
                    options: {
                        basic: true,
                        maximizable: true,
                        closableByDimmer: true,
                        resizable: false,
                        transition: 'fade',
                        autoReset: false,
                        padding: false

                    },
                    glossary: {
                        title: 'คำเตือน',
                        ok: 'OK',
                        cancel: 'Cancel'
                    },
                    theme: {
                        input: 'ajs-input',
                        ok: 'ajs-ok',
                        cancel: 'ajs-cancel'
                    }
                };
            },
            prepare: function () {
                this.setContent(this.message);
                this.elements.footer.style.visibility = "hidden";
            },
            hooks: {
                onshow: function () {
                    this.elements.dialog.style.maxWidth = 'none';
                    this.elements.dialog.style.width = '40%';
                },
                onclose: function () {
                    this.close;
                }
            },


            settings: {
                selector: undefined
            }
        };
    });
    //force focusing password box
    alertify.genericDialog0($('div#editProc')[0]).set('selector', 'input[type="text"]');

}


function popupSummaryData(evt) {
    alertify.closeAll();
    var evt = evt;
   
     var dateVisit = $('span#dateshow').html();    
    $('span#dateVisit').text(dateVisit);
   
    var datainform =  $('div#general_inform').html();
    $('div#inform_data').html(datainform);
    var dataScreen = $('div#screening_data').html();
    $('div#chief_complain').html(dataScreen);
   //use callback funntion to await this funciton complete theb next step
   getDxPeOpdData(function() {    
        $('div#dx_pe_opd').html(dx_opd_pe_data);
    }); 
    
    getDrugOpd(function(){
        var dataDrug = $('div#drug_used').html();
        $('div#modal_drug_opd').html(dataDrug);
    });

    getLab(function(){
        var dataLab = $('div#my_opd_lab').html();
        $('div#modal_lab_opd').html(dataLab);
    });

   
    getXray(function(){
        var dataXray = $('div#xray_result').html();
        $('div#modal_xray_opd').html(dataXray);
    });

    getCost(function(){
        var dataCost = $('div#cost_result').html();
        $('div#modal_cost_opd').html(dataCost);
    });
     
    if(evt=='show'){    
        $('#summary').removeClass('stopDisplay');
        $('#summary').addClass('display');
    }
    
    //dialogshow();
    alertify.genericDialog0 || alertify.dialog('genericDialog0', function () {
            return {
                main: function (content) {
                    this.setContent(content);
                },
                setup: function () {
                    return {
                        focus: {
                            element: function () {
                                return this.elements.body.querySelector(this.get('selector'));
                            },
                            select: true
                        },
                        options: {
                            basic: true,
                            maximizable: true,
                            closableByDimmer: true,
                            resizable: false,
                            transition: 'fade',
                            autoReset: false,
                            padding: false

                        },
                        glossary: {
                            title: 'คำเตือน',
                            ok: 'OK',
                            cancel: 'Cancel'
                        },
                        theme: {
                            input: 'ajs-input',
                            ok: 'ajs-ok',
                            cancel: 'ajs-cancel'
                        }
                    };
                },
                prepare: function () {
                    this.setContent(this.message);
                    this.elements.footer.style.visibility = "hidden";
                },
                hooks: {
                    onshow: function () {
                        this.elements.dialog.style.maxWidth = 'none';
                        this.elements.dialog.style.width = '80%';
                    },
                    onclose: function () {
                        this.close;
                    }
                },


                settings: {
                    selector: undefined
                }
            };
        }
       
    );
    //force focusing password box

    alertify.genericDialog0($('div#summary')[0]).set('selector', 'input[type="text"]');
    _callback();

}

function set_icd10name(val) {
    var icd10 = val.toUpperCase();
    $('#icd10').val(icd10);
    var len_icd10 = icd10.length;
    if (len_icd10 > 0) {
        //alert(cln);
        $.getJSON('get_icd10name.php', {
            icd10: icd10
        }, function (data) {
            $.each(data, function (key, value) {
                $('#icd10name').val(value.icd10name);
            });
        });
    };
}

function set_icd9ttmname(val) {
    var icd9ttm = val.toUpperCase();
    $('#icd9ttm').val(icd9ttm);
    var len_icd9ttm = icd9ttm.length;
    $("div#procSelect").empty();
    if (len_icd9ttm > 2) {
        //alert(cln);
        $.getJSON('get_icd9ttmname.php', {
            'icd9ttm': icd9ttm,
            'clinic': clinic
        }, function (data) {
            $.each(data, function (key, value) {


                //                $('#icd9ttmname').val(value.nameicd9);
                //                $('input#icd9price').val(value.price);
                $("div#procSelect").append("<div class='radio' >" +
                    "<label>" +
                    "<input type='radio' class='gender' onchange='setProc(this);' name='optionsRadios' id='optionsRadios1' " +
                    "data-icd9='" + value.nameicd9 + "' data-codeicd9id='" + value.codeicd9id + "'   " +
                    "value='" + value.price + "'>" +
                    value.nameicd9 + " ราคา " + value.price +
                    "</label>" +
                    "</div>");
            });
        });
    };
    //    $('input[name=radioName]:checked').val();


}

function setProc(valRadio) {
    console.log('me');
    //alert(valRadio.getAttribute('data-icd9'));
    $('input#icd9ttmname').val(valRadio.getAttribute('data-icd9'));
    $('input#codeicd9id').val(valRadio.getAttribute('data-codeicd9id'));
    $('input#icd9price').val(valRadio.value);

}
function printPrb(){
    var hn = $("input#hn").val();
    var visit_date = history_vstdate_global.substring(0,19);
    //alert(visit_date);

    window.open('printDoc/viewprb.php?adate='+visit_date+'&hn='+hn) ;
}