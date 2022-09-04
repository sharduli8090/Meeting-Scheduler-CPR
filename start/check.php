<?php
header('Content-Type: application/json; charset=utf-8');
if (!isset($_REQUEST['name']) || empty($_REQUEST['name'])) {
    exit(json_encode(array("type" => "error", "throw" => "Enter your full name.")));
}
if (!isset($_REQUEST['email']) || empty($_REQUEST['email'])) {
    exit(json_encode(array("type" => "error", "throw" => "Enter your email address.")));
}
if (!isset($_REQUEST['password']) || empty($_REQUEST['password'])) {
    exit(json_encode(array("type" => "error", "throw" => "Create your new password.")));
}

$file = $_SERVER["DOCUMENT_ROOT"] . "/assets/server/users.json";

$data = file_get_contents($file);
$data = json_decode($data, true);

foreach ($data as $key => $value) {
    if ($value["email"] === $_REQUEST['email']) {
        exit(json_encode(array("type" => "error", "throw" => "Email address already exists.")));
    }
}

array_push($data, array('name' => $_REQUEST['name'], 'email' => $_REQUEST['email'], 'password' => $_REQUEST['password']));

file_put_contents($file, json_encode($data));

session_start();

$_SESSION['activeusername'] = $_REQUEST['name'];
$_SESSION['activeuser'] = $_REQUEST['email'];

exit(json_encode(array("type" => "success")));
