<?php
\View\RouteGenerator::set('tasks', function ()
{
    $srv = new \View\controllers\TaskController();

    header('Content-Type: application/json');

    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            $response = $srv->getTasks();
            break;
        case "POST":
            http_response_code(201);
            echo json_encode(array('arr'=>'weeeaaaaaa'));
            break;
        case "DELETE":
            echo json_encode(array('arr'=>'WORKS'));
            break;
        case "PATCH":
            echo json_encode(array('arr'=>'PATCH'));
            break;
        default:
            http_response_code(501);
    }
});

\View\RouteGenerator::set('home',function (){
    $service = new \View\Service\TaskService();
    $new = new \View\AuthorizationController();
    $_SESSION['token'] = $new->getAccessToken();
    echo json_encode($service->getAllTasks($_SESSION['token'],392321367));
    header('Location: todo.html');
});


\View\RouteGenerator::set('html',function (){
   require_once ('todo.html');
});



\View\RouteGenerator::set('main',function (){
    $new = new \View\AuthorizationController();
    $new->loginToPage();
});
