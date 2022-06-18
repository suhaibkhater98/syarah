<?php

namespace frontend\components;


use Google\Exception;
use Google_Client;
use Google_Service_Drive;
use Yii;
use yii\base\Component;

class GoogleApi extends Component
{
    /**
     * @throws Exception
     */
    function getClient()
    {
        $client = new Google_Client();
        $client->setAuthConfig(Yii::$app->basePath.'/config/client_secret.json');
        $client->addScope(Google_Service_Drive::DRIVE);
        $client->setRedirectUri('http://localhost/syarah/frontend/web/index.php?r=google-drive%2Foauth');
        $client->setAccessType('offline');
        return $client;
    }

}