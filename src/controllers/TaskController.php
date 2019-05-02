<?php

namespace View\controllers;

use View\Service\TaskService;

class TaskController
{
    private $taskService;

    public function __construct()
    {
        $this->taskService = new TaskService();
    }

    public function getTasks()
    {
        $url = $_GET['url'];
        $keys = parse_url($url);
        $path = explode("/", $keys['path']);
        $lastUrlElement = end($path);

        if (isset($_GET['list_id']))
        {
            $re = $this->taskService->getAllTasks($_SERVER['HTTP_ACCESS'],$_GET['list_id']);
            echo json_encode($re);
            return $re;
        }
        elseif(is_numeric($lastUrlElement)){
            http_response_code(200);

            echo json_encode(array('arr'=>$lastUrlElement));
        }
        else
        {
            http_response_code(404);
        }

        return null;
    }

    public function postTasks()
    {

    }
}