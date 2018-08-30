<?php
/**
 * Created by PhpStorm.
 * User: Xan
 * Date: 2018. 08. 28.
 * Time: 15:24
 */

//csatlakozás az adatbázishoz
function db_connect()
{
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASS, DB_NAME);
    mysqli_set_charset($connection, "utf8");

    confirm_db_connect();
    return $connection;
}

//ellenörzi a kpacsolatot és kiírja a hibát/számát
function confirm_db_connect()
{
    if (mysqli_connect_errno()) {
        $msg = "Database connection failed: ";
        $msg .= mysqli_connect_error();
        $msg .= " (" . mysqli_connect_errno() . ")";
        exit($msg);
    }
}

//oldalak közötti átirányítás
function redirect_to($location)
{
    header("Location: " . $location);
    exit;
}

// post metódus ellenőrzése
function is_post_request()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

// spexiális karakterek kivédése
function h($string = "")
{
    return htmlspecialchars($string);
}

// üres mező ellenőrzése
function is_blank($value)
{
    return !isset($value) || trim($value) === '';
}

//felhasználó hozzáadása
function insert_users($user)
{
    global $db;

    $hashed_password = password_hash($user['pass'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO felhasznalok (name, pass, login_date) VALUES (";
    $sql .= "'" . db_escape($db, $user['name']) . "',";
    $sql .= "'" . db_escape($db, $hashed_password) . "',";
    $sql .= "'" . h(date("Y-m-d H:i:sa")) . "'";
    $sql .= ")";

    $result = mysqli_query($db, $sql);
    if ($result) {
        return true;
    } else {
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// felhasználók keresése felhasználónév alapján
function find_user_by_username($username)
{
    global $db;

    $select = "SELECT * FROM felhasznalok WHERE name='";
    $limit = "'LIMIT 1";

    $sql = $select . db_escape($db, $username) . $limit;

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $username = mysqli_fetch_assoc($result);
    //erőforrások felszabadítása
    mysqli_free_result($result);
    return $username;
}

//kapcsolat megszakítása a munkafolyamat végén
function db_disconnect($connection)
{
    if (isset($connection)) {
        mysqli_close($connection);
    }
}

//sql injection megelőzése
function db_escape($connection, $string)
{
    return mysqli_real_escape_string($connection, $string);
}

//guerry eredmények ellenőrzése
function confirm_result_set($result_set)
{
    if (!$result_set) {
        exit("Adatbázis lekérdezés hibás.");
    }
}

// a session generálása megelőzi az oldalra való illetéktelen hozzáférést
function log_in_user($user)
{
    session_regenerate_id();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['last_login'] = time();
    $_SESSION['username'] = $user['name'];
    return true;
}

// belépés szükséges az oldalhoz
function require_login_user()
{
    if (!is_log_in_user()) {
        redirect_to('index.php');
    }
}

// session ellenőrzése
function is_log_in_user()
{
    return isset($_SESSION['user_id']);
}

// felhasználó kijelentkezése, session törlése
function log_out_user()
{
    unset($_SESSION['user_id']);
    unset($_SESSION['last_login']);
    unset($_SESSION['username']);
    return true;
}

// az összes felhasználó megtalálása
function find_all_users()
{
    global $db;

    $sql = "SELECT * FROM felhasznalok ORDER BY name ASC";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

// felhasználó hozzáadása
function add_user()
{

    if (is_post_request()) {

        $user['name'] = $_POST['name'] ?? '';
        $user['pass'] = $_POST['pass'] ?? '';

        $result = insert_users($user);
        if ($result === true) {
            if(isset($_SESSION['user_id'])) {
                redirect_to("edit.php");

            }
            else {
                redirect_to("index.php");
            }
        }

    } else {
        // az üres form mutatása
        $user = [];
        $user["name"] = '';
        $user['pass'] = '';
    }
}

// felhasználó belépését követően időbélyeg frissítése
function update_user($user)
{
    global $db;

    $update = "UPDATE felhasznalok SET login_date=' ";
    $where = "' WHERE id= '";
    $limit = "' LIMIT 1";

    $sql = $update . h(date('Y-m-d H:i:sa')) . $where . db_escape($db, $user['id']) . $limit;
    $result = mysqli_query($db, $sql);

    if ($result) {
        return true;
    } else {
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

//felhasználó id keresése
function find_user_by_id($id)
{
    global $db;

    $select = "SELECT * FROM felhasznalok WHERE id=' ";
    $limit = "' LIMIT 1";

    $sql = $select . db_escape($db, $id) . $limit;

    $result = mysqli_query($db, $sql);
    //eredmények ellenőrzése
    confirm_result_set($result);
    $user = mysqli_fetch_assoc($result);
    //erőforrások felszabadítása
    mysqli_free_result($result);
    return $user;
}