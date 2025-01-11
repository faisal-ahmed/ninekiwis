<div id="page-wrapper" style="padding: 10px; border-left: 0;" class="active">

    <div class="panel panel-default">
    <div class="panel-heading font-white">
        <i class="fa fa-clock-o fa-fw"></i> Application Details
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body" style="display: <?php echo isset($error) ? "block" : "none"; ?>">
        <div class="alert alert-danger alert-dismissable" style="margin-bottom: 0;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php if (isset($error)) echo $error; ?>
        </div>
    </div>
    <div class="panel-body" style="display: <?php echo isset($success) ? "block" : "none"; ?>">
        <div class="alert alert-success alert-dismissable" style="margin-bottom: 0;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php if (isset($success)) echo $success; ?>
        </div>
    </div>
    <div class="panel-body">
        <ul class="timeline">
            <li>
                <div class="timeline-badge success"><i class="fa fa-user"></i>
                </div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <h4 class="timeline-title" style="text-decoration: underline;">Student Information</h4>
                    </div>
                    <div class="timeline-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr class="danger">
                                    <td>Full Name:</td>
                                    <td><?php echo $application_detail['details']['firstname'] . " " . $application_detail['details']['lastname']; ?></td>
                                </tr>
                                <tr class="success">
                                    <td>Student ID:</td>
                                    <td><?php echo $application_detail['details']['student_id']; ?></td>
                                </tr>
                                <tr class="danger">
                                    <td>Student CGPA:</td>
                                    <td><?php echo $application_detail['details']['student_cgpa']; ?></td>
                                </tr>
                                <tr class="success">
                                    <td>Student Email:</td>
                                    <td><?php echo $application_detail['details']['email']; ?></td>
                                </tr>
                                <tr class="danger">
                                    <td>Student Phone:</td>
                                    <td><?php echo $application_detail['details']['phone']; ?></td>
                                </tr>
                                <tr class="success">
                                    <td>Student Present Address:</td>
                                    <td><?php echo $application_detail['details']['present_address']; ?></td>
                                </tr>
                                <tr class="danger">
                                    <td>Student Permanent Address:</td>
                                    <td><?php echo $application_detail['details']['permanent_address']; ?></td>
                                </tr>

                                <tr class="success">
                                    <td>Student's credits complete:</td>
                                    <td><?php echo $application_detail['details']['completed_credits'] . ' Up to ' . $application_detail['details']['last_semester']; ?></td>
                                </tr>
                                <tr class="danger">
                                    <td>Taken Credits for upcoming <?php echo $application_detail['details']['next_semester']; ?> semester:</td>
                                    <td><?php echo $application_detail['details']['taken_credits']; ?></td>
                                </tr>
                                <tr class="success">
                                    <td>Student's GPA of last Trimester:</td>
                                    <td><?php echo $application_detail['details']['previous_semester_gpa'];?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </li>
            <li class="timeline-inverted">
                <div class="timeline-badge warning"><i class="fa fa-bank"></i>
                </div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <h4 class="timeline-title" style="text-decoration: underline;">Loan Information</h4>
                    </div>
                    <div class="timeline-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr class="info">
                                    <td><strong>Requested Loan Amount:</strong></td>
                                    <td><strong><?php echo $application_detail['details']['requested_amount']; ?></strong></td>
                                </tr>
                                <tr class="warning">
                                    <td><strong>Approved Loan Amount:</strong></td>
                                    <td><strong><?php echo ($application_detail['details']['approved_amount'] == '') ? "Not Approved Yet" : $application_detail['details']['approved_amount']; ?></strong></td>
                                </tr>
                                <tr class="info">
                                    <td><strong>Remaining Loan Amount:</strong></td>
                                    <td><strong><?php echo $application_detail['details']['remaining_amount']; ?></strong></td>
                                </tr>
                                <tr class="warning">
                                    <td>Loan Tenor:</td>
                                    <td><?php echo $application_detail['details']['tenor']; ?></td>
                                </tr>
                                <tr class="info">
                                    <td>Loan Reason:</td>
                                    <td><?php echo $application_detail['details']['note']; ?></td>
                                </tr>
                                <tr class="warning">
                                    <td>Loan Approval Date:</td>
                                    <td><?php echo isset($application_detail['details']['approved_date']) ? date("jS F, Y", $application_detail['details']['approved_date']) : "Not Approved Yet."; ?></td>
                                </tr>
                                <tr class="info">
                                    <td>Loan Status:</td>
                                    <td><?php echo $application_detail['details']['status']; ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="timeline-badge danger"><i class="fa"><span class="glyphicon glyphicon-user"></span></i>
                </div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <h4 class="timeline-title" style="text-decoration: underline;">Loan Guarantor Information</h4>
                    </div>
                    <div class="timeline-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr class="danger">
                                        <td>Loan Guarantor Name:</td>
                                        <td><?php echo $application_detail['details']['guarantor_name']; ?></td>
                                    </tr>
                                    <tr class="success">
                                        <td>Loan Guarantor Relation:</td>
                                        <td><?php echo $application_detail['details']['relation']; ?></td>
                                    </tr>
                                    <tr class="danger">
                                        <td>Loan Guarantor Contact No.:</td>
                                        <td><?php echo $application_detail['details']['guarantor_contact_no']; ?></td>
                                    </tr>
                                    <tr class="success">
                                        <td>Loan Guarantor Address:</td>
                                        <td><?php echo $application_detail['details']['guarantor_address']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </li>
            <li class="timeline-inverted">
                <div class="timeline-badge info"><i class="fa fa-money"></i>
                </div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <h4 class="timeline-title" style="text-decoration: underline;">Transactions</h4>
                    </div>
                    <div class="timeline-body">
                        <?php if (count($application_detail['transactions']) > 0) { ?>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <?php foreach ($application_detail['transactions'] as $key => $value) { ?>
                                    <tr class="<?php echo ($key % 2) ? "info" : "warning"; ?>">
                                        <td><?php echo ($key+1) ?></td>
                                        <td>
                                            <?php
                                            $str = $application_detail['transactions'][$key]['amount'];
                                            $str .= " BDT was ";
                                            $str .= ($application_detail['transactions'][$key]['type'] . "ed on ");
                                            $str .= date("jS F, Y", $application_detail['transactions'][$key]['date']);
                                            echo $str . ".";
                                            ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } else echo "No Transaction was found for this loan." ?>
                    </div>
                </div>
            </li>
            <li style="display: <?php echo ($application_detail['details']['status'] == 'Paid in full') ? "none" : "block"; ?>">
                <div class="timeline-badge success"><i class="fa fa-graduation-cap"></i>
                </div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><strong>Actions</strong>
                                <i class="fa fa-gear"></i>  <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="javascript:void(0)" onclick="statusUpdate()">Update Status</a>
                                </li>
                                <li><a href="javascript:void(0)" onclick="addTransaction()">Add a Transaction</a>
                                </li>
                                <li><a href="javascript:void(0)" onclick="updateDeadline()">Increase Deadline</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="timeline-body">
                        <hr>
                        <p id="initialMsg">Select any actions to update the loan.</p>
                        <p id="approval_date_error" style="display: none;">Sorry, You cannot add a transaction to a loan that isn't approved yet. Please approve the loan first.</p>
                        <form action="" method="post" id="statusUpdate" style="display: none;">
                            <input type="hidden" name="action" value="statusUpdate"/>
                            <input type="hidden" name="loan_id" value="<?php echo $application_detail['details']['loan_id'] ?>"/>
                            <div class="form-group col-xs-6" style="padding-left: 0;">
                                <label>Update Status</label>
                                <select class="form-control" name="status" id="status" onchange="checkStatus();">
                                    <?php
                                        $statusArray = array(
                                            "Loan is being reviewed by the authority" => "Loan Processing.",
                                            "Approved" => "Approved.",
                                            "Paid in full" => "Paid in full",
                                            "The application was declined by the authority" => "Loan is rejected.",
                                            "You have not paid your previous loan. Please pay your existing loan" => "Loan is debt.",
                                        );
                                        if ($application_detail['details']['approved_date'] != '') {
                                            unset($statusArray["Approved"]);
                                        }

                                        foreach ($statusArray as $key => $value) {
                                            if ($key != $application_detail['details']['status']){
                                                ?>
                                                <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-xs-6" id="approvedLoanAmountDiv" style="display: none; padding-left: 0;">
                                <label>Approved Amount</label>
                                <input type="number" class="form-control" id="approved_amount" name="approved_amount" placeholder="Enter the approved loan amount.">

                                <div class="clearfix"></div>
                                <div class="form-group"  style="padding-left: 0;margin-top: 10px">
                                    <label>Tenor</label>
                                    <input type="text" class="form-control" id="tenor" name="tenor" placeholder="Enter the deadline.">
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <button type="submit" class="btn btn-warning">Update Status</button>
                        </form>
                        <form action="" method="post" id="addTransactionForm" style="display: none;">
                            <input type="hidden" name="action" value="addTransaction"/>
                            <input type="hidden" name="loan_id" value="<?php echo $application_detail['details']['loan_id'] ?>"/>
                            <div class="form-group col-xs-6" style="padding-left: 0;">
                                <label>Transaction Amount</label>
                                <input type="number" class="form-control" name="amount" placeholder="Enter the transaction amount." required>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-xs-6" style="padding-left: 0;">
                                <label>Transaction Date</label>
                                <input type="text" id="transactionDate" class="form-control" name="date" required>
                            </div>
                            <div class="clearfix"></div>
                            <button type="submit" class="btn btn-warning">Add a Transaction</button>
                        </form>
                        <form action="" method="post" id="updateTenorForm" style="display: none;">
                            <input type="hidden" name="action" value="updateTenor"/>
                            <input type="hidden" name="loan_id" value="<?php echo $application_detail['details']['loan_id'] ?>"/>
                            <div class="form-group col-xs-6" style="padding-left: 0;">
                                <label>New Deadline</label>
                                <input type="text" id="updateTenor" class="form-control" name="updateTenor" required>
                            </div>
                            <div class="clearfix"></div>
                            <button type="submit" class="btn btn-warning">Update Deadline</button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <!-- /.panel-body -->
</div>

</div>

<script type="text/javascript">
    function checkStatus(){
        if ($('#status').val() == 'Approved'){
            $('#approvedLoanAmountDiv').slideDown();
            $('#approved_amount').attr("required", "required");
            $('#tenor').attr("required", "required");
        } else {
            $('#approvedLoanAmountDiv').slideUp();
            $('#approved_amount').removeAttr("required");
            $('#tenor').removeAttr("required");
        }
    }

    function statusUpdate(){
        $('#approval_date_error').slideUp();
        $('#initialMsg').slideUp();
        $('#addTransactionForm').slideUp();
        $('#updateTenorForm').slideUp();
        $('#statusUpdate').slideDown();
    }

    function addTransaction(){
        var approved = "<?php echo (!isset($application_detail['details']['approved_date'])) ? "0" : "1"; ?>";
        if (approved == "0"){
            $('#approval_date_error').slideDown();
        } else {
            $('#approval_date_error').slideUp();
            $('#initialMsg').slideUp();
            $('#addTransactionForm').slideDown();
            $('#updateTenorForm').slideUp();
            $('#statusUpdate').slideUp();
        }
    }

    function updateDeadline(){
        $('#approval_date_error').slideUp();
        $('#initialMsg').slideUp();
        $('#addTransactionForm').slideUp();
        $('#statusUpdate').slideUp();
        $('#updateTenorForm').slideDown();
    }

    $( "#tenor" ).datepick({
        dateFormat: 'dd-mm-yyyy',
        minDate: 0
    });
    $( "#transactionDate" ).datepick({
        dateFormat: 'dd-mm-yyyy',
        minDate: 0
    });
    $( "#updateTenor" ).datepick({
        dateFormat: 'dd-mm-yyyy',
        minDate: 0
    });
</script>