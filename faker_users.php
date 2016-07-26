<?php
/**
 * Author: MurDaD
 * Author URL: https://github.com/MurDaD
 *
 * Description: Creates and inserts faked users into DB
 * Using: fzaninotto/faker, mysqli, Prepared statements
 */

// Check if vendor folder exists
if(!file_exists('vendor/autoload.php')) die ('Please, run \'composer install\' from root dir');

require_once 'vendor/autoload.php';

// Settings
$_usersNum = 10;        // User number to generate
$_users = [];           // Our users array

// Faker
$faker = Faker\Factory::create();

for($i = 0; $i < $_usersNum; $i++) {
    $_users[] = [

    ];
}

echo '<pre>';
var_dump($_users);