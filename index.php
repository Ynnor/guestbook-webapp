<?PHP
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: index.php
 * Desc: Start page for Projekt
 *
 * Robin Jönsson
 * rojn1700
 * rojn1700@student.miun.se
 ******************************************************************************/
session_start();
require_once "util.php";
my_autoloader("databas");
$database = new Databas();
$title = "DT161G - Projekt";

/*******************************************************************************
 * HTML section starts here
 ******************************************************************************/
?>
<!DOCTYPE html>
<html lang="sv-SE">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="css/style.css"/>
    <script src="js/main.js"></script>
</head>
<body>

<header>
    <h1><?php echo $title ?></h1>
    <div class="userContainer">
        <div id="login" <?php if (isset($_SESSION['logged_in'])) {
            echo "class=hidden";
        } ?>>
            <h2>LOGIN</h2>
            <form id="loginForm">
                <label><b>Username</b></label>
                <input type="text" placeholder="m" name="uname" id="uname"
                       required maxlength="10" value="m" autocomplete="off">
                <label><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" id="psw"
                       required>
                <button type="button" id="loginButton">Login</button>
            </form>
        </div>
        <div id="logout" <?php if (!isset($_SESSION['logged_in'])) {
            echo "class=hidden";
        } ?>>
            <h2>LOGOUT</h2>
            <button type="button" id="logoutButton">Logout</button>
        </div>
    </div>
</header>
<main>
    <aside>
        <div class="navbar" id="navbar">
            <a href="index.php">Home</a>
            <?php
            // Show userpage if logged in
            if (isset($_SESSION['logged_in'])) {
                echo "<br /><a href='userpage.php'> Userpage</a>";
            }
            $database->queryToDb("SELECT username FROM dt161g_project.members");
            $user = $database->getnextResult();
            // Loop through and show links to all users.
            while ($user) {
                echo "<br /><a href='images.php?user=" . $user['username'] . "'>" . $user['username'] . "</a>";
                $user = $database->getnextResult();
            }
            ?>
        </div>
    </aside>
    <section>
        <div class="presentation">
            <h2>Instruktioner</h2>
            <p>Du kan logga in eller registrera en användare genom att ange det överst på sidan, och klicka på
                login/register.</p>
            <p>Om användarnamnet inte finns, så skapas en användare med lösenordet du angav.</p>
            <p>När du är inloggad, får du tillgång till din användarsida, där du kan ladda upp bilder.</p>
            <p>För att se andra användares bilder, klickar du på deras användarnamn till vänster på sidan.</p>
        </div>
    </section>
</main>

<footer>
    <p>Copyright © 2019 Robin Jönsson</p>
    <a href="mailto:rojn1700@student.miun.se?subject=feedback">Contact me!</a>
</footer>

</body>
</html>
