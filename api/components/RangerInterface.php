<?php
namespace api\components;

use yii;

interface RangerInterface
{
    public function actionList(array $params);

    public function actionDetail(array $params);

    public function actionCreate(array $params);

    public function actionUpdate(array $params);

    public function actionDelete(array $params);
}