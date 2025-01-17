<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="account-container">
            <h1 class="text-center">Register</h1>
            <p class="text-center">Please fill in your details</p>

            <?php if ($this->session->flashdata('message')): ?>
                <div class="alert alert-success">
                    <?= $this->session->flashdata('message'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('register_submit') ?>" method="post">
                <div class="login-fields">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" required autocomplete="off" placeholder="Username" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" name="firstname" id="firstname" required autocomplete="off" placeholder="Firstname" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" name="lastname" id="lastname" required autocomplete="off" placeholder="Lastname" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" required autocomplete="off" placeholder="Email" class="form-control" />
                        <small id="email-error" style="color: red; font-size:medium; display: none;"></small>
                    </div>
                    <div class="form-group">
                        <label for="phonenumber">Phone Number</label>
                        <input type="text" name="phonenumber" id="phonenumber" required autocomplete="off" placeholder="Phonenumber" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required autocomplete="off" placeholder="Password" class="form-control" />
                    </div>

                    <div class="form-group">
                        <button type="submit" id="register-btn" class="btn btn-block" style="background-color: #b63e9e; color: white;" disabled>Register</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="text-center">
            <p>Already have an account? <a href="<?= base_url('login') ?>">Login here</a></p>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#email').on('blur', function () {
                var email = $(this).val();
                
                if (email) {
                    $.ajax({
                        url: '<?= base_url('RegisterController/check_email') ?>',
                        method: 'POST',
                        data: { email: email },
                        success: function (response) {
                            if (response == 'taken') {
                                $('#email-error').text('This email is already used!').show();
                                $('#register-btn').prop('disabled', true);
                            } else {
                                $('#email-error').text('').hide();
                                $('#register-btn').prop('disabled', false);
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>


