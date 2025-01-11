<div id="<?php echo ($role == ADMIN_ROLE_TITLE) ? "page-wrapper" : ""; ?>" style="padding: 10px; border-left: 0;" class="active">

    <div class="panel panel-default">
        <div class="panel-heading custom_panel_heading">
            <h4 style="display: inline-block; color: #fff;">
                Personal Information
            </h4>
            <?php if ($role == STUDENT_ROLE_TITLE) { ?>
                <a style="float: right;" href="<?php echo base_url() ?>index.php/StudentDashboard"><h4>Dashboard</h4></a>
            <?php } ?>
        </div>
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
        <form role="form" id="updateProfileForm" method="post" action="<?php echo base_url() ?>index.php/user/updateProfile">
            <div class="panel-body" id="personal_info">

                <div class="panel-body">
                    <div class="alert alert-info alert-dismissable" style="margin-bottom: 0;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Please keep the passwords field empty if you don't want to update your password.
                    </div>
                </div>

                <?php if ($role == ADMIN_ROLE_TITLE) { ?>
                <div class="form-group col-xs-6" id="fnameDiv">
                    <label>First Name </label>
                    <input type="text"  class="form-control" id="fname" name="fname" value="<?php echo $userData['firstname'] ?>">
                </div>

                <div class="form-group col-xs-6" id="lnameDiv">
                    <label>Last Name </label>
                    <input type="text"  class="form-control" id="lname" name="lname" value="<?php echo $userData['lastname'] ?>">
                </div>
                <?php } ?>

                <div class="form-group col-xs-6" id="passwordDiv">
                    <label>New Password </label>
                    <input type="password"  class="form-control" id="newPassword" name="newPassword" placeholder="Enter new password if you want to change the existing">
                </div>

                <div class="form-group col-xs-6" id="passwordConfirmDiv">
                    <label>Confirm New Password </label>
                    <input type="password"  class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Please confirm the new password">
                </div>

                <div class="form-group col-xs-6" id="emailDiv">
                    <label>Email </label>
                    <input type="email"  class="form-control" id="email" name="email" value="<?php echo $userData['email'] ?>">
                </div>

                <div class="form-group col-xs-6" id="phoneDiv">
                    <label>Phone No. </label>
                    <input type="number"  class="form-control" id="phone" name="phone" value="<?php echo $userData['phone'] ?>">
                </div>

                <div class="form-group col-xs-10" id="submitDiv">
                    <button class="btn btn-success" onclick="isValidForm();" type="button">Update</button>
                </div>

            </div>
            <div class="panel-body" id="password_confirmmation" style="display: none;">
                <div class="panel-body">
                    <div class="alert alert-info alert-dismissable" style="margin-bottom: 0;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Please enter your current password to update the changes.
                    </div>
                </div>
                <div class="form-group col-xs-6" id="passwordDiv">
                    <label>Current Password </label>
                    <input type="password"  class="form-control" id="currentPassword" name="currentPassword" placeholder="" required>
                </div>

                <div class="form-group col-xs-10">
                    <button class="btn btn-success" onclick="back();" type="button">Back</button>
                    <input class="btn btn-success" type="submit" value="Confirm Update"/>
                </div>
            </div>

        </form>

    </div>

</div>

<script type="text/javascript">
    function requiredCheck(){
        var required = ['fname', 'lname', 'email', 'phone'], column = ['First Name', 'Last Name', 'Email', 'Phone'];

        for (var i = 0; i < required.length; i++) {
            if ($('#' + required[i]).val() == ''){
                $('#' + required[i] + 'Div').addClass('has-error');
                return column[i] + ' is required.';
            } else {
                $('#' + required[i] + 'Div').removeClass('has-error');
            }
        }

        return true;
    }

    function isValidForm(){
        var newPasswordDiv = $('#passwordDiv'), confirmPasswordDiv = $('#passwordConfirmDiv'), requiredMsg = '';
        if ($('#newPassword').val() != $('#confirmPassword').val()) {
            newPasswordDiv.addClass('has-error');
            confirmPasswordDiv.addClass('has-error');
            alert("Please confirm your password.");
            return false;
        } else if ( (requiredMsg = requiredCheck()) !== true ) {
            alert(requiredMsg);
            return false;
        }

        newPasswordDiv.removeClass('has-error');
        confirmPasswordDiv.removeClass('has-error');
        $('#personal_info').slideUp();
        $('#password_confirmmation').slideDown();
    }

    function back(){
        $('#personal_info').slideDown();
        $('#password_confirmmation').slideUp();
    }
</script>