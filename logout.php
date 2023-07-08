<?php
include './config.php';
$config = new Config();
session_start();

if ($_SESSION['adminauth'] == $config->sessionAuthValue) {
    session_unset();
    session_destroy();
    header('Location: login.php');
} else {
    header('Location: index.php');
}