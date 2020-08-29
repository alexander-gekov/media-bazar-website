<?php include APPROOT . '/views/inc/header.php' ?>
<?php include APPROOT . '/views/inc/nav.php' ?>
<form class="text-center border border-light p-5 mx-auto mt-20
          bg-light rounded-lg shadow-lg position-relative w-25"
      name="loginForm" id="loginForm"
      action="<?php echo URLROOT . '/users/login'; ?>" method="post">

    <p class="h4 mb-4">Sign in</p>

    <!-- Email -->
    <input type="text" id="username" name="username"
           class="form-control mb-4 <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>"
           value="<?php echo $data['username']; ?>" placeholder="Username">
    <span class="invalid-feedback"><?php echo $data['username_err']; ?></span>
    <!-- Password -->
    <input type="password" id="password" name="password"
           class="form-control mb-4 <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>"
           value="<?php echo $data['password']; ?>" placeholder="Password">
    <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
    <div class="d-flex justify-content-around">
        <div>
            <!-- Remember me -->
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="defaultLoginFormRemember" name="defaultLoginFormRemember">
                <label class="custom-control-label" for="defaultLoginFormRemember">Remember me</label>
            </div>

        </div>
        <div>
            <!-- Forgot password -->
            <a href="">Forgot password?</a>
        </div>
    </div>

    <!-- Sign in button -->
    <button class="btn btn-info btn-block purple purple-hover my-4" type="submit">Sign in</button>

</form>
<?php include APPROOT . '/views/inc/footer.php'; ?>
</body>
</html>
