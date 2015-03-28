<?php

/**
 * @link http://www.digitaldeals.cz/
 * @copyright Copyright (c) 2014 Digital Deals s.r.o. 
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\metronic\bundles;

use yii\web\AssetBundle;
use yii\helpers\ArrayHelper;
use dlds\metronic\Metronic;

class StyleBasedAsset extends AssetBundle {

    /**
     * @var string source assets path
     */
    public $sourcePath = '@dlds/metronic/assets';

    /**
     * @var array depended bundles
     */
    public $depends = [
        'dlds\metronic\bundles\CoreAsset',
    ];

    /**
     * @var array css assets
     */
    public $css = [
        'global/css/plugins.css',
    ];

    /**
     * @var array js assets
     */
    public $js = [
            //'scripts/layout.js',
            //'scripts/app.js',
            //'scripts/init.js',
    ];

    /**
     * @var array style based css
     */
    private $styleBasedCss = [
        Metronic::STYLE_SQUARE => [
            'global/css/components.css',
        ],
        Metronic::STYLE_ROUNDED => [
            'global/css/components-rounded.css',
        ],
    ];

    /**
     * Inits bundle
     */
    public function init()
    {
        $this->_handleStyleBased();

        return parent::init();
    }

    /**
     * Handles style based files
     */
    private function _handleStyleBased()
    {
        $this->css = ArrayHelper::merge($this->styleBasedCss[Metronic::getComponent()->style], $this->css);
    }

}
