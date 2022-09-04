<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
if (!isset($_REQUEST['meetname']) || empty($_REQUEST['meetname'])) {
    exit(json_encode(array("type" => "error", "throw" => "Enter meeting name.")));
}
if (!isset($_REQUEST['meetdate']) || empty($_REQUEST['meetdate'])) {
    exit(json_encode(array("type" => "error", "throw" => "Choose meeting date.")));
}
if (!isset($_REQUEST['meetstart']) || empty($_REQUEST['meetstart'])) {
    exit(json_encode(array("type" => "error", "throw" => "Select meeting start time.")));
}
if (!isset($_REQUEST['meetend']) || empty($_REQUEST['meetend'])) {
    exit(json_encode(array("type" => "error", "throw" => "Select meeting end time.")));
}

$file = $_SERVER["DOCUMENT_ROOT"] . "/assets/server/events.json";

function gen_token($string='')
{
    $string = str_replace(array('[\', \']'), '', $string);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
    $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
    $string = (strlen($string) > 250) ? substr($string, 0, 250) : $string;
    return strtolower(trim($string, '-'));
}

function make_file($path = '', $file = '', $user = '')
{
    $dir = $_SERVER['DOCUMENT_ROOT'] . "/" . $path;
    if (!is_dir($dir)) {
      mkdir($dir, 0755, true);
      $fopen = fopen($dir . "/index.php", 'w');
      $write = '<?php header("Location: /dashboard");';
      fwrite($fopen, $write);
      fclose($fopen);
    }

    $dir = $dir . "/" . $file;
    if (!is_dir($dir)) {
      mkdir($dir, 0755, true);
    }
    $fopen = fopen($dir . "/index.php", 'w');
    $write = '<?php $spc_user = "' . $user . '"; $spc_path = "' . $path . '"; $spc_token = "' . $file . '"; include($_SERVER["DOCUMENT_ROOT"] . "/assets/server/tokens.php");';
    fwrite($fopen, $write);
    fclose($fopen);
}

$data = file_get_contents($file);
$data = json_decode($data, true);
$token = gen_token($_REQUEST['meetname']) . '--' . mt_rand(100, 999);
$userq = gen_token($_SESSION['activeuser']);

array_push($data, array('token' => $token, 'alias' => $_SESSION['activeusername'], 'user' => $_SESSION['activeuser'], 'path' => $userq, 'name' => $_REQUEST['meetname'], 'date' => $_REQUEST['meetdate'], 'start' => $_REQUEST['meetstart'], 'end' => $_REQUEST['meetend'], 'status' => "true"));

file_put_contents($file, json_encode($data));

make_file( $userq, $token, $_SESSION['activeuser']);

exit(json_encode(array("type" => "success")));
