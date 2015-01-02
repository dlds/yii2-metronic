<?php

use dlds\metronic\Metronic;
use dlds\metronic\widgets\Nav;
use dlds\metronic\widgets\Badge;

/**
 * Topmenu block
 */
?>

<?=

Nav::widget([
    'items' => [
        [
            'label' => Nav::userItem('Administrator', Metronic::getAssetsUrl($this) . '/img/avatar1_small.jpg'),
            'type' => Nav::TYPE_USER,
            'items' => [
                [
                    'icon' => 'icon-calendar',
                    'label' => 'About',
                    'url' => ['/site/about'],
                    'badge' => Badge::widget(['label' => '4', 'type' => Badge::TYPE_DANGER]),
                ],
                ['divider'],
                ['label' => 'Lock Screen', 'icon' => 'icon-lock', 'url' => ['/site/lock']],
                ['label' => 'Logout', 'icon' => 'icon-key', 'url' => ['/site/logout']],
            ]
        ],
    ],
]);
?>