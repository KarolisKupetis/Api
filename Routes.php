<?php
\View\RouteGenerator::set('tasks', function () {
    $srv = new \View\controllers\TaskController();

    header('Content-Type: application/json');

    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":

            $response = $srv->getTasks();

            echo json_encode($response);

            break;
        case "POST":

            echo $response = $srv->postTask();

            break;
        case "DELETE":

            echo $response = $srv->deleteTask();

            break;
        case "PATCH":

            echo $srv->patchTask();

            break;
        default:
            http_response_code(404);
    }
});

\View\RouteGenerator::set('optional', function () {

    $_SERVER['HTTP_X_ACCESS_TOKEN']= $_SESSION['X-Access-Token'];
    $srv = new \View\controllers\TaskController();
    $listArray  = $srv->getTasks();

    require ('taskings.html');
});


\View\RouteGenerator::set('home', function () {

    if (!isset($_SESSION['X-Access-Token'])) {
        header('Location:main');
    }

    $new = new \View\AuthorizationController();

    $_SESSION['X-Access-Token'] = $new->getAccessToken();

    header('Location:tasker');

    die();
});

\View\RouteGenerator::set('tasker', function () {

    if (!isset($_SESSION['X-Access-Token'])) {
        header('Location:main');
    }

    $_SERVER['HTTP_X_ACCESS_TOKEN']= $_SESSION['X-Access-Token'];
    $srv = new \View\Service\TaskService();
    $listArray  = $srv->getAllLists();

    require_once('todo.html');

});

\View\RouteGenerator::set('main', function () {
    $new = new \View\AuthorizationController();
    $new->loginToPage();
});

\View\RouteGenerator::set('posttask', function () {

    $postFields = array(
        "list_id" => $_POST['list_id'],
        "title" => $_POST['title'],
    );

    if (!isset($_SESSION['X-Access-Token'])) {
        header('Location:main');
    }

    $_SERVER['HTTP_X_ACCESS_TOKEN']= $_SESSION['X-Access-Token'];
    $service = new \View\Service\TaskService();
    echo $service->createTask($postFields);


    $id = $_POST['list_id'];
    //header("Location: http://127.0.0.1/ToDoList/optional?list_id=$id");

    die();
});





