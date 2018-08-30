<?php
/**
 * Created by PhpStorm.
 * User: Xan
 * Date: 2018. 08. 27.
 * Time: 16:51
 */

include_once('initialize.php');

//új felhasználó hozzáadása
add_user();

include('header.php'); ?>

<h1 class="title">Regisztráció</h1>
<form name="myForm" action="registration.php" onsubmit="return validateForm()" method="post">
    <label>
        Név:
        <input type="text" name="name" placeholder="Feladat Józsi">
    </label>
    <label>
        Jelszó:
        <input type="password" name="pass">
    </label>
    <input class="btn" type="submit" value="Regisztráció">

</form>

<div class="link">
    <a href="index.php"> Vissza a bejelentkezéshez</a>
</div>

<?php include('footer.php'); ?>

