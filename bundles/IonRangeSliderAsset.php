<?php

/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\metronic\bundles;
use dlds\metronic\Metronic;

/**
 * IonRangeSliderAsset for slider widget.
 */
class IonRangeSliderAsset extends BaseAssetBundle {

    const SKIN_METRONIC = 'Metronic';
    const SKIN_FLAT = 'skinFlat';
    const SKIN_HTML5 = 'skinHTML5';
    const SKIN_NICE = 'skinNice';
    const SKIN_MODERN = 'skinModern';
    const SKIN_SIMPLE = 'skinSimple';

    public $js = [
        'global/plugins/ion.rangeslider/js/ion.rangeSlider.js',
    ];

    public $css = [
        'global/plugins/ion.rangeslider/css/ion.rangeSlider.css',
    ];

    public $depends = [
        'dlds\metronic\bundles\CoreAsset',
    ];

    public function init()
    {
        $skin = IonRangeSliderAsset::SKIN_NICE;
        /** @var Metronic $component */
        $component = \Yii::$app->metronic;
        if (isset($component->ionSliderSkin)) {
            $skin = $component->ionSliderSkin;
        }

        $base = 'global/plugins/ion.rangeslider/css/ion.rangeSlider.%s.css';
        $this->css[] = sprintf($base, $skin);

        parent::init();
    }

}
