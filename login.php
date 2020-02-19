<?PHP
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: login.php
 * Desc: Login page for Projekt
 *
 * Robin Jönsson
 * rojn1700
 * rojn1700@student.miun.se
 ******************************************************************************/
session_start();
require_once "util.php";
my_autoloader("databas");
$database = new Databas();

// Query for a user with entered username
$database->queryToDb("SELECT * FROM dt161g.member WHERE username = '" . $_SERVER['HTTP_UNAME'] . "'");
$user = $database->getNextResult();

// If a user with username entered is found
if ($user) {
    // Check if password is correct
    if ($user['password'] == $_SERVER['HTTP_PWD']) {
        $_SESSION['logged_in'] = $_SERVER['HTTP_UNAME'];
        $response['logged_in'] = true;
    } else {
        // Else fail login
        $response['responseText'] = "You entered the wrong password. Try again.";
        $response['logged_in'] = false;
    }
} else {
    // Else create new user and log in
    $response['responseText'] = "A user with username " . $_SERVER['HTTP_UNAME'] . " has been registered and logged in.";
    $response['logged_in'] = true;
    $_SESSION['logged_in'] = $_SERVER['HTTP_UNAME'];
    $database->queryToDb("INSERT INTO dt161g_project.members (username, password) VALUES ('" . $_SERVER['HTTP_UNAME'] . "','" . $_SERVER['HTTP_PWD'] . "')");
}

header('Content-Type: application/json');
echo json_encode($response);

?>