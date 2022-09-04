<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
if (!isset($_REQUEST['name']) || empty($_REQUEST['name'])) {
    exit(json_encode(array("type" => "error", "throw" => "Enter your full name.")));
}
if (!isset($_REQUEST['email']) || empty($_REQUEST['email'])) {
    exit(json_encode(array("type" => "error", "throw" => "Enter you email.")));
}
if (!isset($_REQUEST['slot']) || empty($_REQUEST['slot'])) {
    exit(json_encode(array("type" => "error", "throw" => "Select meeting slot.")));
}
if (!isset($_REQUEST['token']) || empty($_REQUEST['token'])) {
    exit(json_encode(array("type" => "error", "throw" => "Erro fetching token.")));
}
if (!isset($_REQUEST['user']) || empty($_REQUEST['user'])) {
    exit(json_encode(array("type" => "error", "throw" => "Error fetching user.")));
}

$file = $_SERVER["DOCUMENT_ROOT"] . "/assets/server/bookings.json";


$data = file_get_contents($file);
$data = json_decode($data, true);

array_push($data, array('token' => $_REQUEST['token'], 'user' => $_REQUEST['user'], 'name' => $_REQUEST['name'], 'email' => $_REQUEST['email'], 'slot' => $_REQUEST['slot'], 'status' => "true"));

file_put_contents($file, json_encode($data));

exit(json_encode(array("type" => "success")));
