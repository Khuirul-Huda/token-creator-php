<?php 
include './config.php';
include './db.php';

$manager = new Database();

function responseMsg(String $action ,String $service, String $expire, String $token) {
    $arr = array();
    $arr['action'] = $action;
    $arr['service'] = $service;
    $arr['expire'] = $expire;
    $arr['token'] = $token;
    return json_encode($arr);
}

function failedMessage($msg) {
    return responseMsg('failed', $msg, $msg, $msg);
}

//token Info
if ($_SERVER['REQUEST_METHOD'] == 'GET' && array_key_exists('token', $_GET)) {
    $tokenInfo = $manager->getTokenInfo($_GET['token']);
    
        $res = ($tokenInfo ? responseMsg('request' ,$tokenInfo['service'], $tokenInfo['expire'], $tokenInfo['token']) : failedMessage('Token not found'));
    
    echo($res);
} 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && array_key_exists('token', $_POST)) {
    $res = ($manager->deleteToken($_POST['token']) ? responseMsg('delete', 'deleted', 'deleted', $_POST['token']) : failedMessage('failed') );
}