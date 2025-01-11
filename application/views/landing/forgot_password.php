<div class="col-lg-8 landingRightPanel">
    <div class="panel-heading">
        <h2 class="panel-title custom_panel_heading">Reset My Password</h2>
    </div>
    <div class="alert alert-danger alert-dismissable" style="display: <?php echo isset($error) ? 'block' : 'none'; ?>">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong><?php echo $error ?></strong>
    </div>

    <div class="alert alert-success alert-dismissable" style="display: <?php echo isset($success) ? 'block' : 'none'; ?>">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong><?php echo $success ?></strong>
    </div>
    <div class="panel-body">
        <form method="post" role="form">
            <fieldset>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-2x fa-user"></i></span>
                    <input class="form-control input-lg" placeholder="Enter your email address" name="email" type="email" autofocus required>
                </div>
                <!-- Change this to a button or input when using this as a form -->
                <input type="submit" class="btn btn-lg btn-primary btn-block" value="Submit"/>
            </fieldset>
        </form>
    </div>
</div>
