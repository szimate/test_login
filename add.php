<?php
/**
 * Created by PhpStorm.
 * User: Xan
 * Date: 2018. 08. 29.
 * Time: 21:11
 */
include_once('initialize.php');

//felhasználó hozzáadása
add_user();

include("header.php");
?>

    <h1 class="title">Új Felhasználó hozzáadása</h1>
    <form name="myForm" action="registration.php" onsubmit="return validateForm()" method="post">
        <label>
            Név:
            <input type="text" name="name" placeholder="Feladat Józsi">
        </label>
        <label>
            Jelszó:
            <input type="password" name="pass">
        </label>
        <input class="btn" type="submit" value="Felhasználó hozzáadása!">

    </form>
    <div class="link">
        <a href="edit.php"> Vissza a kezdőlapra!</a>
    </div>

<?php include("footer.php");