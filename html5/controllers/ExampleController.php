<?php
namespace html5\controllers;

use yii;
use yii\web\Controller;
use html5\traits\RangerTrait;

/**
 * Ranger controller
 */
class ExampleController extends Controller
{

    public function actionUserLogin()
    {
        print_r(RangerTrait::api('ranger.user.login',[
            'username'=>'STARR',
            'password'=>'123456',
        ]));
    }

    public function actionUserList()
    {
        print_r(RangerTrait::api('ranger.user.list',
            [
                'page_size' => 10,
                'page' => 1,
                'where' => [
                    //['id'=>12],
                    ['<>','id',10]
                ],
                //'access_token' => 'gv3JLDa54hCsLqqk6gwRkwVFIcJl9vpd',
            ],
            [
                'format' => 'json',
                'version' => '1.0',
                'cache' => true,
                'cache_time' => 120,
            ]
        ));
    }

    public function actionUserDetail()
    {
        print_r(RangerTrait::api('ranger.user.detail',[
            'access_token' => '6A4uMU0rxtj0V0rFmKQrmQX6ITEhs0Vk'
        ]));
    }

    public function actionUserCreate()
    {
        print_r(RangerTrait::api('ranger.user.create',[
            'username' => 'STARR',
            'password' => '123456',
            'email' => '67218315@qq.com',
            'mobile' => '18600945045',
        ]));
    }

    public function actionUserUpdate()
    {
        print_r(RangerTrait::api('ranger.user.update',[
            'username' => 'STARR',
            'access_token' => '0mcZIy285iWeFXiJV9ArhrMQinlMcCwZ',
        ]));
    }

    public function actionUserDelete()
    {
        print_r(RangerTrait::api('ranger.user.delete',[
            'username' => 'STARR',
            'access_token' => '0mcZIy285iWeFXiJV9ArhrMQinlMcCwZ',
        ]));
    }

    public function actionMenuList()
    {
        print_r(RangerTrait::api('ranger.menu.list',
            [],
            [
                'format' => 'json',
                'version' => '1.0',
            ]
        ));
    }

    public function actionMenuDetail()
    {
        print_r(RangerTrait::api('ranger.menu.detail',
            [
                'where' => [
                    'id' => 1
                ]
            ]
        ));
    }

    public function actionPageList()
    {
        print_r(RangerTrait::api('ranger.page.list',
            [],
            [
                'format' => 'json',
                'version' => '1.0',
            ]
        ));
    }

    public function actionPageDetail()
    {
        print_r(RangerTrait::api('ranger.page.detail',
            [
                'where' => [
                    'id' => 1
                ]
            ]
        ));
    }

    public function actionArticleList()
    {
        print_r(RangerTrait::api('ranger.article.list',
            [
                'page_size' => 10,
                'page' => 1,
                'where' => [
                    //['id'=>12],
                    ['<>','id',10]
                ],
            ],
            [
                'format' => 'json',
                'version' => '1.0',
                'cache' => true,
                'cache_time' => 120,
            ]
        ));
    }

    public function actionArticleDetail()
    {
        print_r(RangerTrait::api('ranger.article.detail',[
            'where'=>[
                'id' => 1
            ]
        ]));
    }

    public function actionArticleCategoryList()
    {
        print_r(RangerTrait::api('ranger.article-category.list',[]));
    }
}