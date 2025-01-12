<div id="page-wrapper" style="padding: 10px; border-left: 0;" class="active">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="color: #FFFFFF;">
                    <?php echo $menuTitle ?>
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
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Stock Quantity</th>
                                <th>Category</th>
                                <th>SKU</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Created At</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($application as $key => $value) { ?>
                                <tr class="<?php echo ($key % 2) ? "even" : "odd"; ?> gradeX">
                                    <td>
                                        <a href="<?php echo base_url() ?>index.php/AdminDashboard/viewProduct/<?php echo $value['product_id'] ?>">
                                            <?php echo $value['product_name'] ?>
                                        </a>
                                    </td>
                                    <td><?php echo $value['description'] ?></td>
                                    <td><?php echo $value['price'] ?></td>
                                    <td><?php echo $value['stock'] ?></td>
                                    <td><?php echo $value['category_title'] ?></td>
                                    <td><?php echo $value['sku'] ?></td>
                                    <td><?php echo $value['status'] ?></td>
                                    <td><?php echo $value['image'] ?></td>
                                    <td><?php echo $value['created_at'] ?></td>
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