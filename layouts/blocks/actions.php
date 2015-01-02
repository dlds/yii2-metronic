<?php

use dlds\metronic\widgets\Badge;
use dlds\metronic\widgets\Button;
use dlds\metronic\widgets\ButtonDropdown;

/**
 * Actions block
 */
?>

<?=

ButtonDropdown::widget([
    'label' => 'Actions',
    'hover' => true,
    'button' => [
        'size' => Button::SIZE_SMALL,
        'type' => Button::TYPE_M_RED_HAZE,
    ],
    'dropdown' => [
        'items' => [
            ['label' => 'New post', 'icon' => 'icon-docs', 'url' => '#'],
            ['label' => 'New comment', 'icon' => 'icon-tag', 'url' => '#'],
            ['label' => 'Share', 'icon' => 'icon-share', 'url' => '#'],
            ['divider'],
            [
                'label' => 'Comments',
                'icon' => 'icon-flag',
                'url' => '#',
                'badge' => Badge::widget(['label' => '4', 'type' => Badge::TYPE_SUCCESS]),
            ],
            [
                'label' => 'Feedback',
                'icon' => 'icon-users',
                'url' => '#',
                'badge' => Badge::widget(['label' => '4', 'type' => Badge::TYPE_INFO]),
            ],
        ],
    ],
]);
?>