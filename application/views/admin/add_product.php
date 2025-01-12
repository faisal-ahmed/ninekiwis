<div id="page-wrapper" style="padding: 10px; border-left: 0;" class="active">

    <div class="panel panel-default">
    <div class="panel-heading font-white">
        <i class="fa fa-clock-o fa-fw"></i> <?php echo $menuTitle ?>
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
        <div class="timeline-panel">
            <form enctype="multipart/form-data" action="" method="post">
                <div class="form-group col-xs-12" style="padding-left: 0;">
                    <label>Product's Name:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter the product's name." required="true">
                </div>
                <div class="form-group col-xs-12" style="padding-left: 0;">
                    <label>Product's Short Description:</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Enter the product's description."></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-xs-6" style="padding-left: 0;">
                    <label>Product's Price (Euro):</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="Enter the product's price in euro." required="true">
                </div>
                <div class="form-group col-xs-6" style="padding-left: 0;">
                    <label>Product Status:</label>
                    <select class="form-control" name="status" id="status">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-xs-4" style="padding-left: 0;">
                    <label>Product's SKU:</label>
                    <input type="text" class="form-control" id="sku" name="sku" placeholder="Enter the product's SKU." required="true">
                </div>
                <div class="form-group col-xs-4" style="padding-left: 0;">
                    <label>Product's Stock Quantity:</label>
                    <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" placeholder="Enter the product's stock quantity." required="true">
                </div>
                <div class="form-group col-xs-4" style="padding-left: 0;">
                    <label>Product's Category:</label>
                    <select class="form-control" name="category_id" id="category_id">
                        <?php foreach ($category as $key => $value) { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-xs-12" style="padding-left: 0;">
                    <label>Product's Image:</label>
                    <input type="file" accept=".png,.jpg,.jpeg" class="form-control" id="product_image" name="product_image" required="true">
                </div>

                <div class="clearfix"></div>
                <button type="submit" class="btn btn-warning">Add Product</button>
            </form>
        </div>
    </div>
    <!-- /.panel-body -->
</div>

</div>