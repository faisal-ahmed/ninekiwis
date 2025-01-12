<div class="col-lg-6 col-lg-offset-3">
    <div class="alert alert-danger alert-dismissable" style="display: <?php echo isset($error) ? 'block' : 'none'; ?>">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong><?php echo $error ?></strong>
    </div>

    <div class="alert alert-warning alert-dismissable" style="display: <?php echo isset($notification) ? 'block' : 'none'; ?>">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong><?php echo $notification ?></strong>
    </div>

    <div class="panel-body">
        <form role="form" method="post" action="<?php echo base_url() ?>index.php/user/login">
            <fieldset>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-2x fa-user"></i></span>
                    <input class="form-control input-lg" placeholder="Email" name="email" type="email" autofocus required>
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon" style="padding-right: 14px; padding-left: 14px;"><i class="fa fa-2x fa-unlock-alt"></i></span>
                    <input class="form-control input-lg" placeholder="Password" name="password" type="password" value="" required>
                </div>
                <input type="submit" class="btn btn-lg btn-primary btn-block" value="Login" />
            </fieldset>
        </form>
    </div>
</div>
