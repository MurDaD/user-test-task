<?php
/**
 * Author: MurDaD
 * Author URL: https://github.com/MurDaD
 *
 * Description: Config file, must be included in every script
 */

use includes\Settings;

date_default_timezone_set('Europe/Kiev');
define('DEBUG', true);

if(DEBUG) {
    error_reporting(E_ALL & ~E_NOTICE);
    ini_set("display_errors", 1);
}

// Check if vendor folder exists
if(!file_exists('vendor/autoload.php')) die ('Please, run \'composer install\' from root dir');

include 'includes/DB.php';
include 'vendor/autoload.php';
include 'app/Model.php';
include 'app/Users.php';

// Config DB here
Settings::set('db_host',        'localhost');
Settings::set('db_database',    'users-test');
Settings::set('db_user',        'users-test');
Settings::set('db_password',    'qwert123');


