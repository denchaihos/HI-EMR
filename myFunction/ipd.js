/**
 * Created by User on 8/9/2560.
 */
/***************IPD****************/
function getIpdData(){
    $('button#saveEditDx').attr('onClick',"updateDx('ipd')");
    var vn = vn_global_var;
    $('div#ipd_data').empty();
    $.get('get_ipd_data.php',{vn:vn}, function(data) {
        $("#ipd_data").html(data);
    });

}
function getDrugIpd(){

    $('div#ipd_drugs').empty();
    $.get('get_drug_ipd_data.php',{an:an_global_var}, function(data) {
        $("div#ipd_drugs").html(data);
    });
}

function getLabIpd(){
    var vn = $('input#vn_currentt').val();
    //alert(vn);
    $('#lab_result').empty();
    $.getJSON('get_lab_ipd_data.php',{an:an_global_var}, function(data) {
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
                $('tbody#ipd_lab_result').append(
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
function getXrayIpd(){
   // alert(an_global_var);
    $('div#xray_ipd_result').empty();
    $.get('get_xray_ipd_data.php',{an:an_global_var}, function(data) {
        $("div#xray_ipd_result").html(data);
    });
}
function getDx_ProcIpd(){
    $('div#ipd_dx').empty();
    $.get('get_dx_proc_ipd_data.php',{an:an_global_var}, function(data) {
        $("div#ipd_dx").html(data);
    });
}


function popupEditDx(id){
     id_dx = id;

    $('input#icd10').val('');
    $('input#icd10name').val('');


    $('#editDx').removeClass('stopDisplay');
    $('#editDx').addClass('display');

    alertify.genericDialog0 || alertify.dialog('genericDialog0',function(){
        return {
            main:function(content){
                this.setContent(content);
            },
            setup:function(){
                return {
                    focus:{
                        element:function(){
                            return this.elements.body.querySelector(this.get('selector'));
                        },
                        select:true
                    },
                    options:{
                        basic:true,
                        maximizable: true,
                        closableByDimmer: true,
                        resizable:false,
                        transition: 'fade',
                        autoReset: false,
                        padding:false

                    },
                    glossary:{
                        title:'คำเตือน',
                        ok: 'OK',
                        cancel: 'Cancel'
                    },
                    theme:{
                        input:'ajs-input',
                        ok:'ajs-ok',
                        cancel:'ajs-cancel'
                    }
                };
            },
            prepare: function() {
                this.setContent(this.message);
                this.elements.footer.style.visibility = "hidden";
            },
            hooks: {
                onshow: function() {
                    this.elements.dialog.style.maxWidth = 'none';
                    this.elements.dialog.style.width = '40%';
                }
            },

            settings:{
                selector:undefined
            }
        };
    });
    //force focusing password box
    alertify.genericDialog0 ($('#editDx')[0]).set('selector', 'input[type="text"]');

}
function set_icd10name(val){


    var icd10 = val.toUpperCase();
    $('#icd10').val(icd10);
    var len_icd10 = icd10.length;
    //alert(len_icd10);

   /* if(len_icd10==0){
        //alert(len_icd10);
        var add_form = document.getElementById('add_dx');
        if (add_form != null) {
            document.getElementById('submit_save').disabled = false;
        }else{
            document.getElementById('submit_save').disabled = true;
        }
    }else{
        document.getElementById('submit_save').disabled = false;
    }*/
    if(len_icd10>0){
        //alert(cln);
        $.getJSON('get_icd10name.php',{icd10:icd10}, function(data) {
            $.each(data, function(key,value){
                $('#icd10name').val(value.icd10name);
            });
        });
    };
}

