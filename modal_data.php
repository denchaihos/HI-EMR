<div class="modal-content stopDisplay" id="editDx">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel"> DX OPD.</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-xs-12">
                    <div class="well">
                        <form id="dxPopup" name="dxPopup">
                            <h3><span id="editDx" class="label label-primary"></span></h3>
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
                            <button type="button" id="cancelEditDx" class="btn btn-warning btn-block" onclick="closeAlert();">ยกเลิก</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-content stopDisplay" id="editProc">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel"> ปรับปรุงข้อมูล.</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-xs-12">
                    <div class="well">
                        <form id="procPopup" name="procPopup">
                            <h3><span class="label label-primary">แก้ไขหัตถการ</span></h3>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">ICD9_ttm</span>
                                <input type="text" id="icd9ttm" class="form-control" placeholder="ICD9_TTM" onkeyup="set_icd9ttmname(this.value,)"  onKeyPress="return tabE(this,event)">
                            </div>
                            <div id="procSelect"></div>


                            <br>
                            <div class="input-group">
<!--                                <span class="input-group-addon" id="basic-addon1">ICD9TTMNAME</span>-->
                                <input type="hidden" id="icd9ttmname" class="form-control" placeholder=""  onKeyPress="return tabE(this,event)">
                            </div>
                            <div class="input-group">
<!--                                <span class="input-group-addon" id="basic-addon1">ICD9 PRICE</span>-->
                                <input type="hidden" id="icd9price" class="form-control" placeholder=""  onKeyPress="return tabE(this,event)">
                                <input type="hidden" id="codeicd9id" class="form-control" placeholder=""  onKeyPress="return tabE(this,event)">
                            </div>
                            <br>
                            <button type="button" id="saveEditProc" class="btn btn-success btn-block" >บันทึก</button>
                            <button type="button" id="cancelEditProc" class="btn btn-warning btn-block" onclick="closeAlert();">ยกเลิก</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-content stopDisplay" id="summary">
        <div class="modal-header">
            <!-- <button type="button" class="close" data-dismiss="modal"><span class="sr-only">Close</span></button> -->
            <h4 class="modal-title" id="myModalLabel"> เวชระเบียนผู้ป่วยนอก โรงพยาบาลทุ่งศรีอุดม จังหวัดอุบลราชธานี</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-xs-12">
                    <h4>ข้อมูลการรักษาประจำวันที่ <span id="dateVisit"></span> </h4>
                    <h4>ข้อมูลทั่วไป</h4>
                    <div class="well" id="inform_data">
                        inform_data
                    </div>
                    <h4>ข้อมูลซักประวัติ</h4>
                    <div class="col-xs-12 well" id="chief_complain">
                        chief_complain
                    </div>
                    <h4>การตรวจของแพทย์</h4>
                    <div class="col-xs-12 well" id="dx_pe_opd">
                        dx_pe_opd
                    </div>
                    <h4>ยาผู้ป่วยนอก</h4>
                    <div class="col-xs-12 well" id="modal_drug_opd">
                        drug
                    </div>
                    <div class="col-xs-6"><h4>LAB</h4></div>
                    <div class="col-xs-6"><h4>XRAY</h4></div>
                    <div class="col-xs-6 well" id="modal_lab_opd">
                        lab
                    </div>
                    <div class="col-xs-6 well" id="modal_xray_opd">
                        xray
                    </div> 
                    <br>                   
                    
                    <div class="col-xs-12 well" id="modal_cost_opd">
                        cost_opd
                    </div>

                </div>
            </div>
        </div>
        <button type="button" class="btn btn-default" onclick="printDiv(summary)">พิมพ์</button>
    </div>