<?php
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: util.php
 * Desc: Util file for Projekt
 *
 * Robin Jönsson
 * rojn1700
 * rojn1700@student.miun.se
 ******************************************************************************/

function my_autoloader($class)
{
    $classfilename = strtolower($class);
    include 'classes/' . $classfilename . '.class.php';
}

spl_autoload_register('my_autoloader');

/*******************************************************************************
 * set debug true/false to change php.ini
 * To get more debug information when developing set to true,
 * for production set to false
 ******************************************************************************/
$debug = false;

if ($debug) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}

?>
