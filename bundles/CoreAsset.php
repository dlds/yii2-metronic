<?php

/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\metronic\bundles;

class CoreAsset extends BaseAssetBundle {

    /**
     * @var array depended packages
     */
    public $depends = [
        'dlds\metronic\bundles\FontAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    /**
     * @var array css assets
     */
    public $css = [
        'global/plugins/simple-line-icons/simple-line-icons.min.css',
        // 'global/plugins/bootstrap/css/bootstrap.min.css',
        'global/plugins/bootstrap-switch/css/bootstrap-switch.min.css',
    ];

    /**
     * @var array js options
     */
    public $jsOptions = [
        'conditions' => [
            'plugins/respond.min.js' => 'if lt IE 9',
            'plugins/excanvas.min.js' => 'if lt IE 9',
        ],
    ];

    /**
     * @var array js assets
     */
    public $js = [
        // 'global/plugins/jquery.min.js',
        'global/plugins/jquery-migrate.min.js',
        'global/plugins/jquery-ui/jquery-ui.min.js',
        // 'global/plugins/bootstrap/js/bootstrap.min.js',
        'global/plugins/jquery-slimscroll/jquery.slimscroll.min.js',
        'global/plugins/jquery.blockui.min.js',
        'global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js',
        'global/plugins/bootstrap-switch/js/bootstrap-switch.min.js',



    ];
}
