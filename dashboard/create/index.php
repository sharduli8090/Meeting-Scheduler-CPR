<?php
include($_SERVER['DOCUMENT_ROOT'] . "/assets/sessions.php");
if (!$activeSession) {
    header("Location:/");
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Create Meeting | CPR</title>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="/assets/css/styles.css">

        <script src="/assets/framework/jquery.min.js" charset="utf-8"></script>
        <script src="/assets/framework/propbar.min.js" charset="utf-8"></script>
        <script src="/assets/framework/fontawesome.all.min.js"></script>
    </head>
    <body>
        <div class="root">
            <form class="main" action="index.html" method="post">
                <div><a class="link_back" href="/dashboard"><i class="far fa-arrow-left"></i></a> <span class="creta_title">Create Meeting</span></div>
                <br><br>
                <div class="creta_flex">
                    <div class="creta_box">
                        <div class="creta_inner">
                            <div class="form-group">
                                <label class="form-label" for="meetname">Meeting Name</label>
                                <input class="form-input" type="text" id="meetname" name="meetname" autocomplete="off" required>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label class="form-label" for="meetdate">Meeting date</label>
                                <input class="form-input" type="date" min="<?=date("Y-m-d")?>" name="meetdate" id="meetdate" required>
                            </div>
                        </div>
                    </div>
                    <div class="creta_box">
                        <div class="creta_inner">
                            <div class="form-group">
                                <label class="form-label" for="meetstart">Schedule Start</label>
                                <select class="form-input" name="meetstart" id="meetstart" required>
                                    <option value="">--Select Start Time--</option>
                                </select>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label class="form-label" for="meetend">Schedule End</label>
                                <select class="form-input" name="meetend" id="meetend" required>
                                    <option value="">--Select End Time--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <button type="submit" class="form-button">Schedule</button>
                </div>
            </form>
        </div>
    </body>
</html>
<script type="text/javascript">
    (function() {
        'use strict';
        const trime = time => time;
        const select = $("select");
        const slots = ["12", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11"];
        for (var i = 0; i < slots.length; i++) {
            let time = slots[i] + ":00 AM";
            select.append($(`<option value="${trime(time)}">${time}</option>`));
        }
        for (var i = 0; i < slots.length; i++) {
            let time = slots[i] + ":00 PM";
            select.append($(`<option value="${trime(time)}">${time}</option>`));
        }
    }());
    $("form").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "/dashboard/create/check.php",
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
