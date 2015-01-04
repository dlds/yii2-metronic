<?php
/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals/license/
 */

namespace  dlds\metronic\widgets;

use yii\web\AssetBundle;

/**
 * SpinnerAsset for spinner widget.
 */
class Select2Asset extends AssetBundle
{
    public $sourcePath = '@dlds/metronic/assets';
    public $js = [
        'plugins/select2/select2.min.js',
    ];

    public $css = [
        'plugins/select2/select2.css',
        'plugins/select2/select2-metronic.css',
    ];


    public $depends = [
        'dlds\metronic\CoreAsset',
    ];
}
