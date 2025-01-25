<div class="account-container">
    <div class="content clearfix">
        <form action="<?= base_url('login') ?>" method="post">
            <h1 class="text-center" style="margin-bottom:0px"><center>Login</center></h1>
            <center>
                <p>Please provide your details</p>
            </center>

            <div class="login-fields">
                <?php if (isset($error) && $error): ?>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    Your username or password are invalid
                </div>
                <?php endif; ?>

                <div class="field">
                    <label for="username_or_email">Username or Email</label>
                    <input type="text" name="username_or_email" id="username_or_email" required autocomplete="off" placeholder="Username or Email" class="login username-field" />
                </div> <!-- /field -->

                <div class="field">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required autocomplete="off" placeholder="Password" class="login password-field" />
                </div> <!-- /password -->

                <div class="field">
                    <button class="button btn btn-block rounded-0 btn-large" style="background-color: #b63e9e; color: white;">Sign In</button>
                </div>
				
                <div class="field" style="margin-top: 15px;">
                    <a href="<?= base_url('register') ?>" class="button-reg btn btn-block rounded-0 btn-large" style="background-color: #4CAF50; color: white;">Register</a>
                </div>
            </div> <!-- /login-fields -->

            <div class="login-actions">
                <span class="login-checkbox">
                    <input id="keep_signed_in" name="keep_signed_in" type="checkbox" class="field login-checkbox" value="1" tabindex="4" />
                    <label class="choice" for="keep_signed_in">Keep me signed in</label>
                </span>
            </div> <!-- .actions -->
        </form>
    </div> <!-- /content -->
</div> <!-- /account-container -->

<div class="login-extra">
    <!-- You can add extra links or information here -->
</div> <!-- /login-extra -->
