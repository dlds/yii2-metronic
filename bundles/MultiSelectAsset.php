<?php
/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals/license/
 */

namespace  dlds\metronic\bundles;

use yii\web\AssetBundle;

/**
 * SpinnerAsset for spinner widget.
 */
class MultiSelectAsset extends AssetBundle
{
    public $sourcePath = '@dlds/metronic/assets';
    public $js = [
        'plugins/jquery-multi-select/js/jquery.multi-select.js',
    ];

    public $css = [
        'plugins/jquery-multi-select/css/multi-select.css',
    ];


    public $depends = [
        'dlds\metronic\bundles\CoreAsset',
    ];
}
