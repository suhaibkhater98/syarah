<?php

namespace frontend\controllers;

use Google\Exception;
use Google_Exception;
use GuzzleHttp\Exception\GuzzleException;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\Controller;

class GoogleDriveController extends Controller{

    /**
     * @throws Google_Exception
     * @throws GuzzleException
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function actionIndex(){

        if(Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $client = Yii::$app->get('GoogleApi')->getClient();

        if(!Yii::$app->session->get('access_token')){
            $auth_url = $client->createAuthUrl();
            return $this->redirect($auth_url);
        }

        $access_token = Yii::$app->session->get('access_token');
        $client->setAccessToken($access_token);
        if ($client->isAccessTokenExpired() === true) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            $access_token = $client->getAccessToken();
            Yii::$app->session->set('access_token' , $access_token);
        }
        $drive_api_url = "https://www.googleapis.com/drive/v2/files";
        $httpClient = $client->authorize();
        $data = [];
        try{
            $response = $httpClient->request('get' , $drive_api_url);
            $data = json_decode($response->getBody(), true);
        } catch (Exception $e){
            Yii::$app->session->setFlash("An error occurred while fetching data: " . $e->getMessage());
        }
        return $this->render('index', [
            'data' => $data,
        ]);
    }

    public function actionOauth() {
        if(Yii::$app->user->isGuest || Yii::$app->session->get('access_token')) {
            return $this->goHome();
        }
        $client = Yii::$app->get('GoogleApi')->getClient();
        if (!Yii::$app->request->get('code')){
            $auth_url = $client->createAuthUrl();
            return $this->redirect($auth_url);
        } else {
            $client->fetchAccessTokenWithAuthCode(Yii::$app->request->get('code'));
            Yii::$app->session->set('access_token' , $client->getAccessToken());
            $this->redirect(['google-drive/index']);
        }
    }

}