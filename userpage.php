<?php
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: userpage.php
 * Desc: Userpage page for Projekt
 *
 * Robin Jönsson
 * rojn1700
 * rojn1700@student.miun.se
 ******************************************************************************/
session_start();
$title = "DT161G - Projekt - Användarsida";

if (!isset($_SESSION['logged_in'])) {
    header("Location: index.php"); /* Redirect browser */
    exit;
}
require_once "util.php";
my_autoloader("databas");
$database = new Databas();
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
            if (isset($_SESSION['logged_in'])) {
                echo "<br /><a href='userpage.php'> Userpage</a>";
            }
            $database->queryToDb("SELECT username FROM dt161g_project.members");
            $user = $database->getNextResult();
            while ($user) {
                echo "<br /><a href='images.php?user=" . $user['username'] . "'>" . $user['username'] . "</a>";
                $user = $database->getNextResult();
            }
            ?>
        </div>
    </aside>
    <section class="userPage">
        <form action="upload.php<?php if (isset($_GET['path'])) {
            echo "?path=" . $_GET['path'];
        } ?>" method="post" enctype="multipart/form-data">
            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload" required>
            <input type="text" name="name" id="photoName" placeholder="Name of photo." required>
            <input type="text" name="activeFolder" class="activeFolder" hidden>
            <input type="submit" value="Upload Image" name="submit">
        </form>
        <form action="upload.php<?php if (isset($_GET['path'])) {
            echo "?path=" . $_GET['path'];
        } ?>" method="post" enctype="multipart/form-data">
            <input type="text" name="name" id="folderName" placeholder="Name of new folder." required>
            <input type="text" name="activeFolder" class="activeFolder" hidden>
            <input type="submit" value="Create folder" name="submit">
        </form>
        <p>Navigera till rätt mapp nedan. När du laddar upp en bild eller skapar en ny mapp, kommer det att ske i nedan
            aktiva mapp.</p>
        <div class="imageContainer">
            <?php
            $database->queryToDb("SELECT id FROM dt161g_project.members WHERE username='" . $_SESSION['logged_in'] . "'");
            $user = $database->getNextResult();
            $user_id = $user['id'];
            // Query to get all paths to user
            $database->queryToDb("SELECT dt161g_project.paths.path, dt161g_project.paths.isImage, dt161g_project.paths.name, dt161g_project.paths.parent FROM dt161g_project.user_paths INNER JOIN dt161g_project.paths ON dt161g_project.user_paths.path=dt161g_project.paths.path WHERE dt161g_project.user_paths.member_id='" . $user_id . "'");
            $path = $database->getNextResult();
            $base_dir = "../../writeable/dt161g_project/";
            //Get the current active folder
            if (isset($_GET['path'])) {
                $relative_path = rtrim($base_dir . $_GET['path'] . "/");
            } else {
                $relative_path = $base_dir;
            }
            // Loops through all paths saved to the user
            while ($path) {
                // If the parent path is the current active folder
                if ($path['parent'] == $relative_path) {
                    // Show image
                    if ($path['isimage'] == 't') {
                        echo "<figure><img src='" . $path['path'] . "' alt='uploaded picture' class='image'/>
                  <figcaption>" . $path['name'] . "</figcaption></figure>";
                    } else {
                        // Show folder
                        echo "<p><img src='img/folder-icon.jpg' alt='folder' class='folder'/>
                  " . $path['name'] . "</p>";
                    }
                }
                $path = $database->getNextResult();
            }
            ?>
        </div>
    </section>
</main>

<footer>
    <p>Copyright © 2019 Robin Jönsson</p>
    <a href="mailto:rojn1700@student.miun.se?subject=feedback">Contact me!</a>
</footer>

</body>
</html>



