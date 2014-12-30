<?php
/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals/license/
 */

namespace dlds\metronic;

use yii\web\AssetBundle;

class ColorPurpleAsset extends AssetBundle
{
    public $sourcePath = '@dlds/metronic/assets';

    public $css = [
        'css/plugins.css',
        'css/themes/purple.css',
    ];

    public $depends = [
        'dlds\metronic\CoreAsset',
    ];
}
