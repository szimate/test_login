<?php
/**
 * Created by PhpStorm.
 * User: Xan
 * Date: 2018. 08. 29.
 * Time: 11:20
 */
require_once('initialize.php');

// id lekérdezése
$id = $_SESSION['user_id'];
$user = find_user_by_id($id);

// felhasználó ellenőrzése
require_login_user();
//bejelentkezés időbélyegének frissítése
update_user($user);
// felhasználók megkeresése
$users_set = find_all_users(); //

include('header.php');

?>
    <h1 class="title">
        Üdvözlöm <?php echo $user['name']; ?> !
    </h1>

    <div class="link">
        <a href="<?php echo 'add.php'; ?>">Felhasználó hozzáadása</a>
    </div>

    <table class="list">
        <tr>
            <th>#</th>
            <th>Felhasználónév</th>
            <th>Utolsó bejelentkezés</th>
        </tr>

        <?php
        while ($user = mysqli_fetch_assoc($users_set)) { ?>
            <tr>
                <td><?php echo h($user['id']); ?></td>
                <td><?php echo h($user['name']); ?></td>
                <td><?php echo h($user['login_date']); ?></td>
            </tr>
        <?php } ?>
    </table>
<div class="link">
    <a href="log_out.php">
        Kijelentkezés!
    </a>
</div>
<?php

//felszabadítja a memóriát
mysqli_free_result($users_set);

include('footer.php');

