<?php
include($_SERVER['DOCUMENT_ROOT'] . "/assets/sessions.php");
if (!$activeSession) {
    header("Location:/");
}
$file = $_SERVER["DOCUMENT_ROOT"] . "/assets/server/events.json";
$data = file_get_contents($file);
$data = json_decode($data, true);

$mymeets = array();

foreach ($data as $key => $value) {
    if ($value["user"] === $activeUser && $value["status"] === "true") {
        array_push($mymeets, $value);
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Manage Events | CPR</title>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="/assets/css/styles.css">

        <script src="/assets/framework/fontawesome.all.min.js"></script>
        <script src="/assets/framework/jquery.min.js"></script>
    </head>
    <body>
        <div class="restrict">
            <div class="header">
                <div class="header_banner">
                    <img src="/assets/images/cpr-logo.png" alt="">
                </div>
                <div class="header_account_m">
                    <div class="header_account_name"><div style="font-weight: 600;"><?=$activeUserName?></div><?=$activeUser?></div>
                    <a href="/logout">Logout &nbsp; <i class="fas fa-right-from-bracket"></i></a>
                </div>
            </div>
        </div>
        <div class="dashboard">
            <div class="restrict">
                <div class="dashboard_header">
                    <a href="/dashboard" class="active">Manage Events</a>
                    <a href="/dashboard/schedules">Scheduled Events</a>
                    <a href="/dashboard/bookings">Booked Events</a>
                </div>
            </div>
        </div>
        <div class="restrict">
            <div class="eventtags">
                <div class="eventtags_add">
                    <a href="/dashboard/create"><i class="fas fa-plus"></i> Create new slot</a>
                </div>
                <div class="events"></div>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript">
    (function() {
        'use strict';
        const meets = <?=json_encode($mymeets)?>.reverse();
        const log = $(".events");
        if ( !meets.length ) {
            return log.append($("<div class='error'>No meeting Scheduled yet!</div>"));
        }
        for (var meet of meets) {
            log.append(
                $(`<div class="et_box"></div>`).append(
                    $(`<div class="et_row"></div>`).append(
                        $(`<a href="/${meet.path}/${meet.token}" class="et_name">${meet.name}</a>`),
                        $(`<a href="/dashboard/action.delete/?token=${meet.token}" class="et_del"><i class='far fa-trash'></i></a>`),
                    ),
                    $(`<div class="et_row"></div>`).append(
                        $(`<div class="et_desc">Date: <span>${meet.date.split("-").reverse().join("-")}</span><br>Time slot: <span>${meet.start} to ${meet.end}</span></div>`),
                        $(`<a href="/${meet.path}/${meet.token}" class="et_share"><i class='far fa-share-nodes'></i></a>`),
                    ),
                )
            );
        }
    }());
</script>
