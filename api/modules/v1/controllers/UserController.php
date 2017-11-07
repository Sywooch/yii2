<?php

namespace api\modules\v1\controllers;

use yii;
use common\models\User;
use api\controllers\RangerController;
use api\components\RangerInterface;
use api\components\RangerException;

class UserController extends RangerController implements RangerInterface
{
    public $user;
    public function init()
    {
        $params = yii::$app->request->post('params');
        if(yii::$app->request->post('method') != 'ranger.user.login'){
            $this->user = parent::checkAccessToken(['query'=>$params]);
        }
        parent::init();
    }

    public function actionLogin(array $params)
    {
        $username = '';
        if(isset($params['query']['username'])) {
            $username = $params['query']['username'];
        }else if(isset($params['query']['mobile'])){
            $username = $params['query']['mobile'];
        }else if(isset($params['query']['email'])){
            $username = $params['query']['email'];
        }
        if(!$username){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS,'username or mobile or email');
        }
        $user = \api\models\User::find()->where(['username'=>$username])->orWhere(['mobile'=>$username])->orWhere(['email'=>$username])->one();
        if(!$user){
            RangerException::throwException(RangerException::APP_EMPTY_RECORD);
        }

        $password = isset($params['query']['password'])?$params['query']['password']:'';
        if(!$password){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS,'password');
        }
        if(!Yii::$app->getSecurity()->validatePassword($password, $user->password_hash)){
            RangerException::throwException(RangerException::APP_ERROR_PASSWORD);
        }
        $accessToken = Yii::$app->security->generateRandomString();
        $duration = 3600*24*14;
        Yii::$app->cache->set($accessToken, $user->id, $duration);
        Yii::$app->user->login($user, $duration);
        $result = $user->attributes;
        $result['created_at'] = date('Y-m-d H:i:s',$result['created_at']);
        $result['updated_at'] = date('Y-m-d H:i:s',$result['updated_at']);
        $result['avatar'] = $user->picture_id > 0? User::findOne($user->id)->picture->path:'';
        unset($result['auth_key'], $result['password_hash'], $result['password_reset_token']);
        $result['access_token'] = $accessToken;
        return $result;
    }

    public function actionList(array $params)
    {
        $query = parent::generationQuery(\common\models\User::class,$params);
        try {
            $models = $query->orderBy(['id' => SORT_DESC])->all();
        }catch(\yii\db\Exception $e){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS,$e->getMessage());
        }
        if(!empty($models)) {
            $list = array_map(function ($model) {
                $record = $model->attributes;
                unset($record['auth_key'], $record['password_hash'], $record['password_reset_token']);
                $record['avatar'] = $model->picture_id > 0 ? $model->picture->path : '';
                $record['created_at'] = date('Y-m-d H:i:s', $record['created_at']);
                $record['updated_at'] = date('Y-m-d H:i:s', $record['updated_at']);
                return $record;
            }, $models);
        }
        $result['list'] = isset($list)?$list:[];
        return $result;
    }

    public function actionDetail(array $params)
    {
        $result = $this->user;
        if(!empty($result)) {
            unset($result['auth_key'], $result['password_hash'], $result['password_reset_token']);
            $result['created_at'] = date('Y-m-d H:i:s', $result['created_at']);
            $result['updated_at'] = date('Y-m-d H:i:s', $result['updated_at']);
            $result['avatar'] = $result['picture_id'] > 0 ? User::findOne($result['id'])->picture->path : '';
        }
        return $result;
    }

    public function actionCreate(array $params)
    {
        $model = new User();
        if(!$model->load($params,'query')){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS);
        }
        $password = isset($params['query']['password'])?$params['query']['password']:'';
        if(!$password){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS,'password');
        }
        $model->password_hash = Yii::$app->security->generatePasswordHash($password);
        $model->auth_key = Yii::$app->security->generateRandomString();
        if(!$model->validate() ){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS,json_encode($model->getFirstError()));
        }
        try{
            $model->save();
        }catch(\yii\db\Exception $e){
            RangerException::throwException(RangerException::APP_ERROR_CREATE,$e->getMessage());
        }
        $result = $model->attributes;
        unset($result['auth_key'], $result['password_hash'], $result['password_reset_token']);
        $result['avatar'] = isset($model->picture) && $model->picture != null ? $model->picture->path : '';
        $result['created_at'] = date('Y-m-d H:i:s', $result['created_at']);
        $result['updated_at'] = date('Y-m-d H:i:s', $result['updated_at']);
        return $result;
    }

    public function actionUpdate(array $params)
    {
        $user = $this->user;
        $model = User::findOne($user['id']);
        if(!$model->load($params,'query')){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS);
        }
        $password = isset($params['query']['password'])?$params['query']['password']:'';
        if($password){
            $model->password_hash = Yii::$app->security->generatePasswordHash($password);
            $model->auth_key = Yii::$app->security->generateRandomString();
        }

        try {
            $model->save();
        } catch (\yii\db\Exception $e) {
            RangerException::throwException(RangerException::APP_ERROR_UPDATE, $e->getMessage());
        }
        $result = $model->attributes;
        unset($result['auth_key'], $result['password_hash'], $result['password_reset_token']);
        $result['avatar'] = isset($model->picture)&&$model->picture!=null? $model->picture->path:'';
        $result['created_at'] = date('Y-m-d H:i:s',$result['created_at']);
        $result['updated_at'] = date('Y-m-d H:i:s',$result['updated_at']);
        return $result;
    }

    public function actionDelete(array $params)
    {
        RangerException::throwException(RangerException::APP_FORBID_DELETE);
    }
}