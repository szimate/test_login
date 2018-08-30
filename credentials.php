<?php
/**
 * Created by PhpStorm.
 * User: Xan
 * Date: 2018. 08. 27.
 * Time: 16:15
 */

//adatbázis kapcsolódási adatok

define("DB_SERVER", "localhost");
define("DB_USERNAME", "root");
define("DB_PASS", "");
define("DB_NAME", "teszt");
$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASS, DB_NAME);
