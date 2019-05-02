<?php

namespace View\Service;


class TaskService
{
    public function getAllLists($accessToken)
    {
        $ht = curl_init();
        $authorization = "X-Access-Token: $accessToken";
        curl_setopt($ht, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json', "X-Client-ID: f56ec31f424a4973102f", $authorization));
        curl_setopt($ht, CURLOPT_URL, 'a.wunderlist.com/api/v1/lists');
        curl_setopt($ht, CURLOPT_RETURNTRANSFER, 1);
        $rest = curl_exec($ht);
        curl_close($ht);

        return json_decode($rest);

    }

    public function getAllTasks($accessToken, $listId)
    {
        $ht = curl_init();
        $authorization = "X-Access-Token: $accessToken";
        curl_setopt($ht, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json', "X-Client-ID: f56ec31f424a4973102f", $authorization));
        curl_setopt($ht, CURLOPT_URL, "a.wunderlist.com/api/v1/tasks?list_id=$listId");
        curl_setopt($ht, CURLOPT_RETURNTRANSFER, 1);
        $rest = curl_exec($ht);
        $responseCode = curl_getinfo($ht, CURLINFO_HTTP_CODE);
        http_response_code($responseCode);
        curl_close($ht);

        return json_decode($rest);
    }

    public function createTask($accessToken,array $listData)
    {
        $postFields = array(
            "list_id" => $listData['list_id'],
            "title" => $listData['title']
        );

        $authorization = "X-Access-Token: $accessToken";
        print_r(http_build_query($postFields));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json', "X-Client-ID: f56ec31f424a4973102f", $authorization));
        curl_setopt($ch, CURLOPT_URL, 'a.wunderlist.com/api/v1/tasks');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postFields));
        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }


    public function updateTask($accessToken,array $listData)
    {
        $id = $listData['id'];

        $postFields = array(
            "revision" => $listData['revision']
        );

        $authorization = "X-Access-Token: $accessToken";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json', "X-Client-ID: f56ec31f424a4973102f", $authorization));
        curl_setopt($ch, CURLOPT_URL, "a.wunderlist.com/api/v1/tasks/$id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postFields));
        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }


    public function deleteTask($accessToken,array $listData)
    {
        $id = $listData['id'];

        $revision = $listData['revision'];

        $authorization = "X-Access-Token: $accessToken";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json', "X-Client-ID: f56ec31f424a4973102f", $authorization));
        curl_setopt($ch, CURLOPT_URL, "a.wunderlist.com/api/v1/tasks/$id?revision=$revision");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    public function getOneTask($accessToken,$taskId)
    {
        $ht = curl_init();
        $authorization = "X-Access-Token: $accessToken";
        curl_setopt($ht, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json', "X-Client-ID: f56ec31f424a4973102f", $authorization));
        curl_setopt($ht, CURLOPT_URL, "a.wunderlist.com/api/v1/tasks/$taskId");
        curl_setopt($ht, CURLOPT_RETURNTRANSFER, 1);
        $rest = curl_exec($ht);
        curl_close($ht);

        return json_decode($rest);
    }

}