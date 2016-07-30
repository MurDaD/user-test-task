<?php
use Faker\Factory;
use includes\DB;
/**
 * Author: MurDaD
 * Author URL: https://github.com/MurDaD
 *
 * Description: Creates and inserts faked users into DB
 * It takes up to a minute to insert 500 users
 * Using: fzaninotto/faker, mysqli, Prepared statements
 */
include 'config.php';
set_time_limit ( 600 );     // increase time limit to 5 minutes

// Settings
$_users = [];               // Users array
$_usersNum = 1000;           // User number to generate
$sqlInsert = "INSERT INTO users (username, password, country, first_name, last_name, zip_code, created) VALUES
              (?, ?, ?, ?, ?, ?, FROM_UNIXTIME(?))";

// Faker
$faker = Factory::create();
$mysqli = DB::getInstance()->getConnection();

for($i = 0; $i <= $_usersNum; $i++) {
        $_users[$i]['username']   = $faker->userName;
        $_users[$i]['password']   = password_hash($faker->password(), PASSWORD_BCRYPT);
        $_users[$i]['country']    = $faker->randomElement($array = array ('Hungary', 'Germany', 'France', 'Russia', 'Ukraine',
                                    'Bulgaria', 'Austria'));
        $_users[$i]['firstName']  = $faker->firstName;
        $_users[$i]['lastName']   = $faker->lastName;
        $_users[$i]['zip']        = $faker->postcode;
        $_users[$i]['created']    = $faker->unixTime();
}

if ($stmt = $mysqli->prepare($sqlInsert)) {
    $stmt->bind_param("ssssssi", $username, $password, $country, $firstName, $lastName, $zip, $created);
}

$mysqli->query("START TRANSACTION");
foreach ($_users as $u) {
    foreach ($u as $key => $val) {
        ${$key} = $val;
    }
    $stmt->execute();
}
$stmt->close();
$mysqli->query("COMMIT");
