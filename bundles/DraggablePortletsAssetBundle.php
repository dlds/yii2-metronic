<?php
/**
 * Created by PhpStorm.
 * User: sgorzaly
 * Date: 27.09.17
 * Time: 10:41
 */

namespace dlds\metronic\bundles;


class DraggablePortletsAssetBundle extends BaseAssetBundle
{
    /**
     * @var array JS
     */
    public $js = [
        'pages/scripts/portlet-draggable.js'
    ];

    public $depends = [
        'dlds\metronic\bundles\CoreAsset',
    ];
}