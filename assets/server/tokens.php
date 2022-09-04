<?php
include($_SERVER['DOCUMENT_ROOT'] . "/assets/sessions.php");

$file = $_SERVER["DOCUMENT_ROOT"] . "/assets/server/events.json";
$data = file_get_contents($file);
$data = json_decode($data, true);
$spc_data = array();
foreach ($data as $key => $value) {
    if ($value['user'] === $spc_user && $value['token'] === $spc_token) {
        $spc_data = $value;
    }
}

$file = $_SERVER["DOCUMENT_ROOT"] . "/assets/server/bookings.json";
$data = file_get_contents($file);
$data = json_decode($data, true);
$booked = array();
$slotleft = false;
foreach ($data as $key => $value) {
    if ($value['token'] === $spc_token && $value['user'] === $spc_user) {
        array_push($booked, $value['slot']);
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title><?=$spc_data['name']?> | <?=$spc_data['alias']?> (<?=$spc_user?>) | Schedule Meeting | CPR</title>
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
                <div><a class="link_back" href="/dashboard"><i class="far fa-arrow-left"></i></a> <span class="creta_title">Schedule Meeting</span></div>
                <br><br>
                <input type="hidden" name="token" value="<?=$spc_data['token']?>">
                <input type="hidden" name="user" value="<?=$spc_data['user']?>">
                <?php if ($activeUser === $spc_user): ?>
                    <div class="error">You cannot Schedule a meeting with yourself. <a href="/dashboard">Back to Dashboard</a></div>
                <?php else: ?>
                    <div class="error" style="text-align: left; font-size: 1.3em;">
                        <p><b><?=$spc_data['name']?></b> - <b><?=$spc_data['alias']?> </b>(<?=$spc_user?>)<br><b><?=join("-", array_reverse(explode("-", $spc_data['date'])))?></b> at <b><?=$spc_data['start']?></b> to <b><?=$spc_data['end']?></b></p>
                    </div>
                    <?php if (new DateTime() > new DateTime($spc_data['date'] . " " . date("H:i", strtotime($spc_data['end'])))): ?>
                        <div class="error">This meeting has been expired. <a href="/dashboard">Back to Dashboard</a></div>
                    <?php else: ?>
                        <div class="restrict" style="max-width: 600px;margin-left: 0;">
                            <?php if ($activeUser): ?>
                                <input type="hidden" name="name" value="<?=$activeUserName?>" required>
                                <input type="hidden" name="email" value="<?=$activeUser?>" required>
                                <div class="error" style="text-align: left; font-size: 1.1em;">Booking as: <b><?=$activeUserName?></b> (<?=$activeUser?>)</div>
                            <?php else: ?>
                                <div class="form-group">
                                    <label class="form-label" for="name">Full Name</label>
                                    <input class="form-input" type="text" id="name" name="name" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="email">Email address</label>
                                    <input class="form-input" type="email" id="email" name="email" autocomplete="off" required>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label class="form-label" for="slot">Time slot</label>
                                <select class="form-input" id="slot" name="slot" required>
                                    <option value="">--Select Slot--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-button">Schedule</button>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </form>
        </div>
    </body>
</html>
<script type="text/javascript">
    (function() {
        const select = $("select");
        const booked = <?=json_encode($booked)?>;
        const slots = ["12", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11"];
        let donow = false;
        let ended = false;
        for (var i = 0; i < slots.length; i++) {
            if (!donow) {
                if ( slots[i] + ":00 AM" === '<?=$spc_data['start']?>') (donow = true); else continue;
            }
            if (donow) {
                if ( (slots[i + 1] ? slots[i + 1] + ":00 AM" : slots[0] + ":00 PM") === '<?=$spc_data['end']?>' ) (ended = true);
            }
            let time1 = slots[i] + ":00 AM - " + slots[i] + ":30 AM";
            let time2 = slots[i] + ":30 AM - " + (slots[i + 1] ? slots[i + 1] + ":00 AM" : slots[0] + ":00 PM");
            select.append($(`<option value="${time1}" ${booked.includes(time1) ? "disabled" : ""}>${time1}</option>`));
            select.append($(`<option value="${time2}" ${booked.includes(time2) ? "disabled" : ""}>${time2}</option>`));
            if (ended) return;
        }
        for (var i = 0; i < slots.length; i++) {
            if (!donow) {
                if ( slots[i] + ":00 PM" === '<?=$spc_data['start']?>') (donow = true); else continue;
            }
            if (donow) {
                if ( (slots[i + 1] ? slots[i + 1] + ":00 PM" : slots[0] + ":00 AM") === '<?=$spc_data['end']?>' ) (ended = true);
            }
            let time1 = slots[i] + ":00 PM - " + slots[i] + ":30 PM";
            let time2 = slots[i] + ":30 PM - " + (slots[i + 1] ? slots[i + 1] + ":00 PM" : slots[0] + ":00 AM");
            select.append($(`<option value="${time1}" ${booked.includes(time1) ? "disabled" : ""}>${time1}</option>`));
            select.append($(`<option value="${time2}" ${booked.includes(time2) ? "disabled" : ""}>${time2}</option>`));
            if (ended) return;
        }
    }());
    $("form").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "/join/check.php",
            type: "post",
            data: $(this).serialize(),
            success( data ) {
                if (data.type === "success") {
                    return window.location.href = "/dashboard/schedules";
                }
                console.log(data);
                if (data.type !== "error") data = {throw:"Unexpected error occured."};
                Propbar(data.throw, {closeButton:true,clickable:true,align:'center'},3000);
            },
        });
    });
</script>
