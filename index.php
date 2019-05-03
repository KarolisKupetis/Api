<?php
session_start();
require 'vendor/autoload.php';
$dotenv = \Dotenv\Dotenv::create(__DIR__);
$dotenv->load();
require ('Routes.php');




