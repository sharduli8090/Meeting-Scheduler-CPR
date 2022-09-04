<?php
$activeSession = false;
session_start();
date_default_timezone_set("Asia/Calcutta");
if (isset($_SESSION['activeuser']) && !empty($_SESSION["activeuser"])) {
    $activeSession = true;
    $activeUser = $_SESSION["activeuser"];
    $activeUserName = $_SESSION["activeusername"];
}
