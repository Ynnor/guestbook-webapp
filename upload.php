<?php
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: upload.php
 * Desc: Upload file for Projekt
 *
 * Robin Jönsson
 * rojn1700
 * rojn1700@student.miun.se
 ******************************************************************************/
session_start();
require_once "util.php";
my_autoloader("databas");
$database = new Databas();

// Get current active folder
$base_dir = "../../writeable/dt161g_project/";
if (isset($_GET['path'])) {
    $target_dir = rtrim($base_dir . $_GET['path'] . "/");
} else {
    $target_dir = $base_dir;
}

// Set a unique filename for saving on server.
$target_fileName = time();
$target_file = $target_dir . $target_fileName;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// If the submitted form is the Upload image
if ($_POST['submit'] == "Upload Image") {
    // If upload is succesful
    if (copy($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
        // Insert image in database
        $database->queryToDb("INSERT INTO dt161g_project.paths (path,isImage,parent,name) VALUES ('" . $target_file . "','true','" . $target_dir . "','" . $_POST['name'] . "')");
        $database->queryToDb("SELECT id FROM dt161g_project.members WHERE username = '" . $_SESSION['logged_in'] . "'");
        $user = $database->getNextResult();
        $user_id = $user['id'];
        $database->queryToDb("INSERT INTO dt161g_project.user_paths (member_id, path) VALUES ('" . $user_id . "','" . $target_file . "')");
        header("Location: userpage.php");
    } else {
        // If upload fails
        echo "Sorry, there was an error uploading your file.";
        echo "<br /> <a href='userpage.php'>Return</a>";
    }
} else {
    // Else it is the create folder
    // If folder does not exist, create it.
    if (!file_exists($target_dir . $_POST['name'])) {
        mkdir($target_dir . $_POST['name'], 0777, true);
    }
    // Insert folder to database
    $database->queryToDb("INSERT INTO dt161g_project.paths (path,isImage,parent,name) VALUES ('" . $target_dir . $_POST['name'] . "/','false','" . $target_dir . "','" . $_POST['name'] . "')");
    $database->queryToDb("SELECT id FROM dt161g_project.members WHERE username = '" . $_SESSION['logged_in'] . "'");
    $user = $database->getNextResult();
    $user_id = $user['id'];
    $database->queryToDb("INSERT INTO dt161g_project.user_paths (member_id, path) VALUES ('" . $user_id . "','" . $target_dir . $_POST['name'] . "/')");
    echo "Folder created.";
    header("Location: userpage.php");
}

?>