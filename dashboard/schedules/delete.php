<?php
include($_SERVER['DOCUMENT_ROOT'] . "/assets/sessions.php");
if (!$activeSession) {
    header("Location:/");
}
if (!isset($_REQUEST['token']) || empty($_REQUEST['token'])) {
    header("Location:/dashboard/schedules");
}
$file = $_SERVER["DOCUMENT_ROOT"] . "/assets/server/bookings.json";
$data = file_get_contents($file);
$data = json_decode($data, true);

$array = array();
foreach ($data as $key => $value) {
    if ($value["token"] === $_REQUEST['token'] && $value['user'] === $activeUser && $value["status"] === "true") {
        $value['status'] = "false";
    }
    //array_push($array, $value);
}
file_put_contents($file, json_encode($array));
header("Location:/dashboard/schedules");
