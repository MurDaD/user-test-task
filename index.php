<?php
/**
 * Author: MurDaD
 * Author URL: https://github.com/MurDaD
 *
 * Description: Index file of the user task project.
 */
use includes\DB;
use app\Users;

include 'config.php';

$user = new Users(1);
$user->username = 'Murlock';
$user->save();

DB::getInstance()->close();