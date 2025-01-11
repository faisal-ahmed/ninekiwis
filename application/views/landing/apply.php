<style type="text/css">
    label{
        font-weight: normal !important;
    }
</style>
<div class="col-lg-8 landingRightPanel">
    <div class="panel panel-default">
        <div class="panel-heading custom_panel_heading" style="color: #fff;">
            Applicant's Detail
        </div>
        <form role="form" id="loanForm" method="post" action="<?php echo base_url() ?>index.php/user/newLoanApplication">
            <div class="panel-body" style="display: <?php echo isset($error) ? "block" : "none"; ?>">
                <div class="alert alert-danger alert-dismissable" style="margin-bottom: 0;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php if (isset($error)) echo $error; ?>
                </div>
            </div>
            <!-- .panel-heading -->
            <div class="panel-body">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title" style="color: #fff;">
                                Personal Information
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">

                                <div id="errorMsg" style="display: none;" class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" onclick="closeNotification('#errorMsg')" aria-hidden="true">×</button>
                                    Please correct the following errors:
                                </div>

                                <div class="form-group col-xs-10" id="fnameDiv">
                                    <label>First Name <span class="required">*</span></label>
                                    <input type="text" required class="form-control" id="fname" name="fname" placeholder="Enter your first name">
                                </div>

                                <div class="form-group col-xs-10" id="lnameDiv">
                                    <label>Last Name <span class="required">*</span></label>
                                    <input type="text" required class="form-control" id="lname" name="lname" placeholder="Enter your last name">
                                </div>

                                <div class="form-group col-xs-10" id="student_idDiv">
                                    <label>Student ID <span class="required">*</span></label>
                                    <input type="text" required class="form-control" id="student_id" name="student_id" placeholder="Enter your university ID">
                                </div>

                                <div class="form-group col-xs-10" id="student_cgpaDiv">
                                    <label>Student CGPA <span class="required">*</span></label>
                                    <input type="number"step="0.01"maxlength="4" required class="form-control" id="student_cgpa" name="student_cgpa" placeholder="Enter your CGPA">
                                </div>

                                <div class="form-group col-xs-10" id="student_completed_creditsDiv">
                                    <label>Completed Credits <span class="required">*</span></label>
                                    <input type="number" required class="form-control" id="student_completed_credits" name="student_completed_credits" placeholder="Enter your completed credits">
                                </div>

                                <div class="form-group col-xs-10">
                                    <label>Last Trimester <span class="required">*</span></label>
                                    <select class="form-control" id="last_semester_name" name="last_semester_name">
                                        <?php
                                            $semester = array('FALL ','SUMMER ','SPRING ');
                                            $current_year = date('Y',time());

                                        for($i = $current_year - 6; $i <= $current_year; $i++) { ?>
                                        <option value="<?php echo $semester[0]."$i"?>"> <?php echo $semester[0]."$i"?> </option>
                                        <option value="<?php echo $semester[1]."$i"?>"> <?php echo $semester[1]."$i"?> </option>
                                        <option value="<?php echo $semester[2]."$i"?>"> <?php echo $semester[2]."$i"?> </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col-xs-10" id="student_taken_creditsDiv">
                                    <label>How many credits taken for next Trimester <span class="required">*</span></label>
                                    <input type="number" required class="form-control" id="student_taken_credits" name="student_taken_credits" placeholder="Taken Credits">
                                </div>

                                <div class="form-group col-xs-10">
                                    <label>Next Trimester <span class="required">*</span></label>
                                    <select class="form-control" id="next_semester_name" name="next_semester_name">
                                        <?php
                                        $semester = array('FALL ','SUMMER ','SPRING ');
                                        $current_year = date('Y',time());

                                        for($i = $current_year; $i <= $current_year + 1; $i++) { ?>
                                            <option value="<?php echo $semester[0]."$i"?>"> <?php echo $semester[0]."$i"?> </option>
                                            <option value="<?php echo $semester[1]."$i"?>"> <?php echo $semester[1]."$i"?> </option>
                                            <option value="<?php echo $semester[2]."$i"?>"> <?php echo $semester[2]."$i"?> </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col-xs-10" id="student_previous_gpaDiv">
                                    <label>Previous Trimester's GPA <span class="required">*</span></label>
                                    <input type="number"step="0.01"maxlength="4" required class="form-control" id="previous_semester_gpa" name="previous_semester_gpa" placeholder="Enter your previous trimester's GPA">
                                </div>

                                <div class="form-group col-xs-10" id="emailDiv">
                                    <label>Email <span class="required">*</span></label>
                                    <input type="email" required class="form-control" id="email" name="email" placeholder="Enter your email">
                                </div>

                                <div class="form-group col-xs-10" id="nidDiv">
                                    <label for="nid">National ID</label>
                                    <input type="text" class="form-control" id="nid" name="nid" placeholder="Enter your National ID">
                                </div>

                                <div class="form-group col-xs-10" id="students_present_addressDiv">
                                    <label for="students_present_address">Student's Present Address <span class="required">*</span></label></label>
                                    <input type="text" required class="form-control" id="students_present_address" name="students_present_address" placeholder="Enter your Present Address">
                                </div>

                                <div class="form-group col-xs-10" id="student_phoneDiv">
                                    <label for="student_phone">Phone Number <span class="required">*</span></label>
                                    <input type="text" required class="form-control" id="student_phone" name="student_phone" placeholder="Enter your Phone Number">
                                </div>

                                <div class="form-group col-xs-10" id="students_permanent_addressDiv">
                                    <label for="students_permanent_address">Student's Permanent Address</label>
                                    <input type="text" class="form-control" id="students_permanent_address" name="students_permanent_address" placeholder="Enter your Permanent Address">
                                </div>
                                <div class="clearfix"></div>

                                <div class="form-group col-xs-10" id="">
                                    <a class="btn btn-outline btn-primary" onclick="checkValidationStepOne('#collapseTwoTrigger')">Next</a>
                                    <a style="visibility: hidden;" id="collapseTwoTrigger" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title" style="color: #fff;">
                                Loan Information
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse">
                            <div class="panel-body">

                                <div id="errorMsg2" style="display: none;" class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" onclick="closeNotification('#errorMsg2')" aria-hidden="true">×</button>
                                    Please correct the following errors:
                                </div>

                                <div class="form-group col-xs-10" id="loan_amountDiv">
                                    <label for="loan_amount">Amount <span class="required">*</span></label>
                                    <input type="number" required class="form-control" id="loan_amount" name="loan_amount" placeholder="Enter your loan ammount">
                                </div>

                                <div class="form-group col-xs-10" id="reasonDiv">
                                    <label for="reason">Reason <span class="required">*</span></label>
                                    <textarea id="reason" required class="form-control" rows="3" placeholder="Enter your reason.." name="reason"></textarea>
                                </div>
                                <div class="clearfix"></div>

                                <div class="form-group col-xs-10">
                                    <input type="checkbox" id="i_agree" name="i_agree"/>
                                    <label for="i_agree" style="color: red;text-decoration: underline;display: inline; vertical-align: middle;">I agree that I will pay the full loan amount before my final examination.</label>
                                </div>
                                <div class="clearfix"></div>

                                <div class="form-group col-xs-10" id="">
                                    <a class="btn btn-outline btn-primary" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Back</a>
                                    <a class="btn btn-outline btn-primary" onclick="checkValidationStepTwo('#collapseThreeTrigger')">Next</a>
                                    <a style="visibility: hidden;" id="collapseThreeTrigger" data-toggle="collapse" data-parent="#accordion" href="#collapseThree"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title" style="color: #fff;">
                                Guarantor Information
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse">
                            <div class="panel-body">

                                <div id="errorMsg3" style="display: none;" class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" onclick="closeNotification('#errorMsg3')" aria-hidden="true">×</button>
                                    Please correct the following errors:
                                </div>


                                <div class="form-group col-xs-10" id="gnameDiv">
                                    <label for="gname">Guardian Name <span class="required">*</span></label>
                                    <input type="text" required class="form-control" id="gname" name="gname" placeholder="Enter guardian's name">
                                </div>

                                <div class="form-group col-xs-10">
                                    <label for="relation">Relation <span class="required">*</span></label>
                                    <select class="form-control" id="relation" name="relation">
                                        <option value="father">Father</option>
                                        <option value="mother">Mother</option>
                                        <option value="brother">Brother</option>
                                        <option value="sister">Sister</option>
                                        <option value="uncle">Uncle</option>
                                        <option value="aunt">Aunt</option>
                                        <option value="others">Others</option>
                                    </select>
                                </div>

                                <div class="form-group col-xs-10" id="gphoneDiv">
                                    <label for="gphone">Guardian Phone Number <span class="required">*</span></label>
                                    <input type="text" required class="form-control" id="gphone" name="gphone" placeholder="Enter guardian's Phone Number">
                                </div>

                                <div class="form-group col-xs-10" id="gaddressDiv">
                                    <label for="gaddress">Guardian's Present Address<span class="required">*</span></label>
                                    <input type="text" required class="form-control" id="gaddress" name="gaddress" placeholder="Enter guardian's Present Address">
                                </div>
                                <div class="clearfix"></div>

                                <div class="form-group col-xs-10" id="">
                                    <a class="btn btn-outline btn-primary" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Back</a>
                                    <a class="btn btn-outline btn-primary" onclick="checkValidationStepThree('#loanForm')">Submit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- .panel-body -->
        </form>
    </div>
    <!-- /.panel -->
</div>
<!-- /.col-lg-12 -->

<script type="text/javascript">
    function checkValidationStepOne(element){
        var fields = ['fname', 'lname', 'student_id', 'email', 'nid', 'students_present_address', 'students_permanent_address','student_completed_credits','student_taken_credits','previous_semester_gpa'], loop, errorFlag = false;
        for (loop = 0; loop < fields.length; loop++){
            if (!document.getElementById(fields[loop]).checkValidity()){
                $('#' + fields[loop] + 'Div').addClass('has-error');
                errorFlag = true;
            } else {
                $('#' + fields[loop] + 'Div').removeClass('has-error');
            }
        }
        if (!errorFlag) {
            $('#errorMsg').slideUp();
            $(element).click();
        }
        else $('#errorMsg').slideDown();
    }
    function checkValidationStepTwo(element){
        var fields = ['loan_amount','reason'], loop, errorFlag = false;
        for (loop = 0; loop < fields.length; loop++){
            if (!document.getElementById(fields[loop]).checkValidity()){
                $('#' + fields[loop] + 'Div').addClass('has-error');
                errorFlag = true;
            } else {
                $('#' + fields[loop] + 'Div').removeClass('has-error');
            }
        }
        if (!$('#i_agree').is(":checked")){
            alert("You must agree to the terms and condition for the loan return.");
            errorFlag = true;
        }
        if (!errorFlag) {
            $('#errorMsg2').slideUp();
            $(element).click();
        }
        else $('#errorMsg2').slideDown();
    }
    function checkValidationStepThree(element){
        var fields = ['gname', 'relation', 'gphone', 'gaddress'], loop, errorFlag = false;
        for (loop = 0; loop < fields.length; loop++){
            if (!document.getElementById(fields[loop]).checkValidity()){
                $('#' + fields[loop] + 'Div').addClass('has-error');
                errorFlag = true;
            } else {
                $('#' + fields[loop] + 'Div').removeClass('has-error');
            }
        }
        if (!errorFlag) {
            $('#errorMsg3').slideUp();
            if (confirm("You must pay the full loan amount before your final exam. Are you sure to submit the loan application now?")){
                $(element).submit();
            }
        }
        else $('#errorMsg3').slideDown();
    }

    function closeNotification(e){
        $(e).slideUp();
    }

</script>