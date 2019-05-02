<?php

namespace View;


class AuthorizationController
{

    private $client_id = 'f56ec31f424a4973102f';
    private $client_secret = '446510655627581597b9de831c16ff51fa63b0f020c830579bef0e4427ba';
    private $callBack = 'http://127.0.0.1/ToDoList/home';

    public function loginToPage():void
    {
        $str = random_int(10,100);
        $_SESSION['state'] = md5($str);
        $state = $_SESSION['state'];

        header("Location: https://www.wunderlist.com/oauth/authorize?client_id=$this->client_id&redirect_uri=$this->callBack&state=$state");

    }

    public function getAccessToken()
    {
        $this->verifyState();

        $response = $this->sendCodeForToken();

        $authResponse = json_decode($response);

        return $authResponse->access_token;
    }

    private function verifyState():void
    {
        if ($_GET['state'] !== $_SESSION['state']) {
            $ctrl = new AuthorizationController();
            $ctrl->loginToPage();
            die();
        }
    }

    private function sendCodeForToken()
    {
        $code = $_GET['code'];

        $postFields = array(
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret,
            "code" => (string)$code,
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://www.wunderlist.com/oauth/access_token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }
}