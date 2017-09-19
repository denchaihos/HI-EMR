<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 21/10/2557
 * Time: 10:33 น.
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>EMR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <link href="css/myCss/pt_history_form.css" rel="stylesheet">
    <link href="css/myCss/emergency.css" rel="stylesheet">
</head>
<body>

    <?
    date_default_timezone_set('Asia/Bangkok');
    include "myFunction/myFunction.php";

    $today = time();
    //$hn = $_GET['hn'];
    $hn = 1;
    //$vn = $hn[1];
    ?>
    <div class="modal-content stopDisplay" id="editDx">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel"> ปรับปรุงข้อมูล.</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-xs-12">
                    <div class="well">
                        <form id="addPt" name="addPt">
                            <h3><span class="label label-primary">แก้ไขวินิจฉัย</span></h3>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">ICD10</span>
                                <input type="text" id="icd10" class="form-control" placeholder="ICD10" onkeyup="set_icd10name(this.value)"  onKeyPress="return tabE(this,event)">
                            </div>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">ICD10NAME</span>
                                <input type="text" id="icd10name" class="form-control" placeholder=""  onKeyPress="return tabE(this,event)">
                            </div>
                            <br>
                            <button type="button" id="saveEditDx" class="btn btn-success btn-block" >บันทึก</button>
                            <button type="button" id="register" class="btn btn-warning btn-block" onclick="closeAlert();">ยกเลิก</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12" id="main_div">
        <div class="panel panel-primary" >
            <div class="panel-heading"  style="margin-buttom:2px;">
                <form class="form-inline">
                    <div class="form-group">
                        <label for="hnn">Patient EMR::</label>
                        <label for="hn">HN::</label>
                        <input type="text" name="hn" class="form-control" id="hn" >

                    </div>

                    <button type="button" class="btn btn-default" onclick="getVstdate();getPtInform();">ตกลง</button>


                        <span style="display: none"> วันที่  <input type="hidden" name="vstdate_fromclick" id="vstdate_fromclick" value=""/></span>
                        <span style="display: none" id="dateshow"></span>
                    <input type="button" style="display: none" onclick="printDiv('printableArea')" value="print Send TestLab!" />

                </form>

                <input type="hidden" name="hn" id="hnn" value="<? echo $hn ?>"/>


            </div>
            <div class="panel-body">
                <div class="col-lg-12" id="main_content">

                    <div class="col-lg-2" style="width: 200px">

                        <h4>วันที่มารับบริการ</h4>
                        <div id="vstdate_h" class="vstdate_h" >

                            <table id="table_h" class="table  table-hover">
                                <tbody id="visit_date">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-10 " id="printableArea detailPt">
                        <div id="content_history" class="content_history panel panel-danger">

                            <div class="panel-body" id="panel">
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">ประวัติทั่วไป &nbsp;&nbsp;&nbsp;  วันที่รับบริการ:<span id="dateshow"></span></h3>

                                    </div>
                                    <div class="panel-body" id="general_inform">

                                    </div>
                                </div>

                                <div class="panel panel-warning"  style="padding: 1px;">
                                    <div class="panel-heading" style="margin-buttom:2px;">
                                        <h3 class="panel-title">ประวัติการรักษา</h3>
                                    </div>
                                    <div class="panel-body" id="panel">
                                        <!--tabsssssssss-->
                                        <div class="col-log-12">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item active">
                                                    <a href="#home" role="tab" data-toggle="tab">
                                                        <icon class="fa fa-stethoscope"></icon>
                                                        ข้อมูลซักประวัติ
                                                        <span class="badge badge-success" id="inform_badge"></span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#doctor" role="tab" data-toggle="tab" onclick="getDxPeOpdData()">
                                                        <i class="fa fa-user-md"></i> การตรวจของแพทย์
                                                        <span class="badge" id="doctor_badge"></span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#drug" role="tab" data-toggle="tab" onclick="getDrugOpd()">
                                                        <i class="fa fa-medkit" aria-hidden="true"></i> ยาและอุปกรณ์ที่ใช้
                                                        <span class="badge" id="drug_badge"></span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#er" role="tab" data-toggle="tab" onclick="getErProcedure();getErData();">
                                                        <i class="fa fa-heartbeat"></i> การรักษาด้านฉุกเฉิน
                                                        <span class="badge" id="emergency_badge"></span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#dental" role="tab" data-toggle="tab" onclick="getdentalData()">
                                                        <i class="fa fa-paw"></i> ทันตกรรม
                                                        <span class="badge" id="dental_badge"></span>
                                                    </a>
                                                </li>
                                                <li id="ipd_tab">
                                                    <a href="#ipd"  role="tab" data-toggle="tab" onclick="getIpdData()">
                                                        <i class="fa fa-bed"></i> ผู้ป่วยใน
                                                        <span class="badge" id="ipd_badge"></span>
                                                    </a>
                                                </li>


                                                <li nav-item>
                                                    <a href="#lab" role="tab" data-toggle="tab" onclick="getLab()">
                                                        <i class="fa fa-flask"></i> ผลชัณสูตร
                                                        <span class="badge" id="lab_badge"></span>
                                                    </a>
                                                </li>
                                                <li nav-item>
                                                    <a href="#xray" role="tab" data-toggle="tab" onclick="getXray();">
                                                        <i class="fa fa-cog"></i> เอ็กซเรย์
                                                        <span class="badge" id="xray_badge"></span>
                                                    </a>
                                                </li>
                                                <li nav-item>
                                                    <a href="#cost" role="tab" data-toggle="tab" onclick="getCost();">
                                                        <i class="fa fa-money"></i> ค่าใช้จ่าย
                                                        <span class="badge" id="cost_badge"></span>
                                                    </a>
                                                </li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div class="tab-pane fade active in" id="home">
                                                    <!--<h6><b>ข้อมูลผู้ป่วย</b></h6>-->
                                                    <span class="label label-default" id="title">น้ำหนัก&nbsp</span>
                                                    <span id="bw" class="text_content"> </span>
                                                    <span class="label label-default" id="title">ส่วนสูง&nbsp</span>
                                                    <span id="height" class="text_content"> </span>
                                                    <span class="label label-default" id="title">รอบเอว&nbsp</span>
                                                    <span id="waist_cm" class="text_content"> </span>
                                                    <span class="label label-default" id="title">BMI&nbsp</span>
                                                    <span id="bmi" class="text_content"> </span>
                                                    <span class="label label-default" id="title">อุณหภูมิ&nbsp</span>
                                                    <span id="tt" class="text_content"> </span>
                                                    <span class="label label-default" id="title">pr&nbsp</span>
                                                    <span id="pr" class="text_content"> </span>
                                                    <span class="label label-default" id="title">rr&nbsp</span>
                                                    <span id="rr" class="text_content"> </span>
                                                    <span class="label label-default" id="title">BP&nbsp</span>
                                                    <span id="sbp" class="text_content"> </span>
                                                    <br/>
                                                    <span class="label label-default" id="title">CC&nbsp</span>
                                                    <span id="cc_h" class="text_content"> </span>
                                                    <div>
                                                        <span class="label label-default" id="title">PI&nbsp</span>
                                                        <span id="pi_h" class="text_content"> </span>
                                                    </div>
                                                    <div id="lab_test">

                                                    </div>
                                                    <div id="appointment_data">

                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="doctor">
                                                    <div class="panel-body" id="dx_opd">

                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="drug">
                                                    <div id="drug_used">
                                                        <div class="col-md-12 table-curved">
                                                            <table class="table  col-md-10 table-hover table-striped" id="mydrugs">
                                                                <?php
                                                                echo '<thead class="mythead">';
                                                                echo '<tr>';
                                                                echo '<th class="mythead">ลำดับ</th>';
                                                                echo '<th >ชื่อยา</th>';
                                                                echo '<th>จำนวน</th>';
                                                                echo '<th>วิธีกิน</th>';
                                                                echo '</tr>';
                                                                echo '</thead>';
                                                                ?>
                                                                <tbody id="my_drugs">

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="er">

                                                    <div id="er_procedure"></div>
                                                    <div id="er_result">

                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="dental">

                                                    <div id="dental_result">

                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="ipd">
                                                    <h5>การรักษาภายในโรงพยาบาล</h5>
                                                    <!--tabsssssssss-->
                                                    <div class="col-log-12" >
                                                        <!-- Nav tabs -->
                                                        <ul class="nav nav-tabs" role="tablist" >
                                                            <li class="active">
                                                                <a href="#ipd_home" role="tab" data-toggle="tab">
                                                                    <icon class="fa fa-stethoscope"></icon>
                                                                    ข้อมูลทั่วไป

                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#ipd_drug" role="tab" data-toggle="tab" onclick="getDrugIpd()">
                                                                    <i class="fa fa-medkit"></i> ยาและอุปกรณ์ที่ใช้
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#ipd_lab" role="tab" data-toggle="tab" onclick="getLabIpd()">
                                                                    <i class="fa fa-flask" aria-hidden="true"></i> Lab
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#ipd_xray" role="tab" data-toggle="tab" onclick="getXrayIpd()">
                                                                    <i class="fa fa-medkit" aria-hidden="true"></i> X-ray
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#ipd_dx" role="tab" data-toggle="tab" onclick="getDx_ProcIpd()">
                                                                    <i class="fa fa-medkit" aria-hidden="true"></i> วินิจฉัยและหัตถการ
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#ipd_dx" role="tab" data-toggle="tab" onclick="getDx_ProcIpd()">
                                                                    <i class="fa fa-medkit" aria-hidden="true"></i> ค่าใช้จ่ายผู้ป่วยใน
                                                                </a>
                                                            </li>

                                                        </ul>
                                                        <!-- Tab panes -->
                                                        <div class="tab-content" id="ipd_tabs">
                                                            <div class="tab-pane fade active in" id="ipd_home">

                                                                ข้อมูลทั่วไป
                                                                <div id="ipd_data">

                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade " id="ipd_drug">
                                                                <div id="ipd_drugs">

                                                                </div>

                                                            </div>
                                                            <div class="tab-pane fade " id="ipd_lab">
                                                                <table width="400px" class='table table-hover table-striped' id="my_lab">
                                                                    <thead>
                                                                    <tr>
                                                                        <th width="50%"><span class="text">Labname</span></th>
                                                                        <th width="10%"><span class="text">Result</span></th>
                                                                        <th width="20%"><span class="text">NormalValue</span></th>
                                                                        <th width="20%"><span class="text">Unit</span></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="ipd_lab_result">

                                                                    </tbody>

                                                                </table>
                                                            </div>
                                                            <div class="tab-pane fade " id="ipd_xray">
                                                                <div id="xray_ipd_result">

                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade " id="ipd_dx">

                                                            </div>
                                                        </div>


                                                    </div>

                                                </div>
                                                <div class="tab-pane fade" id="lab">
                                                    <h6>ผลตรวจทางห้องปฏิบัติการ</h6>
                                                    <div id="table-wrapper">
                                                        <div id="table-scroll">
                                                            <table class='table table-hover table-striped' id="my_lab">
                                                                <thead>
                                                                    <tr>
                                                                        <th><span class="text">Labname</span></th>
                                                                        <th><span class="text">Result</span></th>
                                                                        <th><span class="text">NormalValue</span></th>
                                                                        <th><span class="text">Unit</span></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="lab_result">

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="xray">
                                                    <h5>รายการเอ็กซเรย์</h5>
                                                    <div id="xray_result">

                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="cost">
                                                    <div id="cost_result">
                                                        cost

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="vn" id="vn_currentt" >



</body>
</html>