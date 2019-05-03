<?php

namespace View\Service;

class TaskService
{
    private $clientId;

    public function __construct()
    {
        $this->clientId = getenv('APP_CLIENT_ID');
    }

    public function getAllLists()
    {
        $ht = curl_init();
        $authorization = "X-Access-Token: " . $_SERVER['HTTP_X_ACCESS_TOKEN'];
        curl_setopt($ht, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json', "X-Client-ID: $this->clientId", $authorization));
        curl_setopt($ht, CURLOPT_URL, 'a.wunderlist.com/api/v1/lists');
        curl_setopt($ht, CURLOPT_RETURNTRANSFER, 1);
        $rest = curl_exec($ht);
        curl_close($ht);

        return json_decode($rest);

    }

    public function getAllTasks($listId)
    {
        $ht = curl_init();
        $authorization = "X-Access-Token: " . $_SERVER['HTTP_X_ACCESS_TOKEN'];
        curl_setopt($ht, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json', "X-Client-ID: $this->clientId", $authorization));
        curl_setopt($ht, CURLOPT_URL, "a.wunderlist.com/api/v1/tasks?list_id=$listId");
        curl_setopt($ht, CURLOPT_RETURNTRANSFER, 1);
        $rest = curl_exec($ht);
        $responseCode = curl_getinfo($ht, CURLINFO_HTTP_CODE);
        http_response_code($responseCode);
        curl_close($ht);

        return json_decode($rest);
    }

    public function createTask($taskData)
    {
        $postFields = array(
            "list_id" => (int)$taskData['list_id'],
            "title" => (string)$taskData['title'],
//            !empty($taskData['completed']) ?: 'completed'=>$taskData['completed'],
//            !isset($taskData['recurrence_type']) ?: "recurrence_type"=>$taskData['recurrence_type'],
//            !isset($taskData['recurrence_count']) ?: "recurrence_count"=>$taskData['recurrence_count'],
//            !isset($taskData['due_date']) ?: "due_date"=>$taskData['due_date'],
//            !isset($taskData['starred']) ? : "starred"=>$taskData['starred']
        );

        echo json_encode($postFields);
        $authorization = "X-Access-Token: " . $_SERVER['HTTP_X_ACCESS_TOKEN'];
        print_r(http_build_query($postFields));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json', "X-Client-ID: $this->clientId", $authorization));
        curl_setopt($ch, CURLOPT_URL, 'a.wunderlist.com/api/v1/tasks');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postFields));
        $response = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        http_response_code($responseCode);
        curl_close($ch);

        return $response;
    }


    public function updateTask($listData)
    {
        $id = $listData['id'];
        $postFields = array(
            "revision" => $listData['revision'],
            !isset($listData['title']) ?: 'title'=>$listData['title'],
            !isset($listData['list_id']) ?: 'list_id'=>$listData['list_id'],
            !isset($listData['completed']) ?: 'completed'=>$listData['completed'],
            !isset($listData['recurrence_type']) ?: "recurrence_type"=>$listData['recurrence_type'],
            !isset($listData['recurrence_count']) ?: "recurrence_count"=>$listData['recurrence_count'],
            !isset($listData['due_date']) ?: "due_date"=>$listData['due_date'],
            !isset($listData['starred']) ? : "starred"=>$listData['starred']
        );

        $authorization = "X-Access-Token: " . $_SERVER['HTTP_X_ACCESS_TOKEN'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json', "X-Client-ID: $this->clientId", $authorization));
        curl_setopt($ch, CURLOPT_URL, "a.wunderlist.com/api/v1/tasks/$id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postFields));
        $response = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        http_response_code($responseCode);
        curl_close($ch);

        return $response;
    }


    public function deleteTask(array $listData)
    {
        $id = $listData['id'];
        $revision = $listData['revision'];

        $authorization = "X-Access-Token: " . $_SERVER['HTTP_X_ACCESS_TOKEN'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json', "X-Client-ID: $this->clientId", $authorization));
        curl_setopt($ch, CURLOPT_URL, "a.wunderlist.com/api/v1/tasks/$id?revision=$revision");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        $response = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        http_response_code($responseCode);
        curl_close($ch);

        return $response;
    }

    public function getOneTask($taskId)
    {
        $ht = curl_init();
        $authorization = "X-Access-Token: " . $_SERVER['HTTP_X_ACCESS_TOKEN'];
        curl_setopt($ht, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json', "X-Client-ID: $this->clientId", $authorization));
        curl_setopt($ht, CURLOPT_URL, "a.wunderlist.com/api/v1/tasks/$taskId");
        curl_setopt($ht, CURLOPT_RETURNTRANSFER, 1);
        $rest = curl_exec($ht);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        http_response_code($responseCode);
        curl_close($ht);

        return json_decode($rest);
    }

}