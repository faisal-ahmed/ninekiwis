<div class="col-lg-8 landingRightPanel">
    <div class="panel-heading">
        <h2 class="panel-title"><strong>Already have an account?</strong></h2>
    </div>

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
                    <input class="form-control input-lg" placeholder="Username" name="username" type="text" autofocus required>
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon" style="padding-right: 14px; padding-left: 14px;"><i class="fa fa-2x fa-unlock-alt"></i></span>
                    <input class="form-control input-lg" placeholder="Password" name="password" type="password" value="" required>
                </div>
                <!--<div class="checkbox">
                    <label style="font-size: 1.2em;">
                        <input name="remember" class="fa-2x" type="checkbox" value="Remember Me">Remember Me
                    </label>
                </div>-->
                <!-- Change this to a button or input when using this as a form -->
                <input type="submit" class="btn btn-lg btn-primary btn-block" value="Login" />
            </fieldset>
        </form>
        <a href="<?php echo base_url() ?>index.php/user/forgotPassword" style="margin: 10px 0; display: inline-block; color: #000; font-size: 1.2em;">Forgot your password?</a>
    </div>
</div>
