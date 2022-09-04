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
        <title>CPR</title>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="/assets/css/styles.css">

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
                    <a class="header_account_up" href="/start">Getting started</a>
                </div>
            </div>
        </div>
        <div class="banner">
            <div class="banner_aria">
                <div class="banner_aria_h4">Scheduling<br>At <span class="ease">Ease</span></div>
                <div class="banner_aria_pc">CPR is the center for setting up meetings swiftly and professionally, doing away with the stress of back-and-forth emails so you can continue your task.</div>
            </div>
        </div>
    </body>
</html>
