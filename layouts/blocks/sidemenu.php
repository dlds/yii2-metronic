<?php

use Yii;
use dlds\metronic\widgets\Menu;

/**
 * Sidemenu block
 */
?>

<?=

Menu::widget([
    'visible' => true,
    'items' => [
        // Important: you need to specify url as 'controller/action',
        // not just as 'controller' even if default action is used.
        ['icon' => 'icon-home', 'label' => 'Dashboard', 'url' => ['site/index']],
        // 'Products' menu item will be selected as long as the route is 'product/index'
        [
            'icon' => 'icon-basket',
            'label' => 'eCommerce',
            'items' => [
                [
                    'label' => 'Dashboard',
                    'url' => ['product/index'],
                    'icon' => 'icon-home',
                ],
                [
                    'label' => 'Orders',
                    'url' => ['product/index'],
                    'icon' => 'icon-basket',
                ],
                [
                    'label' => 'Order View',
                    'url' => ['product/index'],
                    'icon' => 'icon-tag',
                ],
                [
                    'label' => 'Products',
                    'url' => ['product/index'],
                    'icon' => 'icon-handbag',
                ],
                [
                    'label' => 'Product Edit',
                    'url' => ['product/index'],
                    'icon' => 'icon-pencil',
                ],
            ]
        ],
        [
            'icon' => 'icon-rocket',
            'label' => 'Page Layouts',
            'items' => [
                [
                    'label' => 'Buttons & Icons',
                    'url' => ['site/'],
                ],
            ],
        ],
        [
            'icon' => 'icon-user',
            'label' => 'Login',
            'url' => ['site/login'],
            'visible' => Yii::$app->user->isGuest
        ],
        [
            'icon' => 'icon-key',
            'label' => 'Logout',
            'url' => ['site/logout'],
            'visible' => !Yii::$app->user->isGuest
        ],
    ],
]);
?>