<?php
/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace  dlds\metronic\bundles;

/**
 * Select2Asset for select2 widget.
 */
class Select2Asset extends BaseAssetBundle
{

    public $js = [
        'global/plugins/select2/js/select2.js',
    ];

    public $css = [
        'global/plugins/select2/css/select2.css',
        'global/plugins/select2/css/select2-bootstrap.min.css',
    ];


    public $depends = [
        'dlds\metronic\bundles\CoreAsset',
    ];
}
