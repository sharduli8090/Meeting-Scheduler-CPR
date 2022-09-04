<?php
include($_SERVER['DOCUMENT_ROOT'] . "/assets/sessions.php");
if ($activeSession) {
    header("Location:/dashboard");
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Getting Started | CPR</title>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="/assets/css/styles.css">

        <script src="/assets/framework/jquery.min.js" charset="utf-8"></script>
        <script src="/assets/framework/propbar.min.js" charset="utf-8"></script>
        <script src="/assets/framework/fontawesome.all.min.js"></script>
    </head>
    <body>
        <div class="restrict">
            <div class="header">
                <div class="header_banner">
                    <img src="/assets/images/cpr-logo.png" alt="">
                </div>
                <div class="header_account">
                    <a class="header_account_in" href="/login">Sign in</a>
                </div>
            </div>
        </div>
        <div class="banner">
            <div class="banner_flex">
                <div class="banner_aria_h4">Welcome to <span class="ease">CPR</span></div>
                <div class="banner_aria_pc">Create a new account.</div>
                <form action="">
                    <div class="form-group">
                        <label class="form-label" for="name">Full Name</label>
                        <input class="form-input" name="name" type="name" id="name" placeholder="John Doe" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <input class="form-input" name="email" type="email" id="email" placeholder="johndoe@example.com" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">Create Password</label>
                        <input class="form-input" name="password" type="password" id="password" placeholder="***********" required>
                    </div>
                    <div class="form-group">
                        <p class="form-manual">Already have an Account? <a href="/login">Login</a></p>
                    </div>
                    <div class="form-group">
                        <button class="form-button form-submit">Create Account</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript">
    $("form").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "/start/check.php",
            type: "post",
            data: $(this).serialize(),
            success( data ) {
                if (data.type === "success") {
                    return window.location.href = "/dashboard";
                }
                console.log(data);
                if (data.type !== "error") data = {throw:"Unexpected error occured."};
                Propbar(data.throw, {closeButton:true,clickable:true,align:'center'},3000);
            },
        });
    });
</script>
