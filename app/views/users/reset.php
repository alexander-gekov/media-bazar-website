<?php include APPROOT . '/views/inc/header.php' ?>
<?php include APPROOT . '/views/inc/nav.php' ?>
<div class="wrapper form-wrapper">
    <h2>Reset Password</h2>
    <form name="resetForm" id="resetForm" action="<?php echo URLROOT . '/users/reset'; ?>" method="post">

        <?php flash('password_change_success'); ?>
        <div>
            <p>
                <label for="new_password"><b>New Password: </b><sup>*</sup></label>
                <input type="password" name="new_password" id="newPass" value="<?php echo $data['new_password']; ?>">
                <span><?php echo $data['new_password_err']; ?></span>
            </p>
        </div>
        <div>
            <p>
                <label for="confirm_password"><b>Confirm Password: </b><sup>*</sup></label>
                <input type="password" name="confirm_password" id="confirmNewPass" value="<?php echo $data['confirm_password']; ?>">
                <span><?php echo $data['confirm_password_err']; ?></span>
            </p>
        </div>
        <div>
            <input type="submit" id="btnSubmit" class="button-black" value="Reset">
            <a class="button" href="<?php URLROOT . '/pages/index' ?>">Cancel</a>
        </div>
    </form>
</div>
<?php include APPROOT . 'views/inc/footer.php' ?>
