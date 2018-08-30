<?php
/**
 * Created by PhpStorm.
 * User: Xan
 * Date: 2018. 08. 27.
 * Time: 16:35
 */

include_once('initialize.php');

$errors = '';
$username = '';
$pass = '';

// ha a submit post metódussal történ...
if (is_post_request()) {

    $username = $_POST['name'] ?? '';
    $pass = $_POST['pass'] ?? '';

    $user = find_user_by_username($username);
    if ($user) {
        if (password_verify($pass, $user['pass'])) {
            // password matches
            log_in_user($user);
            redirect_to('edit.php');
        } else {
            $errors = "Felhasználónév vagy jelszó nem megfelelő!";
        }

    } else {
        $errors = "Felhasználónév vagy jelszó nem megfelelő!";
    }
}

include('header.php'); ?>

    <h1 class="title">Bejelentkezés</h1>
    <h3 class="error">
        <?php echo $errors; ?>
    </h3>
    <form name="myForm" action="index.php" onsubmit="return validateForm()" method="post">
        <label>
            Név:
            <input type="text" name="name" placeholder="Feladat Józsi">
        </label>
        <label>
            Jelszó:
            <input type="password" name="pass">
        </label>
        <input class="btn" type="submit" value="Bejelentkezés">

    </form>
    <div class="link">
        <a href="registration.php">Regisztáció</a>
    </div>

<?php
include('footer.php');