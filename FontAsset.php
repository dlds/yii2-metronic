<?php
/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals/license/
 */

namespace dlds\metronic;

use yii\web\AssetBundle;

class FontAsset extends AssetBundle
{
    public $sourcePath = '@dlds/metronic/assets';

    public $css = [
        'css/fonts.css',
        'plugins/font-awesome/css/font-awesome.min.css',
    ];
}
