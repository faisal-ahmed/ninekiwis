<div id="page-wrapper" style="padding: 10px; border-left: 0;" class="active">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="color: #FFFFFF;">
                    <?php echo $menuTitle ?>
                    <a target="_blank" href="<?php echo base_url() ?>index.php/AdminDashboard/download/<?php echo $item ?>" style="float: right; color: #fff;">Export as CSV</a>
                    <!--<a href="#" style="float: right; color: #FFFFFF">Export as CSV</a>-->
                </div>
                <div class="panel-body" style="display: <?php echo isset($success) ? "block" : "none"; ?>">
                    <div class="alert alert-success alert-dismissable" style="margin-bottom: 0;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php if (isset($success)) echo $success; ?>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="adminDashboardDataTables">
                            <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Created Date</th>
                                <th>Student ID</th>
                                <th>Phone</th>
                                <?php if (isset($item) && ($item == '2' || $item == '4' || $item == '5')) { ?>
                                    <th>Approved Loan</th>
                                    <th>Remaining Loan</th>
                                <?php } ?>
                                <th>Tenor</th>
                                <?php if (isset($status) && $status == 'existing') { ?><th>Approved Date</th><?php } ?>
                                <?php if (isset($item) && $item == '0') { ?><th>Actions</th><?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($application as $key => $value) { ?>
                                <?php $newApplicationClass = ($value['read'] == '0') ? 'danger' : ''; ?>
                                <tr class="<?php echo ($key % 2) ? "even" : "odd"; ?> gradeX <?php if (isset($item) && $item == '0') echo $newApplicationClass ?>">
                                    <td>
                                        <a href="<?php echo base_url() ?>index.php/AdminDashboard/viewApplication/<?php echo $value['user_id'] ?>/<?php echo (isset($status) && $status == 'existing') ? "1" : "0"; ?>">
                                            <?php echo $value['fullname'] ?>
                                        </a>
                                    </td>
                                    <td class="center"><span style="display: none;"><?php echo $value['created_date_timestamp']; ?></span><?php echo $value['created_time'] ?></td>
                                    <td><?php echo $value['student_id'] ?></td>
                                    <td><?php echo $value['phone'] ?></td>
                                    <?php if (isset($item) && ($item == '2' || $item == '4' || $item == '5')) { ?>
                                        <td><?php echo $value['approved_amount'] ?></td>
                                        <td><?php echo $value['remaining_amount'] ?></td>
                                    <?php } ?>
                                    <td><?php echo $value['tenor'] ?></td>
                                    <?php if (isset($status) && $status == 'existing') { ?><td class="center"><?php echo $value['date_taken'] ?></td><?php } ?>
                                    <?php if (isset($item) && $item == '0') { ?>
                                    <td>
                                        <a target="_blank" href="<?php echo base_url() ?>index.php/AdminDashboard/printApplication/<?php echo $value['user_id'] ?>">
                                            Print Preview
                                        </a> | <a href="<?php echo base_url() ?>index.php/AdminDashboard/newApplicant?changeReadStatus=<?php echo ( 1 - $value['read'] ) ?>&id=<?php echo $value['user_id'] ?>">
                                            <?php echo ($value['read'] == '0') ? 'Mark As Read' : 'Mark As Unread'; ?>
                                        </a>
                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>


<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script type="text/javascript">
    var dataTable = 'adminDashboardDataTables';
</script>