<?php
/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals/license/
 */

namespace  dlds\metronic\widgets;

use yii\web\AssetBundle;

/**
 * IonRangeSliderAsset for slider widget.
 */
class IonRangeSliderAsset extends AssetBundle
{
    public $sourcePath = '@dlds/metronic/assets';
    public $js = [
        'plugins/ion.rangeslider/js/ion-rangeSlider/ion.rangeSlider.min.js',
    ];

    public  $css = [
        'plugins/ion.rangeslider/css/ion.rangeSlider.css',
        'plugins/ion.rangeslider/css/ion.rangeSlider.Metronic.css',
    ];

    public $depends = [
        'dlds\metronic\CoreAsset',
    ];
}
