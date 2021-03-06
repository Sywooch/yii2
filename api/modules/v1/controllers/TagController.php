<?php

namespace api\modules\v1\controllers;

use yii;
use api\controllers\RangerController;
use api\components\RangerInterface;
use api\components\RangerException;

class TagController extends RangerController implements RangerInterface
{

    public function actionList(array $params)
    {
        $query = parent::generationQuery(\common\models\Tag::class,$params);
        try {
            $models = $query->orderBy(['total'=>SORT_DESC])->all();
        }catch (\yii\db\Exception $e){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS,$e->getMessage());
        }
        if(!empty($models)) {
            $list = array_map(function ($model) {
                $record = $model->attributes;
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
        RangerException::throwException(RangerException::APP_FORBID_DETAIL);
    }

    public function actionCreate(array $params)
    {
        RangerException::throwException(RangerException::APP_FORBID_CREATE);
    }

    public function actionUpdate(array $params)
    {
        RangerException::throwException(RangerException::APP_FORBID_UPDATE);
    }

    public function actionDelete(array $params)
    {
        RangerException::throwException(RangerException::APP_FORBID_DELETE);
    }
}