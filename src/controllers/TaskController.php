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
            return $this->taskService->getAllTasks($_GET['list_id']);
        }
        elseif(is_numeric($lastUrlElement)){

            return $this->taskService->getOneTask($lastUrlElement);
        }
        else
        {
            http_response_code(500);
        }
    }

    public function postTask()
    {
        $json = file_get_contents('php://input');
        $content = json_decode($json,true);
        if(!isset($content['list_id']))
        {
            http_response_code(500);
            return json_encode(array('list_id'=>"missing"));
        }
        if(!isset($content['title']))
        {
            http_response_code(400);
            return json_encode(array('title'=>"missing"));
        }

        return $this->taskService->createTask($content);
    }

    public function patchTask()
    {
        $url = $_GET['url'];
        $keys = parse_url($url);
        $path = explode("/", $keys['path']);
        $lastUrlElement = end($path);

        $json = file_get_contents('php://input');
        $content = json_decode($json,true);

        $content['id'] = $lastUrlElement;
        if(!isset($content['revision']))
        {
            http_response_code(500);
            return json_encode(array('revision'=>"missing"));
        }

        return $this->taskService->updateTask($content);
    }

    public function deleteTask()
    {
        $url = $_GET['url'];
        $keys = parse_url($url);
        $path = explode("/", $keys['path']);
        $lastUrlElement = end($path);

        $content['id'] = $lastUrlElement;
        if(!isset($_GET['revision']))
        {
            http_response_code(500);
            return json_encode(array('revision'=>"missing"));
        }
        $content['revision'] = $_GET['revision'];

        return $this->taskService->deleteTask($content);
    }
}