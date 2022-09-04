<?php
header('Content-Type: application/json; charset=utf-8');
if (!isset($_REQUEST['email']) || empty($_REQUEST['email'])) {
    exit(json_encode(array("type" => "error", "throw" => "Enter your email address.")));
}
if (!isset($_REQUEST['password']) || empty($_REQUEST['password'])) {
    exit(json_encode(array("type" => "error", "throw" => "Enter your password.")));
}

$file = $_SERVER["DOCUMENT_ROOT"] . "/assets/server/users.json";

$data = file_get_contents($file);
$data = json_decode($data, true);

foreach ($data as $key => $value) {
    if ($value["email"] === $_REQUEST['email']) {
        if ($value["password"] === $_REQUEST["password"]) {
            session_start();
            $_SESSION['activeuser'] = $_REQUEST['email'];
            $_SESSION['activeusername'] = $value['name'];
            exit(json_encode(array("type" => "success")));
        }
        exit(json_encode(array("type" => "error", "throw" => "Password doesn't match.")));

    }
}
exit(json_encode(array("type" => "error", "throw" => "Email address doesn't exists.")));
