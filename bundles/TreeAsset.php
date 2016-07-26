<?php

/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\metronic\bundles;


class TreeAsset extends BaseAssetBundle {

    /**
     * @var array CSS
     */
    public $css = [
        'global/plugins/jstree/dist/themes/default/style.min.css',
    ];

    public $js = [  
        'global/plugins/jstree/dist/jstree.min.js',
    ];
    
    /**
     * @var array depends on
     */
    public $depends = [
        'dlds\metronic\bundles\CoreAsset',
    ];

}
