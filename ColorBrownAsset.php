<?php
/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals/license/
 */

namespace dlds\metronic;

use yii\web\AssetBundle;

class ColorBrownAsset extends AssetBundle
{
    public $sourcePath = '@dlds/metronic/assets';

    public $css = [
        'css/plugins.css',
        'css/themes/brown.css',
    ];

    public $depends = [
        'dlds\metronic\CoreAsset',
    ];
}
