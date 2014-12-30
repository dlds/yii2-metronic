<?php
/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals/license/
 */

namespace dlds\metronic;

use yii\web\AssetBundle;

class ColorGrayAsset extends AssetBundle
{
    public $sourcePath = '@dlds/metronic/assets';

    public $css = [
        'css/plugins.css',
        'css/themes/gray.css',
    ];

    public $depends = [
        'dlds\metronic\CoreAsset',
    ];
}
