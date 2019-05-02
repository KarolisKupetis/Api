<?php

require 'vendor/autoload.php';
$contr = new \View\AuthorizationController();
$srv = new \View\Service\TaskService();

$token = $contr->getAccessToken();

//$re = $srv->getAllTasks($_SERVER['HTTP_ACCESS'],392321367);

//$re = $srv->createTask($token,array('list_id'=>392321367,'title'=>'mama'));

$re =$srv->getAllTasks($token,392274897);
echo $token;

//$re = $srv->getAllLists($token);


print_r($re);
