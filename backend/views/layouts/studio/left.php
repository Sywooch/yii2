<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
?>


<section class="sidebar-main-wrapper">
    <div class="app-logo">
        <?= Html::a('<i class="glyphicon glyphicon-fire logo-image"></i>', Yii::$app->homeUrl) ?>
    </div>

    <div class="sidebar-main-menu">
        <ul>
            <?php
            $menus = [
                [
                    'label' => '内容管理',
                    'icon' => 'fa fa-paw',
                    'url' => '#',
                    'items' => [
                        ['label' => '菜单管理', 'icon' => 'fa fa-list text-light-blue', 'url' => ['/content/menu/index']],
                        ['label' => '文章管理', 'icon' => 'fa fa-file-text text-light-blue', 'url' => ['/content/article/index']],
                        ['label' => '文章分类', 'icon' => 'fa fa-navicon text-light-blue', 'url' => ['/content/article-category/index']],
                        ['label' => '评论管理', 'icon' => 'fa fa-comments text-light-blue', 'url' => ['/content/comment/index']],
                        ['label' => '单页管理', 'icon' => 'fa fa-file text-light-blue', 'url' => ['/content/page/index']],
                        ['label' => '推荐管理', 'icon' => 'fa fa-coffee text-light-blue', 'url' => ['/content/recommendation-category/index']],
                    ],
                ],
                [
                    'label' => '商品管理',
                    'icon' => 'fa fa-tags',
                    'url' => '#',
                    'items' => [
                        ['label' => '商品管理', 'icon' => 'fa fa-cubes text-maroon', 'url' => ['/product/goods/index']],
                        ['label' => '商品分类', 'icon' => 'fa fa-navicon text-maroon', 'url' => ['/product/goods-category/index']],
                        ['label' => '属性管理', 'icon' => 'fa fa-gears text-maroon', 'url' => ['/product/attribute-name/index']],
                        ['label' => 'SKU管理', 'icon' => 'fa fa-globe text-maroon', 'url' => ['/product/product/index']],
                    ],
                ],
                [
                    'label' => '交易管理',
                    'icon' => 'fa fa-shopping-cart',
                    'url' => '#',
                    'items' => [
                        ['label' => '订单管理', 'icon' => 'fa fa-credit-card text-purple', 'url' => '#'],
                        ['label' => '发货纪录', 'icon' => 'fa fa-paper-plane text-purple', 'url' => '#'],
                        ['label' => '退款纪录', 'icon' => 'fa fa-refresh text-purple', 'url' => '#'],
                    ],
                ],
                [
                    'label' => '用户管理',
                    'icon' => 'fa fa-graduation-cap',
                    'url' => '#',
                    'items' => [
                        ['label' => '用户管理', 'icon' => 'fa fa-user text-orange', 'url' => ['/user/user/index']],
                        ['label' => '员工管理', 'icon' => 'fa fa-user-secret text-orange', 'url' => ['/user/admin/index']],
                    ],
                ],
                [
                    'label' => '角色管理',
                    'icon' => 'fa fa-anchor',
                    'url' => ['/user/role/index'],
                ],
                [
                    'label' => '常用工具',
                    'icon' => 'fa fa-gears',
                    'url' => '#',
                    'items' => [
                        ['label' => '代码生成', 'icon' => 'fa fa-rocket text-olive', 'url' => ['/gii'],],
                        ['label' => '性能调试', 'icon' => 'fa fa-pie-chart text-olive', 'url' => ['/debug'],]
                    ],
                ],

                ['label' => '退出登录', 'url' => ['site/logout'], 'icon'=>'fa fa-power-off text-red', 'visible' => Yii::$app->user->id>0, 'linkOptions' => ['data-method' => 'post']],
            ];

            $module = Yii::$app->controller->module->id;
            $controller = Yii::$app->controller->id;
            $action = Yii::$app->controller->action->id;

            $requested = $module.'/'.$controller.'/'.$action;
            if(!empty($menus)) {
                foreach ($menus as $menu) {
                    $uri = is_array($menu['url'])? $menu['url'][0]:$menu['url'];
                    if( trim($uri, '/') == $requested){
                        $mainMenu = $menu;
                        $subMenu = $menu['items'];
                        echo '<li class="active">';
                    }else{
                        echo '<li>';
                    }
                    echo Html::a('<i class="'.$menu['icon'].'"></i> '.$menu['label'], Url::to($menu['url']));
                    echo '</li>';
                }
            }
            ?>
        </ul>
    </div>

</section>


<?php if(isset($subMenu) && !empty($subMenu)){ ?>
    <section class="sidebar-sub-wrapper">
        <div class="sub-menu-header">
            <?php echo isset($mainMenu['label'])?$mainMenu['label']:'';?>
        </div>
        <div class="sidebar-sub-menu">
            <ul>
                <?php
                //$route = Yii::$app->controller->module->requestedRoute;
                $route = 'text';
                foreach ($subMenu as $menu){
                    $url = is_array($menu['url'])? $menu['url'][0]:$menu['url'];

                    echo $route == $url?'<li class="active">':'<li>';
                    echo Html::a($menu['label'], Url::to($menu['url']));
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    </section>
<?php }?>
