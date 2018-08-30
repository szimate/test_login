<?php
/**
 * Created by PhpStorm.
 * User: Xan
 * Date: 2018. 08. 29.
 * Time: 9:58
 */

ob_start();
//session indítása
session_start();

require_once('credentials.php');
require_once('methods.php');

$db = db_connect();
$errors = [];
